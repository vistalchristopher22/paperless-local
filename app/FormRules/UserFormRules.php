<?php

namespace App\FormRules;

trait UserFormRules
{
    public static function rules()
    {
        return [
            'POST' => [
                'first_name' => ['required'],
                'middle_name' => ['nullable', 'min:2'],
                'last_name' => ['required'],
                'suffix' => ['nullable', 'min:2'],
                'username' => ['required', 'unique:users,username'],
                'password' => ['nullable', 'min:8'],
                'account_type' => ['required' ],
                'status' => ['required'],
                'division' => ['required', 'exists:divisions,id'],
            ],
            'PUT' => [
                'first_name' => ['required'],
                'middle_name' => ['nullable', 'min:2'],
                'last_name' => ['required'],
                'suffix' => ['nullable', 'min:2'],
                'username' => ['required', 'unique:users,username,' . request()->route()?->parameter('account')?->id],
                'password' => ['nullable', 'min:8'],
                'account_type' => ['required'],
                'status' => ['required'],
                'division' => ['required']
            ],
        ];
    }
}
