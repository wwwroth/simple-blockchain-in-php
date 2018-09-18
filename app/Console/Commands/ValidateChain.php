<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ValidateChain extends Command
{
    protected $signature = "blockchain:validate-chain {--id=}";
    protected $description = "Validate an existing chain";

    public function handle()
    {
        $chainId = $this->option('id');
        $chainDir = 'chains/' . $chainId;

        $existingChains = Storage::directories('chains');

        if (empty($chainId) || !is_int(array_search($chainDir, $existingChains))) {
            $this->warn('Please provide a valid chain id');
            exit;
        }

        $blocks = Storage::allFiles($chainDir);

        var_dump($blocks);

        $previousHash = null;
        for ($i=0;$i<count($blocks);$i++)
        {
            $currentBlock = json_decode(
                file_get_contents(
                    storage_path() . '/app/' . $blocks[$i]
                ),
                true
            );

            if ($currentBlock['index'] > 0) {

                if ($currentBlock['previousHash'] == $previousHash) {
                    $this->info('Block ' . $i . ' valid.');
                } else {
                    $this->warn('Block' . $i . ' is invalid. Chain broken.');
                    exit;
                }

            } else {
                $this->info('Block ' . $i . ' valid.');
            }

            $previousHash = $currentBlock['hash'];
        }
    }
}