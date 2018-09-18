<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateBlock extends Command
{
    protected $signature = "blockchain:create-block {--chainId=} {--numBlocks=}";
    protected $description = "Create new block in chain";

    public function handle()
    {
        $chainId = $this->option('chainId');
        $chainDir = 'chains/' . $chainId;

        $existingChains = Storage::directories('chains');

        if (empty($chainId) || !is_int(array_search($chainDir, $existingChains))) {
            $this->warn('Please provide a valid chain id');
            exit;
        }


        $numBlocks = $this->option('numBlocks');
        if (empty($numBlocks)) $numBlocks = 1;

        for($i=0;$i<$numBlocks;$i++) {

            $blocks = Storage::allFiles($chainDir);

            $nextBlock = [
                'microtime' => microtime(),
                'data' => [
                    'start' => rand(0, 100000),
                    'end' => rand(0, 100000)
                ]
            ];

            if (count($blocks) == 0) {
                $nextBlock['previousHash'] = 0;
                $nextBlock['index'] = 0;
            } else {
                $previousBlock = json_decode(
                    file_get_contents(
                        storage_path() . '/app/' . $blocks[count($blocks)-1]
                    ),
                    true
                );

                $nextBlock['previousHash'] = $previousBlock['hash'];
                $nextBlock['index'] = count($blocks);
            }

            $nextBlock['hash'] = hash('sha256', json_encode($nextBlock));

            Storage::put($chainDir . '/' . str_pad($nextBlock['index'], 10, 0, STR_PAD_LEFT) . '_' . $nextBlock['hash'] . '.json', json_encode($nextBlock));

            $this->info('Block created: ' . json_encode($nextBlock));
        }
    }
}