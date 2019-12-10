<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Policy;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;
use Stockr\EventSauce\EventSourcing\EventConsumer;
use Stockr\Model\Catalog\Events\Renamed;

class DumpWhenRenamed implements EventConsumer
{
    public function handle($event, AggregateRootId $aggregateRootId, Message $message)
    {
        if (! $event instanceof Renamed) {
            return;
        }

        dump([
            'renamed itemId' => $aggregateRootId->toString(),
            'renamed name' => $event->name(),
        ]);
    }
}
