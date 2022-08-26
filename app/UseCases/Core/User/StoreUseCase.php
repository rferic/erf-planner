<?php

namespace App\UseCases\Core\User;

use App\Models\Core\User;
use Illuminate\Support\Facades\Hash;

class StoreUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected string $email,
        protected string $name,
        protected string $password
    )
    {}

	public function action(): User
	{
		return User::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ]);
	}
}
