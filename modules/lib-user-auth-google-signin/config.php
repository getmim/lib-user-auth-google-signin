<?php

return [
    '__name' => 'lib-user-auth-google-signin',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-user-auth-google-signin.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-user-auth-google-signin' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => NULL
            ],
            [
                'lib-user' => NULL
            ]
        ],
        'optional' => [],
        'composer' => [
            'google/apiclient' => '^2.9'
        ]
    ],
    '__inject' => [
        [
            'name' => 'libUserAuthGoogleSignin',
            'children' => [
                [
                    'name' => 'client',
                    'children' => [
                        [
                            'name' => 'id',
                            'question' => 'Google Login ClientID',
                            'rule' => '!^.+$!'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibUserAuthGoogleSignin\\Model' => [
                'type' => 'file',
                'base' => 'modules/lib-user-auth-google-signin/model'
            ],
            'LibUserAuthGoogleSignin\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-user-auth-google-signin/library'
            ]
        ],
        'files' => []
    ]
];
