<?php

declare(strict_types=1);

namespace Stockr\CommandBus\Adapter;

use League\Tactician\CommandBus as ActualTacticianCommandBus;
use Stockr\CommandBus\Command;
use Stockr\CommandBus\CommandBus;

class TacticianCommandBus implements CommandBus
{
    /**
     * @var ActualTacticianCommandBus
     */
    private $commandBus;

    public function __construct(ActualTacticianCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(string $className, array $payload = []): void
    {
        /** @var Command $className */
        $payload = $className::validate($payload);

        /** @var Command $className */
        /** @var Command $command */
        $command = $className::fromPayload($payload);


        $this->commandBus->handle($command);
    }
}
