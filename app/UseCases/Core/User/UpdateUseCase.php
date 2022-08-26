<?php

namespace App\UseCases\Core\User;

use App\Models\Core\User;
use Illuminate\Support\Facades\Hash;

class UpdateUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected User $user,
        protected ?string $email = null,
        protected ?string $name = null,
        protected ?string $password = null
    )
    {}

	public function action(): User
	{
		$this->user->email = $this->email ?? $this->user->email;
        $this->user->name = $this->name ?? $this->user->name;
        $this->user->password = $this->password ?Hash::make($this->password) : $this->user->password;
        $this->user->save();
        return $this->user;
	}
}
