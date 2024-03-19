<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

 Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
     return (int) $user->id === (int) $id;
 });

Broadcast::channel('m-chat', function ($user) {
    return auth()->check();
});


Broadcast::channel('private-chat.{receiver_id}', function ($user, $receiver_id) {
    Log::info($user->email);
    return auth()->check();
});
