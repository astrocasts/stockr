<?php

declare(strict_types=1);

namespace Tests\Unit\CommandBus\Fixtures;

use Stockr\CommandBus\Command;

class CommandWithBothAllowedAndRequiredFields extends Command
{
    protected static $REQUIRED_FIELDS = ['test_required_field'];
    protected static $ALLOWED_FIELDS = ['test_allowed_field'];
}
