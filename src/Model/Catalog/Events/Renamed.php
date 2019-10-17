<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Events;

use EventSauce\EventSourcing\Serialization\SerializableEvent;

class Renamed implements SerializableEvent
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toPayload(): array
    {
        return ['name' => $this->name];
    }

    public static function fromPayload(array $payload): SerializableEvent
    {
        return new Imported($payload['name']);
    }
}
