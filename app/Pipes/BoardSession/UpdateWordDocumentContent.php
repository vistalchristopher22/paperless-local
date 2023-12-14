<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;

final class UpdateWordDocumentContent implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        $boardSession = $payload['boardSession'];
        try {
            if (isset($boardSession->file_template)) {
                $template = new TemplateProcessor($boardSession->file_template);
                $this->updateContent($template, $payload, 'unassigned', 'unassigned_business_content');
                $this->updateContent($template, $payload, 'announcement', 'announcement_content');
                $template->saveAs($boardSession->file_path);
            }
        } catch (CopyFileException | CreateTemporaryFileException $e) {
            Log::info('Something went wrong in board session update word document : ' . $e->getMessage());
        }

        return $next($payload);
    }

    private function updateContent(TemplateProcessor $template, array $payload, string $placeholder, string $contentKey): void
    {
        if (isset($payload[$contentKey])) {
            $content = html_entity_decode(Str::of($payload[$contentKey])->stripTags()->value(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $template->setValue($placeholder, $content);
        }
    }
}
