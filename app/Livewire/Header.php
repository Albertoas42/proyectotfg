<?php

namespace App\Livewire;

use Livewire\Component;

class Header extends Component
{
    // Registramos la propiedad pública para recibir la pestaña activa
    public $currentTab;

    public function selectTab($tabName)
    {
        $this->dispatch('changeTab', tabName: $tabName);
    }

    public function render()
    {
        return view('livewire.header');
    }
}
