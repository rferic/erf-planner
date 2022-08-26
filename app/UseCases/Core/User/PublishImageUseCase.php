<?php

namespace App\UseCases\Core\User;

use App\Models\Core\User;
use Illuminate\Http\UploadedFile;
use Labelgrup\LaravelUtilities\Helpers\Image;

class PublishImageUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected User $user,
        protected ?UploadedFile $file
    )
    {}

	public function action(): User
	{
        if ($this->file) {
            $src = Image::store($this->file, $this->user->image_folder, 'public');
        }

        $this->user->image = $this->file ? $src : null;
        $this->user->save();
        return $this->user;
	}
}
