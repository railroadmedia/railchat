<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('railchat.route_prefix'),
    'middleware' => config('railchat.route_middleware_admin_groups'),
], function () {

    Route::get(
        '/ban-user',
        Railroad\Railchat\Controllers\AccessController::class . '@banUser'
    )->name('railchat.ban-user');

    Route::post(
        '/unban-user',
        Railroad\Railchat\Controllers\AccessController::class . '@unbanUser'
    )->name('railchat.unban-user');

});
