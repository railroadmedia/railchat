<?php

namespace Railroad\Railchat\Factories;

use GetStream\StreamChat\Client;

class StreamClientFactory
{
    public static function build()
    : Client
    {
        $credentials = config('railchat.get_stream_credentials');

        return new Client($credentials['key'], $credentials['secret']);
    }
}
