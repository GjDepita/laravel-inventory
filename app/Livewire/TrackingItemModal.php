<?php

namespace App\Livewire;

use Livewire\Component;

class TrackingItemModal extends Component
{
    public $show = false;

    protected $listeners = ['open-tracking-modal' => 'showModal'];

    public function showModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.tracking-item-modal');
    }
}
