<?php

declare(strict_types=1);

namespace Stockr\EventSauce\EventSourcing;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;

interface EventConsumer
{
    public function handle($event, AggregateRootId $aggregateRootId, Message $message);
}
