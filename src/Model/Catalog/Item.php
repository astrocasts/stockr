<?php

declare(strict_types=1);

namespace Stockr\Model\Catalog;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

class Item implements AggregateRoot
{
    use AggregateRootBehaviour;
}
