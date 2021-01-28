<?php

namespace Railroad\Railchat\Commands;

use Illuminate\Console\Command;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class ChatChannelList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChatChannelList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the chat channel';

    /**
     * @var RailchatService
     */
    private $railchatService;

    /**
     * ChatChannelList constructor.
     *
     * @param RailchatService $railchatService
     */
    public function __construct(RailchatService $railchatService)
    {
        parent::__construct();

        $this->railchatService = $railchatService;
    }

    /**
     * Execute the console command.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $channelsData = $this->railchatService->getChannelsList();

        foreach ($channelsData as $channelData) {

            $format = "Channel name/id: %s, type: %s, created by: %s";

            $this->info(
                sprintf(
                    $format,
                    $channelData['channel']['id'],
                    $channelData['channel']['type'],
                    $channelData['channel']['created_by']['displayName']
                )
            );
        }

        $this->info("Finished chat channel list\n");
    }
}
