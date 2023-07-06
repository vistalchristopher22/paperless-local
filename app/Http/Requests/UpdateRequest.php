<?php

namespace App\Http\Requests;

use App\Contracts\FormRules\DiscoverRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'first_name' => ['required'],
            'middle_name' => ['nullable', 'min:2'],
            'last_name' => ['required'],
            'suffix' => ['nullable', 'min:2'],
            'username' => ['required', 'unique:users,username,' . request()->route()?->parameter('account')?->id],
            'password' => ['nullable', 'min:8'],
            'account_type' => ['required'],
            'status' => ['required'],
            'division' => ['required']
        ];
    }
}
