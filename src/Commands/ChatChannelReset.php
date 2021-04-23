<?php

namespace Railroad\Railchat\Commands;

use Illuminate\Console\Command;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class ChatChannelReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChatChannelReset {channelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all messages for the specified chat channel';

    /**
     * @var RailchatService
     */
    private $railchatService;

    /**
     * ChatChannelReset constructor.
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

        $this->railchatService->resetChannel($channelName);

        $format = "Message history for chat channel: %s has been reset\n";

        $this->info(sprintf($format, $channelName));
    }
}
