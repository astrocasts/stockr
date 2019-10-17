<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;
use Stockr\Model\Catalog\Events\Imported;
use Stockr\Model\Catalog\Events\Renamed;

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

    public function rename(string $newName): void
    {
        if (!$newName === $this->name) {
            return;
        }

        $this->recordThat(new Renamed($newName));
    }

    protected function applyRenamed(Renamed $event)
    {
        $this->name = $event->name();
    }
}
