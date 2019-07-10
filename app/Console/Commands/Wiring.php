<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stockr\Model\Catalog\Catalog;

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
    }
}
