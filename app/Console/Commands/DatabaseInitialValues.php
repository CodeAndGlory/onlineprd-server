<?php

namespace App\Console\Commands;

use ErrorException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DatabaseInitialValues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:initial-values';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize database with initial users, roles, permissions, and form field lookup values';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            Artisan::call('db:seed', ['--class' => 'PermissionSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'RolesSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'FormFieldLookupSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'AdminUsersSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'DepartmentSeeder', '--force' => true]);
        } catch (ErrorException $e) {
            $this->error('Caught exception: '.$e->getMessage());
        }

        $this->info('Database initial values populated!');

        return null;
    }
}
