<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Policy;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;
use Stockr\EventSauce\EventSourcing\EventConsumer;
use Stockr\Model\Catalog\Events\Imported;

class DumpWhenImported implements EventConsumer
{
    public function handle($event, AggregateRootId $aggregateRootId, Message $message)
    {
        if (! $event instanceof Imported) {
            return;
        }

        dump([
            'imported itemId' => $aggregateRootId->toString(),
            'imported name' => $event->name(),
        ]);
    }
}
