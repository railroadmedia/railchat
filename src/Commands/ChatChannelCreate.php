<?php

namespace Railroad\Railchat\Commands;

use Illuminate\Console\Command;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class ChatChannelCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChatChannelCreate';

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
     * ChatChannelCreate constructor.
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
        $channelName = $this->railchatService->createChannel();

        $format = "Created chat channel: %s\n";

        $this->info(sprintf($format, $channelName));
    }
}
