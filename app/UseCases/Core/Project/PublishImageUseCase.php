<?php

namespace App\UseCases\Core\Project;

use App\Models\Core\Project;
use Illuminate\Http\UploadedFile;
use Labelgrup\LaravelUtilities\Helpers\Image;

class PublishImageUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Project $project,
        protected ?UploadedFile $file
    )
    {}

    public function action(): Project
    {
        $this->project->image = $this->file
            ? Image::store($this->file, $this->project->image_folder, 'public')
            : null;
        $this->project->save();
        return $this->project;
    }
}
