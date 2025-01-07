<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ResDiary\Tokens;

class RefreshResDiaryTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resdiary:refresh-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh ResDiary tokens.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Tokens::refreshAllTokens();
    }
}
