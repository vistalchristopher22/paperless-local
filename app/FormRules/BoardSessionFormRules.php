<?php

namespace App\FormRules;

trait BoardSessionFormRules
{
    protected static function rules(): array
    {
        return [
            "POST" => [
                'title' => ['required', 'string', 'max:255'],
                'published' => ['nullable', 'min:2'],
                'file_path' => ['required'],
                'unassigned_title' => ['nullable', 'min:2', 'string', 'max:255'],
                'unassigned_business' => ['nullable', 'min:2', 'string'],
                'announcement_title' => ['nullable', 'min:2', 'string', 'max:255'],
                'announcement_content' => ['nullable', 'min:2', 'string'],
            ]
        ];
    }
}
