<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class ExecuteJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:alljobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('queue:work --stop-when-empty', []);
        $curr_date  =   date('Y-m-d H:i:s');
        error_log("Testinggggggg ==> $curr_date \n", 3, public_path("send_email_cron.log"));
    }
}
