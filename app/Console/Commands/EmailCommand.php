<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will send emails in every 3 months';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
