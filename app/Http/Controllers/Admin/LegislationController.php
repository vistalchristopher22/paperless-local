<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LegislateType;
use App\Http\Controllers\Controller;
use App\Http\Requests\LegislationStoreRequest;
use App\Http\Requests\LegislationUpdateRequest;
use App\Models\Legislation;
use App\Pipes\Legislation\CreateLegislation;
use App\Pipes\Legislation\CreateSponsors;
use App\Pipes\Legislation\UpdateClassificationType;
use App\Pipes\Legislation\UpdateLegislation;
use App\Pipes\Legislation\UpdateSponsors;
use App\Pipes\Ordinance\CreateOrdinance;
use App\Pipes\Ordinance\UpdateOrdinance;
use App\Pipes\Ordinance\UploadFile;
use App\Pipes\Resolution\CreateResolution;
use App\Pipes\Resolution\UpdateResolution;
use App\Repositories\LegislationTypeRepository;
use App\Repositories\SanggunianMemberRepository;
use App\Transformers\LegislationLaraTables;
use App\Utilities\FileUtility;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

final class LegislationController extends Controller
{
    protected readonly LegislationTypeRepository $legislationTypeRepository;

    public function __construct(private readonly SanggunianMemberRepository $sanggunianMemberRepository)
    {
        $this->legislationTypeRepository = app()->make(LegislationTypeRepository::class);
    }


    public function list()
    {
        return Laratables::recordsOf(Legislation::class, LegislationLaraTables::class);
    }


    public function index()
    {
        return view('admin.legislations.index', [
            'spMembers' => $this->sanggunianMemberRepository->get(),
            'types' => $this->legislationTypeRepository->get(),
            'classifications' => LegislateType::cases(),
        ]);
    }

    public function show(int $id)
    {
        $data = Legislation::with(['legislable'])->find($id);
        $file = $data->legislable->file;

        if (FileUtility::isPDF($file)) {
            $outputDirectory = FileUtility::publicDirectoryForViewing();
            return view('admin.legislations.view-attachment', [
                'viewURL' =>  copy($file, $outputDirectory . '/' . basename($file)),
            ]);
        } else {
            $outputDirectory = FileUtility::publicDirectoryForViewing();
            $location = FileUtility::correctDirectorySeparator($file);
            Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');
            return view('admin.legislations.view-attachment', [
                'viewURL' => FileUtility::generatePathForViewing($outputDirectory, basename($file)),
            ]);
        }
    }


    public function create()
    {
        return view('admin.legislations.create', [
            'spMembers' => $this->sanggunianMemberRepository->get(),
            'types' => $this->legislationTypeRepository->get(),
            'classifications' => LegislateType::cases(),
        ]);
    }

    public function store(LegislationStoreRequest $request)
    {
        $pipes = match ($request->classification) {
            LegislateType::ORDINANCE->value => [
                UploadFile::class,
                CreateOrdinance::class,
                CreateLegislation::class,
                CreateSponsors::class,
            ],
            default => [
                UploadFile::class,
                CreateResolution::class,
                CreateLegislation::class,
                CreateSponsors::class,
            ],
        };

        return DB::transaction(function () use ($request, $pipes) {
            return Pipeline::send($request->all())->through($pipes)->then(fn () => back()->with('success', 'You have successfully added a new legislation'));
        });
    }

    public function edit(Legislation $legislation)
    {
        return view('admin.legislations.edit', [
            'legislation' => $legislation,
            'spMembers' => $this->sanggunianMemberRepository->get(),
            'classifications' => LegislateType::values(),
            'types' => $this->legislationTypeRepository->get(),
            'sponsors' => $legislation->sponsors->pluck('id')->toArray(),
            'coAuthor' => $legislation->legislable->co_author,
        ]);
    }


    public function update(LegislationUpdateRequest $request, Legislation $legislation)
    {
        return DB::transaction(function () use ($request, $legislation) {
            $pipes = match ($request->classification) {
                LegislateType::ORDINANCE->value => [
                    UploadFile::class,
                    UpdateOrdinance::class,
                    UpdateClassificationType::class,
                    UpdateLegislation::class,
                    UpdateSponsors::class,
                ],
                default => [
                    UploadFile::class,
                    UpdateResolution::class,
                    UpdateClassificationType::class,
                    UpdateLegislation::class,
                    UpdateSponsors::class,
                ],
            };

            $request->merge(['attachment' => $request->file('attachment'), 'legislation' => $legislation]);

            return Pipeline::send($request->all())->through($pipes)->then(fn () => back()->with('success', 'You have successfully updated the legislation'));
        });
    }

}
