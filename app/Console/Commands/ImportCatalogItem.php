<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stockr\CommandBus\CommandBus;
use Stockr\Model\Catalog\Commands\Import;
use Stockr\Model\Catalog\ItemId;

class ImportCatalogItem extends Command
{
    protected $signature = 'catalog:item:import {name}';

    protected $description = 'Import Catalog Item';

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
        $name = $this->argument('name');

        $itemId = ItemId::generate();

        $this->commandBus->dispatch(Import::class, [
            Import::ITEM_ID => $itemId->toString(),
            Import::NAME => $name,
        ]);
    }
}
