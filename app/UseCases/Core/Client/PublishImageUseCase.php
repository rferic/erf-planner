<?php

namespace App\UseCases\Core\Client;

use App\Models\Core\Client;
use Illuminate\Http\UploadedFile;
use Labelgrup\LaravelUtilities\Helpers\Image;

class PublishImageUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Client $client,
        protected ?UploadedFile $file
    )
    {}

    public function action(): Client
    {
        $this->client->image = $this->file
            ? Image::store($this->file, $this->client->image_folder, 'public')
            : null;
        $this->client->save();
        return $this->client;
    }
}
