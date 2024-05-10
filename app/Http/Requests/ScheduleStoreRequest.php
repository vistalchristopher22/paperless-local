<?php

namespace App\Http\Requests;

use App\Enums\ScheduleType;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
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
            'selected_date'     => ['required', 'date'],
            'venue'             => ['required', 'exists:venues,id'],
            'type'              => ['required', 'in:' . implode(',', ScheduleType::values())],
            'reference_session' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'selected_date'     => 'Selected Date',
            'venue'             => 'Venue',
            'type'              => 'Type',
            'reference_session' => 'Session Number',
        ];
    }
}
