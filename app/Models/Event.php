<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\EventTime;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    //permitido total atribuição em massa
    protected $guarded = [];
    /*****************************************MUTATORS*******************************************/
    public function setDateStarFormatedtAttribute($value)
    {
        $this->attributes['date_start_formated'] = $value;
    }
    public function setDateEndFormatedAttribute($value)
    {
        $this->attributes['date_end_formated'] = $value;
    }

    public function getDateStartFormatedAttribute()
    {
        return  Carbon::parse($this->attributes['date_start_formated'])->format('d/m/Y H:i:s');
    }
    public function getDateEndFormatedAttribute()
    {
        return  Carbon::parse($this->attributes['date_end_formated'])->format('d/m/Y H:i:s');
    }
    /*************************************ESCOPOS LOCAIS*******************************************/
    public function scopeEventsOf($query, string $type)
    {
        switch ($type) {
            case EventTime::EVENTS_ALL->value:
                return $query;
                break;
            case EventTime::EVENTS_YEAR->value:
                $query->whereYear('date_start', date('Y'));
                break;
            case EventTime::EVENTS_MONTH->value:
                $query->whereMonth('date_start', date('m'));
                break;
            case EventTime::EVENTS_FUTURE->value:
                $query->where('status', EventStatus::FUTURE->value);
                break;

            default:
                throw new \Exception("O paramêtro 'type': $type não se classifca nas opções de " . EventTime::class);
                break;
        }
        return $query;
    }


    /*************************************METODOS STATICS*******************************************/

    /**
     * Função retorna um EventStatus baseado no data e tempo de inicio e final
     *
     * @param string $date_start
     * @param string $time_start
     * @param string $date_end
     * @param string $time_end
     * @return string
     */
    public static function staticCompareDatesGetEventStatus(Event $event): string
    {
        $carbonStart = Carbon::parse($event->date_start . ' ' . $event->time_start);
        $carbonEnd = Carbon::parse($event->date_end . ' ' . $event->time_end);
        $carbonNow = Carbon::now();

        if ($carbonStart->greaterThan($carbonNow)) { //inicio > atual == futuro
            return EventStatus::FUTURE->value;
        } else if ($carbonStart->lessThanOrEqualTo($carbonNow) && $carbonEnd->greaterThan($carbonNow)) { //inicio <= atual && fim > atual == andamento
            return EventStatus::PROGRESS->value;
        } else if ($carbonEnd->lessThanOrEqualTo($carbonNow)) { //fim <= atual = concluido
            return EventStatus::CONCLUDED->value;
        }

        throw new \Exception('O evento atual não possui datas que atendam as condições de definição de status');
    }
    /**
     * Função retorna um EventStatus baseado no data e tempo de inicio e final
     *
     * @param string $status
     * @return string
     */
    public static function staticGetStatusInPortuguesBr(string $status): string
    {
        $result = '';

        switch ($status) {
            case EventStatus::PROGRESS->value:
                $result = 'Em andamento';
                break;
            case EventStatus::FUTURE->value:
                $result = 'Agendado';
                break;
            case EventStatus::CONCLUDED->value:
                $result = 'Concluído';
                break;
            case EventStatus::CANCELED->value:
                $result = 'Cancelado';
                break;

            default:
                throw new \Exception("O status: $status não se classifca nas opções de " . EventStatus::class);
                break;
        }
        return $result;
    }
    /*************************************METODOS*******************************************/
    /**
     * Função retorna um EventStatus baseado no data e tempo de inicio e final
     *
     * @return string
     */
    public function compareDatesGetEventStatus(): string
    {
        $this->status = self::staticCompareDatesGetEventStatus($this);
        return $this->status;
    }
    /**
     * Função retorna um EventStatus baseado no data e tempo de inicio e final
     *
     * @return string
     */
    public function getStatusInPortuguesBr(): string
    {
        $this->attributes['status_br'] = self::staticGetStatusInPortuguesBr($this->status);
        return $this->attributes['status_br'];
    }
}
