<?php

return [
    'scopes' => [
        'active_workflow_for_task_type' => [
            'loggedUser' => \App\Components\ExpressionLanguage\Variables\LoggedUser::class,
            'loggedUserGroups' => \App\Components\ExpressionLanguage\Variables\LoggedUserGroups::class,
        ],
        'task_transition_condition' => [
            'loggedUser' => \App\Components\ExpressionLanguage\Variables\LoggedUser::class,
            'loggedUserGroups' => \App\Components\ExpressionLanguage\Variables\LoggedUserGroups::class,
        ]
    ]
];
