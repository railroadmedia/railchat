<?php

namespace Railroad\Railchat\Services;

use GetStream\StreamChat\Channel;
use GetStream\StreamChat\Client;
use Railroad\Railchat\Factories\StreamClientFactory;

class RailchatService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Channel
     */
    private $chatChannel;

    /**
     * @var Channel
     */
    private $questionsChannel;

    const ROLE_ADMINISTRATOR = 'admin';
    const ROLE_USER = 'user';

    const BAN_REASON = 'default';

    public function __construct(StreamClientFactory $streamClientFactory)
    {
        $this->client = $streamClientFactory::build();

        $chatChannelName = config('railchat.chat_channel_name');
        $questionsChannelName = config('railchat.questions_channel_name');

        $this->chatChannel = $this->client->Channel('messaging', $chatChannelName);
        $this->questionsChannel = $this->client->Channel('messaging', $questionsChannelName);
    }

    public function createChannel(string $channelName)
    {
        $userData = config('railchat.channel_founder');

        $this->client->updateUser($userData);

        $channel = $this->client->Channel('messaging', $channelName);

        $channel->create($userData['id']);
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

    public function getChannelWatcherCount(): int
    {
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
        $this->client->unbanUser(strval($userId));
    }

    public function reactivateUser($userId)
    {
        $this->client->reactivateUser(strval($userId));
    }

    public function deleteUserMessages($userId)
    {
        $this->client->deactivateUser($userId, ['mark_messages_deleted' => true]);
        $this->client->reactivateUser($userId, ['mark_messages_deleted' => false]);

        $this->chatChannel->sendEvent(['type' => 'delete_user_messages'], $userId);
        $this->questionsChannel->sendEvent(['type' => 'delete_user_messages'], $userId);
    }
}
