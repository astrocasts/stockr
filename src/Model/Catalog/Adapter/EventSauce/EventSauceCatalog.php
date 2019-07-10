<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Adapter\EventSauce;

use EventSauce\EventSourcing\AggregateRootRepository;
use Stockr\Model\Catalog\Catalog;
use Stockr\Model\Catalog\Item;
use Stockr\Model\Catalog\ItemId;

class EventSauceCatalog implements Catalog
{
    /**
     * @var AggregateRootRepository
     */
    private $aggregateRootRepository;

    public function __construct(AggregateRootRepository $aggregateRootRepository)
    {
        $this->aggregateRootRepository = $aggregateRootRepository;
    }

    public function findItem(ItemId $itemId): Item
    {
        /** @var Item $item */
        $item = $this->aggregateRootRepository->retrieve($itemId);

        return $item;
    }

    public function saveItem(Item $item): void
    {
        $this->aggregateRootRepository->persist($item);
    }
}
