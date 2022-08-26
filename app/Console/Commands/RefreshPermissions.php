<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh permissions';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Artisan::call('db:seed --class=PermissionsSeeder');
        Artisan::call('db:seed --class=RolesSeeder');
        $this->info('Permissions has been refreshed');
        return true;
    }
}
