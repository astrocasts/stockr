<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Handlers;

use Stockr\Model\Catalog\Catalog;
use Stockr\Model\Catalog\Commands\Import;
use Stockr\Model\Catalog\Item;
use Stockr\Model\Catalog\ItemId;

class ImportHandler
{
    /**
     * @var Catalog
     */
    private $catalog;

    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    public function __invoke(Import $command): void
    {
        /** @var ItemId $itemId */
        $itemId = ItemId::fromString($command->itemId());

        $item = Item::import($itemId, $command->name());

        $this->catalog->saveItem($item);
    }
}
