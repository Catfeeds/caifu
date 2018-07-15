<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Statistic\Controllers\UserAddController;
use Illuminate\Support\Facades\Log;

class UserAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用户新增';

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
        $model = new UserAddController();
        $result = $model->addLastDay(strtotime("-1 day"));
    }
}
