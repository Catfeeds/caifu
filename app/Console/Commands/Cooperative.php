<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Statistic\Controllers\CooperativeController;

class Cooperative extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cooperative';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '合作社';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $model = new CooperativeController();
        $model->reset();
    }
}
