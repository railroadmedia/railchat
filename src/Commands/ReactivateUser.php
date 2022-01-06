<?php

namespace Railroad\Railchat\Commands;

use Illuminate\Console\Command;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class ReactivateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RailChat:ReactivateUser {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reactivate a user ID.';

    /**
     * @var RailchatService
     */
    private $railchatService;

    /**
     * ReactivateUser constructor.
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

        $this->railchatService->reactivateUser($userId);

        $this->info('Unbanned user: ' . $userId);
    }
}
