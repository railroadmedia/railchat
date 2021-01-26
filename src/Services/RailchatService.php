<?php

namespace Railroad\Railchat\Services;

use GetStream\StreamChat\Client;

class RailchatService
{
    /**
     * @var Client
     */
    private $client;

    const ROLE_ADMINISTRATOR = 'admin';
    const ROLE_USER = 'user';

    public function __construct()
    {
        $credentials = config('railchat.get_stream_credentials');

        $this->client = new Client($credentials['key'], $credentials['secret']);
    }

    public function updateChannel($channel)
    {

    }

    public function getUserToken($userId, $displayName, $avatarUrl, $profileUrl, $isAdministrator, $channelName)
    {
        $userId = strval($userId);

        $userData = [
            'id' => $userId,
            'role' => $isAdministrator ? self::ROLE_ADMINISTRATOR : self::ROLE_USER,
            'displayName' => $displayName,
            'avatarUrl' => $avatarUrl,
            'profileUrl' => $profileUrl,
        ];

        $this->client->updateUser($userData);

        $channel = $this->client->Channel('messaging', $channelName);

        // $channel->create($userId);
        $channel->addMembers([$userId]);

        $token = $this->client->createToken($userId);

        return $token;
    }
}
