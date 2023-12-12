<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Utilities\FileUtility;
use App\Models\CommitteeFileLink;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\BoardSessionCommitteeLink;

final class FileLinkService
{
    private function pdfConvert(string $outputDirectory, string $path)
    {
        Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($path) . '" --output="' . $outputDirectory . '"');
    }

    public function generateFileForViewing(string $outputDirectory, string $path): string
    {
        if (!FileUtility::isPDF($path)) {
            $this->pdfConvert($outputDirectory, $path);
            return FileUtility::generatePathForViewing($outputDirectory, FileUtility::changeExtension(basename($path)));
        }
        return FileUtility::generatePathForViewing($outputDirectory, FileUtility::changeExtension(basename($path)));
    }


    /**
     * Generate file for viewing if it doesn't have a committee.
     *
     * @param string $outputDirectory The output directory for the file.
     * @param BoardSessionCommitteeLink|CommitteeFileLink $fileLink The committee file link.
     * @return void
     */
    public function notHavingCommittee(string $outputDirectory, BoardSessionCommitteeLink|CommitteeFileLink $fileLink)
    {
        // Check if the file exists in the public path
        if (file_exists($fileLink->public_path)) {
            return $this->generateFileForViewing($outputDirectory, $fileLink->public_path);
        }

        // Find files in the source directory
        $finder = new Finder();
        $files = iterator_to_array($finder->files()->in(Storage::path('source')));

        $fileReplacedExtension = Str::replace('pdf', 'docx', (basename($fileLink->public_path)));

        // Filter the found files based on the replaced extension
        $filtered = array_filter($files, fn ($file) => $file->getFilename() === $fileReplacedExtension);

        // If filtered files are found, update the public path and generate file for viewing
        if (count($filtered) > 0) {
            $findPath = reset($filtered)->getPath() . DIRECTORY_SEPARATOR . basename($fileLink->public_path);
            $fileLink->update(['public_path' => $outputDirectory . basename(FileUtility::changeExtension($findPath))]);
            return $this->generateFileForViewing($outputDirectory, Str::replace('pdf', 'docx', $findPath));
        }
    }
}
