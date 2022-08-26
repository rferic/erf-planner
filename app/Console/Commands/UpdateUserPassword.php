<?php

namespace App\Console\Commands;

use App\Models\Core\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Labelgrup\LaravelUtilities\Helpers\Password;

class UpdateUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user-password {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user password ({email?})';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $email = $this->argument('email');

        if (!$email) {
            $email = $this->ask('What is the user email?');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found');
            return false;
        }

        $password = $this->secret('What is the user password?');

        if (!$this->validatorData($password)) {
            return false;
        }

        try {
            (new UpdateUserPassword($user, $password))->action();
            $this->info('User ' . $email . ' has been updated');
            return true;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }
    }

    private function validatorData(string $password): bool
    {
        $validator = Validator::make(
            [
                'password' => $password
            ],
            [
                'password' => [
                    'required',
                    'string',
                    Password::rule(12)
                ],
            ]
        );

        if ($validator->fails()) {
            $this->error($validator->errors()->first('password'));
            return false;
        }

        return true;
    }
}
