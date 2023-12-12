<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Legislation;
use App\Enums\LegislateType;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\DB;
use App\Pipes\Ordinance\UploadFile;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\Artisan;
use App\Pipes\Ordinance\CreateOrdinance;
use App\Pipes\Ordinance\UpdateOrdinance;
use Illuminate\Support\Facades\Pipeline;
use App\Pipes\Legislation\CreateSponsors;
use App\Pipes\Legislation\UpdateSponsors;
use App\Pipes\Resolution\CreateResolution;
use App\Pipes\Resolution\UpdateResolution;
use App\Transformers\LegislationLaraTables;
use App\Pipes\Legislation\CreateLegislation;
use App\Pipes\Legislation\UpdateLegislation;
use App\Http\Requests\LegislationStoreRequest;
use App\Http\Requests\LegislationUpdateRequest;
use App\Repositories\LegislationTypeRepository;
use App\Repositories\SanggunianMemberRepository;
use App\Pipes\Legislation\UpdateClassificationType;

final class LegislationController extends Controller
{
    protected readonly LegislationTypeRepository $legislationTypeRepository;

    public function __construct(private readonly SanggunianMemberRepository $sanggunianMemberRepository)
    {
        $this->legislationTypeRepository = app()->make(LegislationTypeRepository::class);
    }


    public function index()
    {
        $author = (int) request()->author;
        $type = (int) request()->type;
        $fromDate = request()->from_date;
        $toDate = request()->to_date;

        $data = Legislation::with(['sponsors', 'legislable', 'legislable.author_information', 'legislable.co_author_information', 'legislable.record_type'])->when($author != 0, function ($query) {
            $query->whereHas('legislable', function ($query) {
                $query->whereHas('author_information', function ($query) {
                    $query->where('id', request()->author);
                });
            });
        })->when(request()->has('classification') && request()->classification != 'null', function ($query) {
            $query->where('classification', request()->classification);
        })->when($type != 0, function ($query) {
            $query->whereHas('legislable', function ($query) {
                $query->whereHas('record_type', function ($query) {
                    $query->where('id', request()->type);
                });
            });
        })->when($fromDate != '', function ($query) {
            $query->whereHas('legislable', function ($query) {
                return $query->whereDate('session_date', '>=', request()->from_date);
            });
        })->when($toDate != '', function ($query) {
            $query->whereHas('legislable', function ($query) {
                return $query->whereDate('session_date', '<=', request()->to_date);
            });
        })->paginate(10);




        return Inertia::render('LegislationIndex', [
            'legislations' => $data,
            'spMembers' => $this->sanggunianMemberRepository->get(),
            'types' => $this->legislationTypeRepository->get(),
            'classifications' => LegislateType::cases(),
            'author' => request()->author ?? '',
            'classification' => request()->classification == 'null' ? '' : request()->classification,
            'type' => request()->type ?? '',
            'fromDate' => request()->from_date ?? '',
            'toDate' => request()->to_date ?? '',
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
        return Inertia::render('LegislationCreate', [
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
        return Inertia::render('LegislationEdit', [
            'legislation' => $legislation,
            'spMembers' => $this->sanggunianMemberRepository->get(),
            'classifications' => LegislateType::values(),
            'types' => $this->legislationTypeRepository->get(),
            'sponsors' => $legislation->sponsors->pluck('id')->toArray(),
            'coAuthor' => $legislation->legislable->co_author,
        ]);
    }

    public function updateLegislation(LegislationUpdateRequest $request, Legislation $legislation)
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
