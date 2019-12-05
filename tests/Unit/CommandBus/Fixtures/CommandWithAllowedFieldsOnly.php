<?php

declare(strict_types=1);

namespace Tests\Unit\CommandBus\Fixtures;

use Stockr\CommandBus\Command;

class CommandWithAllowedFieldsOnly extends Command
{
    protected static $ALLOWED_FIELDS = ['test_allowed_field'];
}
