<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'unassigned_title' => ['nullable', 'min:2'],
            'announcement_title' => ['nullable', 'min:2'],
            'announcement_content' => ['nullable', 'min:2'],
            'file_path' => ['nullable', 'file', 'mimes:pdf,doc,docx,xlsx,xls', 'max:10240'],
            'unassigned_business_content' => ['nullable', 'min:2'],
            'orderBusinessNote' => ['nullable', 'min:2'],
        ];
    }
}
