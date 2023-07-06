<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommitteeRequest extends FormRequest
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
            // 'priority_number'    => ['required', Rule::unique('committees')->ignore($this->user)->whereNull('deleted_at')],
            'name' => ['required'],
            // 'schedule'           => ['required'],
            'file' => ['nullable', 'mimes:doc,docx,pdf'],
            'lead_committee' => ['required', 'exists:agendas,id'],
            'expanded_committee' => ['required', 'exists:agendas,id'],
        ];
    }
}
