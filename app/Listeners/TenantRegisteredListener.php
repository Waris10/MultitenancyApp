<?php

namespace App\Listeners;

use App\Events\TenantRegistered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Tenant\User as TenantUser;
use Illuminate\Contracts\Queue\ShouldQueue;

class TenantRegisteredListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenantRegistered $event): void
    {

        $tenant = $event->tenant;
        $dbName = $tenant->db_name;
        //Creating the database
        DB::statement("CREATE DATABASE `$dbName`");
        config(['database.connections.tenant.database' => $dbName]);

        //Run the migrations
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--database' => 'tenant',
        ]);

        //Creating the first user who is gonna be the tenant owner and admin
        TenantUser::on('tenant')->create([
            'name' => 'Admin',
            'email' => $event->email,
            'password' => Hash::make($event->password),
        ]);
    }
}