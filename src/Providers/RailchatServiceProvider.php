<?php

namespace Railroad\Railchat\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Railroad\Railchat\Commands\ChatChannelCreate;
use Railroad\Railchat\Commands\ChatChannelList;
use Railroad\Railchat\Commands\ChatChannelRemove;
use Railroad\Railchat\Commands\ChatChannelReset;
use Railroad\Railchat\Commands\ChatDev;
use Railroad\Railchat\Commands\ReactivateUser;
use Railroad\Railchat\Commands\UnbanUser;

class RailchatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->publishes(
            [
                __DIR__ . '/../../config/railchat.php' => config_path('railchat.php'),
            ]
        );

        // commands
        $this->commands(
            [
                UnbanUser::class,
                ReactivateUser::class,
                ChatChannelCreate::class,
                ChatChannelList::class,
                ChatChannelRemove::class,
                ChatChannelReset::class,
                ChatDev::class,
            ]
        );

        //load package routes file
        $this->loadRoutesFrom(__DIR__ . '/../../routes/app.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/chat.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
