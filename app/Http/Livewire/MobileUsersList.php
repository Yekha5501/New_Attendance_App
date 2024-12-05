<?php

// app/Http/Livewire/MobileUsersList.php
namespace App\Http\Livewire;

use Livewire\Component;

class MobileUsersList extends Component
{
    public $mobileUsers = [
        ['name' => 'Mphatso James', 'status' => 'active'],
        ['name' => 'Melina Banda', 'status' => 'active'],
        ['name' => 'Gift Sipolo', 'status' => 'offline'],
        ['name' => 'Alnord Banda', 'status' => 'active'],
        ['name' => 'Elijah Meleka', 'status' => 'offline'],
    ];

    public function render()
    {
        return view('livewire.mobile-users-list',['mobileUsers' => $this->mobileUsers]);
    }
}
