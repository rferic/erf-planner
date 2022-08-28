<?php

namespace App\Observers\Core;

use App\Models\Core\User;
use Labelgrup\LaravelUtilities\Helpers\Image;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\Core\User  $user
     * @return void
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\Core\User  $user
     * @return void
     */
    public function updated(User $user): void
    {
        if ($user->isDirty('image') && $user->getOriginal('image')) {
            Image::destroy($user->getOriginal('image'));
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\Core\User  $user
     * @return void
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\Core\User  $user
     * @return void
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\Core\User  $user
     * @return void
     */
    public function forceDeleted(User $user): void
    {
        Image::destroy($user->getOriginal('image'));
    }
}
