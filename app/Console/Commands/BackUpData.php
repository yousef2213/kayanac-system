<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackUpData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $cmd = 'php '.base_path().'/artisan database:backup';
        $export = shell_exec($cmd);

        return 0;
    }
}
