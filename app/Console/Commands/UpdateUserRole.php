<?php

namespace App\Console\Commands;

use App\Models\Core\User;
use App\UseCases\Core\User\SyncRolesUseCase;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class UpdateUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user-role {email?} {role?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user role ({email?} {role?})';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        if (!$email) {
            $email = $this->ask('What is the user email?');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found');
            return false;
        }

        $roles = Role::all()->pluck('name')->toArray();

        if (!$role || !in_array($role, $roles, true)) {
            if ($role) {
                $this->error('Role not found');
            }

            $role = $this->choice('What is the user role?', $roles);
        }

        try {
            (new SyncRolesUseCase($user, [$role]))->action();
            $this->info('User ' . $email . ' has been assigned role ' . $role);

            return true;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }
    }
}
