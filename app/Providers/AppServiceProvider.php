<?php

namespace App\Providers;

use Doctrine\DBAL\Connection;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\DotSeparatedSnakeCaseInflector;
use EventSauce\EventSourcing\InMemoryMessageRepository;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDecoratorChain;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
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
        $this->app->singleton(Connection::class, static function () {
            return \DB::getDoctrineConnection();
        });

        $this->app->when(DbMessageRepository::class)
            ->needs('$tableName')
            ->give('events');

        $this->app->bind(MessageSerializer::class, ConstructingMessageSerializer::class);
        $this->app->singleton(Catalog::class, EventSauceCatalog::class);
        $this->app
            ->when(EventSauceCatalog::class)
            ->needs(AggregateRootRepository::class)
            ->give(function (Container $container) {
                $messageRepository = $container->make(DbMessageRepository::class);

                return new ConstructingAggregateRootRepository(
                    Item::class,
                    $messageRepository,
                    null,
                    new MessageDecoratorChain(
                        new DefaultHeadersDecorator(),
                        new class implements MessageDecorator {
                            private $aggregateRootType;

                            public function __construct(ClassNameInflector $classNameInflector = null)
                            {
                                $this->aggregateRootType = ($classNameInflector ?: new DotSeparatedSnakeCaseInflector())
                                    ->classNameToType(Item::class);
                            }

                            public function decorate(Message $message): Message
                            {
                                return $message->withHeaders([
                                    '__aggregate_root_type' => $this->aggregateRootType,
                                ]);
                            }
                        }
                    )
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
