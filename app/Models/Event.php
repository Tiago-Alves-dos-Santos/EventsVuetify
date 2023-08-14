<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    //permitido total atribuição em massa
    protected $guarded = [];
    protected $table = 'events';
    /**
     * Função retorna um EventStatus baseado no data e tempo de inicio e final
     *
     * @param string $date_start
     * @param string $time_start
     * @param string $date_end
     * @param string $time_end
     * @return EventStatus
     */
    public static function staticCompareDatesGetEventStatus(Event $event): EventStatus
    {
        $carbonStart = Carbon::parse($event->date_start . ' ' . $event->time_start);
        $carbonEnd = Carbon::parse($event->date_end . ' ' . $event->time_end);
        $carbonNow = Carbon::now();

        if ($carbonStart->greaterThan($carbonNow)) { //inicio > atual == futuro
            return EventStatus::FUTURE;
        } else if ($carbonStart->lessThanOrEqualTo($carbonNow) && $carbonEnd->greaterThan($carbonNow)) { //inicio <= atual && fim > atual == andamento
            return EventStatus::PROGRESS;
        } else if ($carbonEnd->lessThanOrEqualTo($carbonNow)) { //fim <= atual = concluido
            return EventStatus::CONCLUDED;
        }

        throw new \Exception('O evento atual não possui datas que atendam as condições de definição de status');
    }
    /**
     * Função retorna um EventStatus baseado no data e tempo de inicio e final
     *
     * @param EventStatus $status
     * @return string
     */
    public static function staticGetStatusInPortuguesBr($status): string
    {
        $result = '';
        $reflectionClass = new \ReflectionClass(EventStatus::class);
        $statusArray = $reflectionClass->getConstants();

        switch ($status) {
            case $statusArray['PROGRESS']->value:
                $result = 'Em andamento';
                break;
            case $statusArray['FUTURE']->value:
                $result = 'Agendado';
                break;
            case $statusArray['FUTURE']->value:
                $result = 'Concluído';
                break;
            case $statusArray['FUTURE']->value:
                $result = 'Cancelado';
                break;

            default:
                throw new \Exception("O status: $status não se classifca nas opções de " . EventStatus::class);
                break;
        }
        return $result;
    }
    /**
     *
     *
     * @return EventStatus
     */
    public function compareDatesGetEventStatus(): EventStatus
    {
        $this->status = self::staticCompareDatesGetEventStatus($this);
        return $this->status;
    }

    public function getStatusInPortuguesBr() : string {
        $this->status = self::staticGetStatusInPortuguesBr($this->status);
        return $this->status;
    }


}
