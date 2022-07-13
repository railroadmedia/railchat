<?php

namespace Railroad\Railchat\Services;

use GetStream\StreamChat\Channel;
use GetStream\StreamChat\Client;
use Railroad\Railchat\Factories\StreamClientFactory;

class RailchatService
{
    private StreamClientFactory $streamClientFactory;
    private Client $client;
    private Channel $chatChannel;
    private Channel $questionsChannel;

    private $isConnected = false;

    const ROLE_ADMINISTRATOR = 'admin';
    const ROLE_USER = 'user';
    const BAN_REASON = 'default';

    public function __construct(StreamClientFactory $streamClientFactory)
    {
        $this->streamClientFactory = $streamClientFactory;
    }

    public function connect()
    {
        if ($this->isConnected) {
            return;
        }

        $this->client = $this->streamClientFactory::build();

        $this->chatChannel = $this->client->Channel('messaging', config('railchat.chat_channel_name'));
        $this->questionsChannel = $this->client->Channel('messaging', config('railchat.questions_channel_name'));

        $this->isConnected = true;
    }

    public function createChannel(string $channelName)
    {
        $this->connect();

        $userData = config('railchat.channel_founder');

        $this->client->updateUser($userData);

        $channel = $this->client->Channel('messaging', $channelName);

        $channel->create($userData['id']);
    }

    public function getChannelsList(): array
    {
        $this->connect();

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
        $this->connect();

        $channel = $this->client->Channel('messaging', $channelName);

        $channel->delete();
    }

    public function resetChannel(string $channelName)
    {
        $this->connect();

        $channel = $this->client->Channel('messaging', $channelName);

        $channel->truncate();
    }

    public function getChannelWatcherCount(): int
    {
        $this->connect();

        $channelName = config('railchat.chat_channel_name');

        $watcherCount = 0;

        $channelsListConfig = config('railchat.channels_list');

        $channelsData = $this->client->queryChannels(
            ['id' => $channelName],
            $channelsListConfig['sort'],
            $channelsListConfig['options']
        );

        if (
            isset($channelsData['channels'])
            && isset($channelsData['channels'][0])
            && isset($channelsData['channels'][0]['watcher_count'])
        ) {
            $watcherCount = $channelsData['channels'][0]['watcher_count'];
        }

        return $watcherCount;
    }

    public function getUserToken(
        int $userId,
        string $displayName,
        string $avatarUrl,
        string $profileUrl,
        bool $isAdministrator,
        string $accessLevelName
    ): string {
        $this->connect();

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

        $this->chatChannel->addMembers([$userId]);
        $this->questionsChannel->addMembers([$userId]);

        $token = $this->client->createToken($userId);

        return $token;
    }

    public function banUser($userId)
    {
        $this->connect();

        $this->client
            ->banUser(
                strval($userId),
                [
                    'banned_by_id' => strval(auth()->id()),
                    'reason' => self::BAN_REASON,
                ]
            );

        $this->deleteUserMessages($userId);
    }

    public function unbanUser($userId)
    {
        $this->connect();

        $this->client->unbanUser(strval($userId));
    }

    public function reactivateUser($userId)
    {
        $this->connect();

        $this->client->reactivateUser(strval($userId));
    }

    public function deleteUserMessages($userId)
    {
        $this->connect();

        $this->client->deactivateUser($userId, ['mark_messages_deleted' => true]);
        $this->client->reactivateUser($userId, ['mark_messages_deleted' => false]);

        $this->chatChannel->sendEvent(['type' => 'delete_user_messages'], $userId);
        $this->questionsChannel->sendEvent(['type' => 'delete_user_messages'], $userId);
    }
}
