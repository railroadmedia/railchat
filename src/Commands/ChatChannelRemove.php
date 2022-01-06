<?php

namespace Railroad\Railchat\Commands;

use Illuminate\Console\Command;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class ChatChannelRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RailChat:ChatChannelRemove {channelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the chat channel';

    /**
     * @var RailchatService
     */
    private $railchatService;

    /**
     * ChatChannelRemove constructor.
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
        $channelName = $this->argument('channelName');

        $this->railchatService->removeChannel($channelName);

        $format = "Removed chat channel: %s\n";

        $this->info(sprintf($format, $channelName));
    }
}
