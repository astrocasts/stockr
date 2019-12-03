<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stockr\CommandBus\Adapter\TacticianCommandBus;
use Stockr\CommandBus\CommandBus;

class CommandBusProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CommandBus::class, TacticianCommandBus::class);
    }
}
