<?php

declare(strict_types=1);

namespace Tests\Unit\CommandBus\Fixtures;

use Stockr\CommandBus\Command;

class CommandWithRequiredFieldsOnly extends Command
{
    protected static $REQUIRED_FIELDS = ['test_required_field'];
}
