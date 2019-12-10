<?php

declare(strict_types=1);

namespace Stockr\EventSauce\EventSourcing;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;

final class LaravelEventDispatcher implements MessageDispatcher
{
    /** @var string[] */
    private $consumers;

    public function __construct(string ...$consumers)
    {
        $this->consumers = $consumers;
    }

    public function dispatch(Message ...$messages)
    {
        foreach ($this->consumers as $consumer) {
            if (is_a($consumer, ShouldQueue::class, true)) {
                dispatch(new HandleEventConsumer($consumer, ...$messages));
            } else {
                dispatch_now(new HandleEventConsumer($consumer, ...$messages));
            }
        }
    }
}
