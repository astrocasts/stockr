<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog;

use EventSauce\EventSourcing\AggregateRootId;
use Illuminate\Support\Str;

class ItemId implements AggregateRootId
{
    /**
     * @var string
     */
    private $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid;
    }

    public static function fromString(string $aggregateRootId): AggregateRootId
    {
        return new ItemId($aggregateRootId);
    }

    public static function generate(): AggregateRootId
    {
        return new ItemId(Str::orderedUuid()->toString());
    }
}
