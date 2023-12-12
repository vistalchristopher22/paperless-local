<?php

namespace App\Http\Requests;

use App\Rules\CheckFilename;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommitteeRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'file' => ['nullable', new CheckFilename(), 'mimes:docx,pdf'],
            'lead_committee' => ['required', 'exists:agendas,id'],
            'expanded_committee' => ['nullable'],
        ];
    }
}
