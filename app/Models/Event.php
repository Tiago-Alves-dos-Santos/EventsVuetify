<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\EventStatus;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    //permitido total atribuição em massa
    protected $guarded = [];
    /**
     * Função retorna um EventStatus baseado no data e tempo de inicio e final
     *
     * @param string $date_start
     * @param string $time_start
     * @param string $date_end
     * @param string $time_end
     * @return EventStatus
     */
    public static function staticCompareDatesGetEventStatus(Event $event): EventStatus {
        $carbonStart = Carbon::parse($event->date_start . ' ' . $event->time_start);
        $carbonEnd = Carbon::parse($event->date_end . ' ' . $event->time_end);
        $carbonNow = Carbon::now();

        if ($carbonStart->greaterThan($carbonNow)) { //inicio > atual == futuro
            return EventStatus::FUTURE;
        }else if($carbonStart->lessThanOrEqualTo($carbonNow) && $carbonEnd->greaterThan($carbonNow)){//inicio <= atual && fim > atual == andamento
            return EventStatus::PROGRESS;
        }else if($carbonEnd->lessThanOrEqualTo($carbonNow)){//fim <= atual = concluido
            return EventStatus::CONCLUDED;
        }

        throw new \Exception('O evento atual não possui datas que atendam as condições de definição de status');
    }
    public function compareDatesGetEventStatus(): EventStatus {
        $this->status = self::staticCompareDatesGetEventStatus($this);
        return $this->status;
    }
}
