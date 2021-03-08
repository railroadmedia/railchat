<?php

return [
    'get_stream_credentials' => [
        'key' => env('STREAM_API_KEY'),
        'secret' => env('STREAM_APP_SECRET'),
    ],

    'channel_name' => 'test',

    'channel_founder' => [
        'id' => '150259',
        'displayName' => 'bogdan.d',
        'avatarUrl' => 'https://d2vyvo0tyx8ig5.cloudfront.net/avatars/150259_1557736362228.jpg',
        'profileUrl' => 'https://dev.drumeo.com/laravel/public/members/profile/150259',
        'role' => 'admin',
    ],

    // https://getstream.io/chat/docs/query_channels/?language=php
    'channels_list' => [
        'filter' => new \stdClass(), // if no filter is specified, API requires an empty JSON object, empty array is not supported
        'sort' => [],
        'options' => [
            'state' => false,
            'message_limit' => 0,
            'member_limit' => 0,
        ],
    ],

    'route_prefix' => 'chat',
    'route_middleware_logged_in_groups' => [],

    // permissions
    'role_abilities' => [
        'administrator' => [
            'chat.ban_user',
            'chat.unban_user',
        ],
    ],
];
