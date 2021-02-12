<?php

namespace Railroad\Railchat\Commands;

use Faker\Generator;
use GetStream\StreamChat\Channel;
use GetStream\StreamChat\Client;
use Illuminate\Console\Command;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class ChatDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChatDev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chat development command';

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * ChatChannelReset constructor.
     *
     * @param RailchatService $railchatService
     */
    public function __construct(
        Generator $faker,
        RailchatService $railchatService
    ) {
        parent::__construct();

        $this->faker = $faker;

        $credentials = config('railchat.get_stream_credentials');

        $this->client = new Client($credentials['key'], $credentials['secret']);

        $channelName = config('railchat.channel_name');

        $this->channel = $this->client->Channel('messaging', $channelName);
    }

    /**
     * Execute the console command.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $this->seedUsers();
        $this->seedReactions('4a7b785d-f2d1-49ef-b064-71b4802ce501');

        $this->info('Finished ChatDev');
    }

    protected function seedUsers()
    {
        $usersData = [];
        $usersIds = [];

        for ($i=0; $i < 90; $i++) {
            $userId = 'test-' . $i;
            $usersData[] = [
                'id' => $userId,
                'role' => 'user',
                'displayName' => $this->faker->name,
                'avatarUrl' => 'https://s3.amazonaws.com/pianote/defaults/avatar.png',
                'profileUrl' => 'https://dev.drumeo.com/members/',
                'accessLevelName' => $this->faker->randomElement(['coach', 'edge', 'lifetime']),
            ];
            $usersIds[] = $userId;
        }

        $this->client->updateUsers($usersData);
        $this->channel->addMembers($usersIds);
    }

    protected function seedReactions($messageId)
    {
        $reactions = ['angry', 'heart', 'laugh', 'thumb', 'sad', 'surprised'];

        for ($i=0; $i < 40; $i++) {

            $userId = 'test-' . $this->faker->numberBetween(0, 89);
            $reaction = $this->faker->randomElement($reactions);

            try {
                $this->channel
                    ->sendReaction(
                        $messageId,
                        ['type' => $reaction],
                        $userId
                    );

                $format = "Seeded reaction: %s, using user id: %s";

                $this->info(sprintf($format, $reaction, $userId));

            } catch (Throwable $ex) {

                $format = "Exception seesing reaction: %s, using user id: %s, message: %s";

                $this->error(sprintf($format, $reaction, $userId, $exception->getMessage()));
            }

            sleep(2);
        }
    }
}
