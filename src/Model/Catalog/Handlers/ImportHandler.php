<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog\Handlers;

use Stockr\Model\Catalog\Commands\Import;

class ImportHandler
{
    public function __invoke(Import $command): void
    {
        dump(['from import handler' => $command->toPayload()]);
    }
}
