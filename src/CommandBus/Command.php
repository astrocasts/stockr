<?php

declare(strict_types=1);

namespace Stockr\CommandBus;

use ConvenientImmutability\Immutable;

class Command
{
    use Immutable;

    /**
     * @var array
     */
    private $payload = [];

    static protected $REQUIRED_FIELDS = [];
    static protected $ALLOWED_FIELDS = [];

    private function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    public static function fromPayload(array $payload): self
    {
        return new static($payload);
    }

    public function with(string $key, $value = null): self
    {
        return new static(array_merge($this->payload, [
            $key => $value,
        ]));
    }

    public function without(string $key): self
    {
        $payload = $this->payload;
        unset($payload[$key]);

        return new static($payload);
    }

    public function get(string $key, $defaultValue = null)
    {
        if (! array_key_exists($key, $this->payload)) {
            return $defaultValue;
        }

        return $this->payload[$key];
    }

    public function toPayload(): array
    {
        return $this->payload;
    }

    public static function validate(array $payload = []): bool
    {
        foreach (static::$REQUIRED_FIELDS as $requiredField) {
            if (! array_key_exists($requiredField, $payload)) {
                return false;
            }
        }

        return true;
    }
}
