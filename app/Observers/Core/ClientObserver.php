<?php

namespace App\Observers\Core;

use App\Models\Core\Client;
use Labelgrup\LaravelUtilities\Helpers\Image;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     *
     * @param  \App\Models\Core\Client  $client
     * @return void
     */
    public function created(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "updated" event.
     *
     * @param  \App\Models\Core\Client  $client
     * @return void
     */
    public function updated(Client $client): void
    {
        if ($client->isDirty('image') && $client->getOriginal('image')) {
            Image::destroy($client->getOriginal('image'));
        }
    }

    /**
     * Handle the Client "deleted" event.
     *
     * @param  \App\Models\Core\Client  $client
     * @return void
     */
    public function deleted(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "restored" event.
     *
     * @param  \App\Models\Core\Client  $client
     * @return void
     */
    public function restored(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "force deleted" event.
     *
     * @param  \App\Models\Core\Client  $client
     * @return void
     */
    public function forceDeleted(Client $client): void
    {
        Image::destroy($client->getOriginal('image'));
    }
}
