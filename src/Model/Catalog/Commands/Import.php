<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Commands;

use Stockr\CommandBus\Command;

class Import extends Command
{
    const ITEM_ID = 'item_id';
    const NAME = 'name';

    static protected $REQUIRED_FIELDS = [
        self::ITEM_ID,
        self::NAME,
    ];

    public function itemId(): ?string
    {
        return $this->get(self::ITEM_ID);
    }

    public function name(): ?string
    {
        return $this->get(self::NAME);
    }
}
