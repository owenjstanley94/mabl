<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\FixturesTable;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('fixtures-table', FixturesTable::class);
    }
} 