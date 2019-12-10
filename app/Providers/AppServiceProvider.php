<?php

namespace App\Providers;

use DB;
use Doctrine\DBAL\Connection;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\DotSeparatedSnakeCaseInflector;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDecoratorChain;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Stockr\EventSauce\EventSourcing\AggregateRootRepositoryFactory;
use Stockr\EventSauce\EventSourcing\DbMessageRepository;
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
        $this->app->when(DbMessageRepository::class)
            ->needs('$tableName')
            ->give('events');

        $this->app->bind(MessageSerializer::class, ConstructingMessageSerializer::class);
        $this->app->singleton(Catalog::class, EventSauceCatalog::class);
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
