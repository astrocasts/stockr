<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Policy;

use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;
use Stockr\Model\Catalog\Events\Imported;
use Stockr\Model\Catalog\Item;
use Stockr\Model\Catalog\ItemId;

class DumpEveryMessage implements Consumer
{
    public function handle(Message $message)
    {
        $event = $message->event();

        if (! $event instanceof Imported) {
            return;
        }

        /** @var ItemId $itemId */
        $itemId = $message->aggregateRootId();

        Item::import($itemId, 'foo');


        dump(['message' => $message,]);
    }
}
