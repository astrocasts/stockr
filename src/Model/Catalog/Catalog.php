<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog;

interface Catalog
{
    public function findItem(ItemId $itemId): Item;
    public function saveItem(Item $item): void;
}
