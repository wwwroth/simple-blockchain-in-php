<?php

namespace App\Console\Commands;

use App\Http\Controllers\BlockchainController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class CreateChain extends Command
{
    protected $signature = "blockchain:create-chain {--id=}";
    protected $description = "Create new block in chain";

    /**
     * Creates a chain directory in storage with
     * input id or generated sha256 hash
     */
    public function handle()
    {
        if (empty($this->option('id'))) {
            $chanId = hash('sha256', microtime());
        } else {
            $chanId = $this->option('id');
        }

        $newChainDir = 'chains/' . $chanId;

        $existingChains = Storage::directories('chains');

        if (array_search($newChainDir, $existingChains)) {
            $this->warn('Chain already exists');
            exit;
        }

        Storage::makeDirectory($newChainDir);

        $this->info('Chain created: ' . $chanId);
    }
}