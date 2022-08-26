<?php

namespace App\Console\Commands;

use App\Models\Core\User;
use App\UseCases\Core\User\SyncRolesUseCase;
use App\UseCases\Core\User\StoreUseCase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Labelgrup\LaravelUtilities\Helpers\Password;
use Spatie\Permission\Models\Role;

class MakeUser extends Command
{
    public const RETRIES = 1;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {email?} {name?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user ({email?} {name?} {password?})';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $roles = Role::all()->pluck('name')->toArray();

        if (empty($roles)) {
            $this->error('No roles found');
            return false;
        }

        $email = $this->argument('email');
        $name = $this->argument('name');
        $password = $this->argument('password');

        try {
            [$email, $name, $password] = $this->askData($email, $name, $password);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }

        try {
            $role = $this->choice('What is the user role?', $roles);

            $user = (new StoreUseCase($email, $name, $password))->action();
            $this->info('User ' . $email . ' has been created');

            (new SyncRolesUseCase($user, [$role]))->action();
            $this->info('User ' . $email . ' has been assigned role ' . $role);

            return true;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }
    }

    private function askData(?string $email = null, ?string $name = null, ?string $password = null, $retry = 0): array
    {
        if ($retry > self::RETRIES) {
            throw new \RuntimeException('Maximum attempts (max. ' . self::RETRIES . ') reached');
        }

        if (!$email) {
            $email = $this->ask('What is the user email?');
        }

        if (!$name) {
            $name = $this->ask('What is the user name?');
        }

        if (!$password) {
            $password = $this->ask('What is the user password?');
        }

        $validator = $this->validatorData($email, $name, $password);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $attribute => $errors) {
                $this->error($attribute . ': ' .$errors[0]);
                $$attribute = null;
            }

            $this->askData($email, $name, $password, $retry + 1);
        }

        return [$email, $name, $password];
    }

    private function validatorData(string $email, string $name, string $password): \Illuminate\Validation\Validator
    {
        return Validator::make(
            [
                'email' => $email,
                'name' => $name,
                'password' => $password
            ],
            [
                'email' => 'required|email|unique:users,email',
                'name' => 'required|string|max:255',
                'password' => [
                    'required',
                    'string',
                    Password::rule(12)
                ],
            ]
        );
    }
}
