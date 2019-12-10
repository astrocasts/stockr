<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Adapter\EventSauce;

use EventSauce\EventSourcing\AggregateRootRepository;
use Stockr\EventSauce\EventSourcing\AggregateRootRepositoryFactory;
use Stockr\Model\Catalog\Catalog;
use Stockr\Model\Catalog\Item;
use Stockr\Model\Catalog\ItemId;
use Stockr\Model\Catalog\Policy\DumpEveryMessage;
use Stockr\Model\Catalog\Policy\DumpWhenImported;
use Stockr\Model\Catalog\Policy\DumpWhenRenamed;

class EventSauceCatalog implements Catalog
{
    /** @var string[] */
    protected $consumers = [
        DumpEveryMessage::class,
    ];

    /** @var string[] */
    protected $eventConsumers = [
        DumpWhenImported::class,
        DumpWhenRenamed::class,
    ];

    /**
     * @var AggregateRootRepositoryFactory
     */
    private $aggregateRootRepositoryFactory;

    public function __construct(AggregateRootRepositoryFactory $aggregateRootRepositoryFactory)
    {
        $this->aggregateRootRepositoryFactory = $aggregateRootRepositoryFactory;
    }

    public function findItem(ItemId $itemId): Item
    {
        /** @var Item $item */
        $item = $this->aggregateRootRepository()->retrieve($itemId);

        return $item;
    }

    public function saveItem(Item $item): void
    {
        $this->aggregateRootRepository()->persist($item);
    }

    private function aggregateRootRepository(): AggregateRootRepository
    {
        return $this->aggregateRootRepositoryFactory->build(
            $this->consumers,
            $this->eventConsumers
        );
    }
}
