<?php

namespace Railroad\Railchat\Commands;

use Illuminate\Console\Command;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class UnbanUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UnbanUser {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unban a user ID.';

    /**
     * @var RailchatService
     */
    private $railchatService;

    /**
     * UnbanUser constructor.
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
        $userId = $this->argument('userId');

        $this->railchatService->unbanUser($userId);

        $this->info('Unbanned user: ' . $userId);
    }
}
