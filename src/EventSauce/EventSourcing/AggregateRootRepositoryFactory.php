<?php

declare(strict_types=1);

namespace Stockr\EventSauce\EventSourcing;

use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\DotSeparatedSnakeCaseInflector;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDecoratorChain;
use EventSauce\EventSourcing\MessageDispatcherChain;
use Stockr\Model\Catalog\Item;

final class AggregateRootRepositoryFactory
{
    /**
     * @var DbMessageRepository
     */
    private $dbMessageRepository;

    public function __construct(DbMessageRepository $dbMessageRepository)
    {
        $this->dbMessageRepository = $dbMessageRepository;
    }

    public function build(array $consumers, array $eventConsumers): AggregateRootRepository
    {
        return new ConstructingAggregateRootRepository(
            Item::class,
            $this->dbMessageRepository,
            new MessageDispatcherChain(
                new LaravelMessageDispatcher(...$consumers),
                new LaravelEventDispatcher(...$eventConsumers)
            ),
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
    }
}
