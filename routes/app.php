<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('railchat.app_route_prefix'),
    'middleware' => config('railchat.app_route_middleware_logged_in_groups'),
], function () {

    Route::post(
        '/ban-user',
        Railroad\Railchat\Controllers\AccessController::class . '@banUser'
    )->name('railchat.app-ban-user');

    Route::post(
        '/unban-user',
        Railroad\Railchat\Controllers\AccessController::class . '@unbanUser'
    )->name('railchat.app-unban-user');

     Route::post(
        '/delete-user-messages',
        Railroad\Railchat\Controllers\AccessController::class . '@deleteUserMessages'
    )->name('railchat.app-delete-user-messages');

});
