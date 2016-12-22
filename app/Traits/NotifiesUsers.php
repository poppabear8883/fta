<?php

namespace App\Traits;

use App\Notifications\UserRegistered;
use App\User;

trait NotifiesUsers {
    public function notifyUserRegistered(User $user) {
        $user->notify(new UserRegistered());
    }
}