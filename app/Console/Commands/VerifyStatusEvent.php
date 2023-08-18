<?php

namespace App\Console\Commands;

use App\Enums\EventStatus;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Inertia\Inertia;

class VerifyStatusEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:verifyStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muda o status do evento de acordo com suas datas';

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
    public function handle()
    {

        return 0;
    }
}
