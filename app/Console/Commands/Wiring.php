<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stockr\Model\Catalog\Catalog;
use Stockr\Model\Catalog\Item;
use Stockr\Model\Catalog\ItemId;

class Wiring extends Command
{
    protected $signature = 'wiring';

    /**
     * @var Catalog
     */
    private $catalog;

    public function __construct(Catalog $catalog)
    {
        parent::__construct();

        $this->catalog = $catalog;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var ItemId $itemId */
        $itemId = ItemId::generate();

        // TODO --- not public constructor
        //$item = new Item($itemId);

        $item = Item::import($itemId, 'First Itemz!');

        dump($item);

        $this->catalog->saveItem($item);

        dump($item);
    }
}
