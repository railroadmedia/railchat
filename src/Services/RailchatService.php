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

    public function createChannel(): string
    {
        $userData = config('railchat.channel_founder');

        $this->client->updateUser($userData);

        $channelName = config('railchat.channel_name');

        $channel = $this->client->Channel('messaging', $channelName);

        $channel->create($userData['id']);

        return $channelName;
    }

    public function getChannelsList(): array
    {
        $channelsListConfig = config('railchat.channels_list');

        $channels = $this->client->queryChannels(
            $channelsListConfig['filter'],
            $channelsListConfig['sort'],
            $channelsListConfig['options']
        );

        return $channels['channels'];
    }

    public function removeChannel(string $channelName)
    {
        $channel = $this->client->Channel('messaging', $channelName);

        $channel->delete();
    }

    public function resetChannel(string $channelName)
    {
        $channel = $this->client->Channel('messaging', $channelName);

        $channel->truncate();
    }

    public function getChannelMembersCount(): int
    {
        $channelName = config('railchat.channel_name');

        $channel = $this->client->Channel('messaging', $channelName);

        $membersData = $channel->queryMembers();

        return count($membersData['members']);
    }

    public function getUserToken(
        int $userId,
        string $displayName,
        string $avatarUrl,
        string $profileUrl,
        bool $isAdministrator,
        string $accessLevelName
    ): string {
        $channelName = config('railchat.channel_name');

        $userId = strval($userId);

        $userData = [
            'id' => $userId,
            'role' => $isAdministrator ? self::ROLE_ADMINISTRATOR : self::ROLE_USER,
            'displayName' => $displayName,
            'avatarUrl' => $avatarUrl,
            'profileUrl' => $profileUrl,
            'accessLevelName' => $accessLevelName
        ];

        $this->client->updateUser($userData);

        $channel = $this->client->Channel('messaging', $channelName);

        $channel->addMembers([$userId]);

        $token = $this->client->createToken($userId);

        return $token;
    }
}
