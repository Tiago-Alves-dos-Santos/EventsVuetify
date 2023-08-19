<?php

namespace App\Console\Commands;


use App\Models\Event;
use App\Models\Historic;
use Illuminate\Console\Command;

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
        //definindo colunas para melhorar desempenho
        Event::select('id','name','date_start','time_start','date_end','time_end','status')
        ->whereNotIn('status',['concluded','canceled'])//chunk para evitar erro de tempo de execução,
        ->chunk(200, function ($events) { //eventos não cancelados e concluidos
            foreach ($events as $value) {
                $old_status = $value->status;
                $value->compareDatesGetEventStatus();//atualizando status
                if($old_status != $value->status){//caso novo valor diferente do antigo
                    $value->save();
                    Historic::create([
                        'registry' => "O evento {$value->name} foi editado pela rotina de <span style='color:red'>".Event::staticGetStatusInPortuguesBr($old_status)."</span> para <span style='color:red'>". Event::staticGetStatusInPortuguesBr($value->status)."</span>"
                    ]);
                }
            }
        });

        return 0;
    }
}
