<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Handlers;

use Stockr\Model\Catalog\Catalog;
use Stockr\Model\Catalog\Commands\Rename;
use Stockr\Model\Catalog\Item;
use Stockr\Model\Catalog\ItemId;

class RenameHandler
{
    /**
     * @var Catalog
     */
    private $catalog;

    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    public function __invoke(Rename $command): void
    {
        /** @var ItemId $itemId */
        $itemId = ItemId::fromString($command->itemId());

        $item = $this->catalog->findItem($itemId);

        $item->rename($command->name());

        $this->catalog->saveItem($item);
    }
}
