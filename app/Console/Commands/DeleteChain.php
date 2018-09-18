<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteChain extends Command
{
    protected $signature = "blockchain:delete-chain {--id=}";
    protected $description = "Delete specific or all chain";

    /**
     * Deletes a specific chain or all chains in storage
     */
    public function handle()
    {
        $chainId = $this->option('id');

        $existingChains = Storage::directories('chains');

        if (!empty($chainId)) {

            /* Delete specific chain based on ID */

            $chainDir = 'chains/' . $chainId;

            if (array_search($chainDir, $existingChains)) {

                try {
                    Storage::deleteDirectory($chainDir);
                } catch (\Exception $exception) {
                    $this->warn('Error deleting ' . $chainDir);
                    $this->warn($exception->getMessage());
                } finally {
                    $this->info( $chainDir . ' deleted.');
                }

            } else {
                $this->warn('Chain not found.');
            }


        } else {

            /* Delete all chains */

            if (count($existingChains) == 0) {
                $this->warn('No chains to delete.');
            }

            foreach ($existingChains as $dir) {

                try {
                    Storage::deleteDirectory($dir);
                } catch (\Exception $exception) {
                    $this->warn('Error deleting ' . $dir);
                    $this->warn($exception->getMessage());
                } finally {
                    $this->info( $dir . ' deleted.');
                }

            }
        }
    }
}