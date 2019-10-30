<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stockr\Model\Catalog\Catalog;
use Stockr\Model\Catalog\Item;
use Stockr\Model\Catalog\ItemId;

class Wiring extends Command
{
    protected $signature = 'wiring {itemId?}';

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
       if ($itemId = $this->argument('itemId')) {
            $item = $this->catalog->findItem(ItemId::fromString($itemId));

            $item->rename(random_int(0, 150));

            dump($item);

            $this->catalog->saveItem($item);

            dump($item);
        } else {
            /** @var ItemId $itemId */
            $itemId = ItemId::generate();

            $item = Item::import($itemId, 'First Itemz!');
            $item->rename('SECOND TIME!');

            dump($item);

            $this->catalog->saveItem($item);

            dump($item);
        }
    }
}
