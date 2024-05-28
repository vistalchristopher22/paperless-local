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
        $id = $this->route('legislation')?->id;
        return [
            'sessionDate' => ['required'],
            'classification' => ['required', Rule::in(LegislateType::values())],
            'reference_no' => ['required', 'unique:legislations,reference_no,' . $id],
            'title' => ['required'],
            'type' => ['required', Rule::exists('types', 'id')],
            'author' => ['nullable', Rule::exists('sanggunian_members', 'id')],
            'sponsors' => ['nullable'],
            'description' => ['required', 'max:200'],
            'attachment' => ['nullable'],
        ];
    }
}
