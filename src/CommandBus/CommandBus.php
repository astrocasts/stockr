<?php

declare(strict_types=1);

namespace Stockr\CommandBus;

interface CommandBus
{
    public function dispatch(string $className, array $payload = []): void;
}
