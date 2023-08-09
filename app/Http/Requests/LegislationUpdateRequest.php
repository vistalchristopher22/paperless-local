<?php

namespace App\Http\Requests;

use App\Enums\LegislateType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LegislationUpdateRequest extends FormRequest
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
            'sessionDate' => ['required'],
            'classification' => ['required', Rule::in(LegislateType::values())],
            'title' => ['required'],
            'type' => ['required', Rule::exists('types', 'id')],
            'author' => ['required', Rule::exists('sanggunian_members', 'id')],
            'description' => ['required', 'max:200'],
            'attachment' => ['nullable', 'mimes:pdf,doc,docx,txt'],
        ];
    }
}
