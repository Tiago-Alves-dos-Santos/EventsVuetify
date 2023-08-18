<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Historic;
use App\Enums\EventStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        //chunk para evitar erro de tempo de execução,
        Event::whereNotIn('status',['concluded','canceled'])->chunk(200, function ($events) {
            foreach ($events as $value) {
                $old_status = $value->status;
                $value->compareDatesGetEventStatus();
                Log::info("Old status: $old_status e status $value->status valor: ". ($old_status != $value->status));
                if($old_status != $value->status){
                    $value->save();
                    Historic::create([
                        'registry' => "O evento {$value->name} foi editado pela rotina de ".Event::staticGetStatusInPortuguesBr($old_status)." para ". Event::staticGetStatusInPortuguesBr($value->status)
                    ]);
                }

            }
        });

        return 0;
    }
}
