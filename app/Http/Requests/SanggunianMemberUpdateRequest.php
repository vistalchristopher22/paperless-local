<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SanggunianMemberUpdateRequest extends FormRequest
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
            'fullname' => 'required',
            'district' => 'required',
            'sanggunian' => 'required',
            'username' => ['required', 'unique:sanggunian_members,username,' . request()->sanggunian_member->id],
            'password' => 'nullable',
        ];
    }
}
