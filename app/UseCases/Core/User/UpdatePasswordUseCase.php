<?php

namespace App\UseCases\Core\User;

use App\Models\Core\User;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected User $user,
        protected string $password
    )
    {}

    public function action(): User
    {
        $this->user->password = Hash::make($this->password);
        $this->user->save();
        return $this->user;
    }
}
