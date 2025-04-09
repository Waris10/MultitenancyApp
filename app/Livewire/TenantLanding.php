<?php

namespace App\Livewire;

use Livewire\Component;

class TenantLanding extends Component
{
    public $store_name;
    public $store_url;

    public function mount()
    {
        $tenant = app('currentTenant');
        $this->store_name = $tenant->store_name;
        $this->store_url = request()->getHost();
    }

    public function render()
    {
        return view('livewire.tenant-landing')->layout('components.layouts.guest', [
            'title' => $this->store_name . '-' . config('app.name')
        ]);;
    }
}