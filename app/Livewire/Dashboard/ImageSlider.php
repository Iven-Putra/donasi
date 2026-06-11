<?php

namespace App\Livewire\Dashboard;

use App\Models\DonationType;
use Livewire\Component;

class ImageSlider extends Component
{
    public $slides = [];

    public function mount()
    {
        // Query active donation types that have a flyer image uploaded
        $this->slides = DonationType::where('is_active', true)
            ->whereNotNull('flyer')
            ->where('flyer', '!=', '')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'code' => $type->code,
                    'description' => $type->description,
                    'flyer' => $type->flyer
                ];
            })->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.image-slider');
    }
}
