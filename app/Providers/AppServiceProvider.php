<?php

namespace App\Providers;

use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\InMemoryMessageRepository;
use Illuminate\Support\ServiceProvider;
use Stockr\Model\Catalog\Adapter\EventSauce\EventSauceCatalog;
use Stockr\Model\Catalog\Catalog;
use Stockr\Model\Catalog\Item;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Catalog::class, EventSauceCatalog::class);
        $this->app
            ->when(EventSauceCatalog::class)
            ->needs(AggregateRootRepository::class)
            ->give(function () {
                $messageRepository = new InMemoryMessageRepository();

                return new ConstructingAggregateRootRepository(
                    Item::class,
                    $messageRepository
                );
            });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
