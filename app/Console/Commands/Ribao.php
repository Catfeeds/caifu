<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Statistic\Controllers\RibaoController;
use Illuminate\Http\Request;

class Ribao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ribao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '日报模块统计';

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
       $ribao = new RibaoController();

       $result = $ribao->addLastDay(strtotime("-1 day"));

    }
}
