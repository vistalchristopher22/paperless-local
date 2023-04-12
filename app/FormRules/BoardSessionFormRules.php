<?php

namespace App\FormRules;

trait BoardSessionFormRules
{
    public const RULES = [
        'order_business' => [
            'POST' => [
                'title'     => 'required|string|max:255',
                'content'   => 'required|string',
                'published' => 'nullable|min:2',
            ],

            'PUT' => [
                'title'     => 'required|string|max:255',
                'content'   => 'required|string',
                'published' => 'nullable|min:2',
            ],
        ],

        'unassigned_business' => [
            'POST' => [
                'unassigned_title' => 'required|string|max:255',
                'unassigned_business' => 'required|string',
            ],

            'PUT' => [
                'unassigned_title' => 'required|string|max:255',
                'unassigned_business' => 'required|string',
            ],
        ],

        'announcement' => [
            'POST' => [
                'announcement_title' => 'required|string|max:255',
                'announcement_content' => 'required|string',
            ],
        ]
    ];
}
