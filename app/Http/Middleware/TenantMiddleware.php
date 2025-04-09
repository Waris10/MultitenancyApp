<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        $base = config('app.main_domain');
        if ($host === $base) {
            //sets the Auth model automatically
            //Config::set('auth.providers.users.model', \App\Models\User::class);

            // Use main database (default connection)
            config(['database.default']); // Or whatever the main database connection is
        } else {
            $subdomain = explode('.', $request->getHost())[0];
            $tenant = Tenant::where('slug', $subdomain)->first();
            if (!$tenant) {
                abort(404);
            }

            //This will set the database connection to the tenant's database dynamically
            Config::set('database.connections.tenant.database', $tenant->db_name);

            //sets the auth model dynamically
            //Config::set('auth.providers.users.model', \App\Models\Tenant\User::class);

            //Set the DB connection for the current request
            DB::purge('tenant');
            DB::reconnect('tenant');

            app()->instance('currentTenant', $tenant);
        }
        return $next($request);
    }
}
