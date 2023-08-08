<?php

namespace App\Pipes\BoardSession;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Contracts\Pipes\IPipeHandler;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;

final class CreateWordDocumentContent implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        try {
            $template = new TemplateProcessor($payload['session']['file_template']);
            $this->updateContent($template, $payload, 'unassigned', 'unassigned_business_content');
            $this->updateContent($template, $payload, 'announcement', 'announcement_content');
            $template->saveAs($payload['session']['file_path']);

        } catch (CopyFileException|CreateTemporaryFileException $e) {
            Log::info('Something went wrong in board session create word document : ' . $e->getMessage());
        }
        return $next($payload);
    }

    private function updateContent(TemplateProcessor $template, array $payload, string $placeholder, string $contentKey): void
    {
        $content = html_entity_decode(Str::of($payload[$contentKey])->stripTags()->value(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $template->setValue($placeholder, $content);
    }

}
