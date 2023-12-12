<?php

namespace App\Http\Requests;

use App\Enums\LegislateType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LegislationStoreRequest extends FormRequest
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
            'sessionDate' => ['required', 'date'],
            'classification' => ['required', Rule::in(LegislateType::values())],
            'title' => ['required'],
            'type' => ['required', 'numeric', Rule::exists('types', 'id')],
            'co_author' => ['nullable', 'numeric', Rule::exists('sanggunian_members', 'id')],
            'author' => ['nullable', 'numeric', Rule::exists('sanggunian_members', 'id')],
            'sponsors' => ['nullable'],
            'description' => ['required', 'max:200'],
            'attachment' => ['required', 'mimes:pdf,doc,docx,txt'],
        ];
    }
}
