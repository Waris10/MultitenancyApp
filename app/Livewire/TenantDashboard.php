<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TenantDashboard extends Component
{

    public $user;
    public $tenant;

    public function mount()
    {
        $this->user = Auth::user();
        $this->tenant = $this->user->tenant;
    }

    public function render()
    {
        return view('livewire.tenant-dashboard')
            ->layout('components.layouts.app', [
                'title' => 'Dashboard'
            ]);
    }
}