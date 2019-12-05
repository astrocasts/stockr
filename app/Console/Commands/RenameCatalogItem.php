<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stockr\CommandBus\CommandBus;
use Stockr\Model\Catalog\Commands\Rename;
use Stockr\Model\Catalog\ItemId;

class RenameCatalogItem extends Command
{
    protected $signature = 'catalog:item:rename {itemId} {name}';

    protected $description = 'Command description';

    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    public function handle()
    {
        $itemId = $this->argument('itemId');
        $name = $this->argument('name');

        $this->commandBus->dispatch(Rename::class, [
            Rename::ITEM_ID => $itemId,
            Rename::NAME => $name,
            'foo' => 'bar',
            'bat' => 'baz',
        ]);
    }}
