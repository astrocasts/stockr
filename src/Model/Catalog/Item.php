<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;
use Stockr\Model\Catalog\Events\Imported;

class Item implements AggregateRoot
{
    use AggregateRootBehaviour;

    /** @var string */
    private $name;

    public static function import(ItemId $itemId, string $name)
    {
        $item = new static($itemId);
        $item->recordThat(Imported::fromPayload(['name' => $name]));

        return $item;
    }

    protected function applyImported(Imported $event)
    {
        $this->name = $event->name();
    }
}
