<?php

namespace App\Livewire\Auth;

use Exception;
use App\Models\User;
use App\Models\Tenant;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Events\TenantRegistered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rules\Password;

class TenantRegister extends Component
{
    public string $name = '';
    public string $email = '';
    public string $store_name = '';
    public string $password = '';
    public string $password_confirmation = '';


    public function register()
    {
        //I validated separately because I don't plan on modifying the users table.
        $this->validate([
            'store_name' => ['required', 'string', 'max:255'],
        ]);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        //DB::beginTransaction();
        try {
            //not best practice to pick from the properties but for the sake of this example, it's fine.
            $slug = Str::slug($this->store_name);
            $dbName = $slug . '_db';

            $tenant = Tenant::create([
                'user_id' => null,
                'store_name' => $this->store_name,
                'slug' => $slug,
                'db_name' => $dbName,
            ]);

            event(new TenantRegistered($tenant, $this->email, $this->password));

            //This BLOCK of code is for creating a new subdomain dynamically on my local machine in my windows hosts file.
            $storeName = $slug; // dynamically set based on tenant
            $scriptPath = 'C:\\laragon\\add-domain.bat'; // Ensure correct path to batch script
            // Execute the script
            exec("powershell Start-Process '$scriptPath' -ArgumentList '$storeName' -Verb runAs", $output, $returnVar);
            // Log output to larvel.log
            Log::info('Script Output: ' . implode("\n", $output));
            Log::info('Return Value: ' . $returnVar);



            event(new Registered(($user = User::create($validated))));

            //This will go back and save the user_id to the tenant's table
            $tenant->user_id = $user->id;
            $tenant->save();

            Auth::login($user);
            $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
            //DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error creating tenant' . $e->getMessage());
        }
    }



    public function render(): mixed
    {
        return view('livewire.auth.tenant-register')->layout('components.layouts.auth');
    }
}