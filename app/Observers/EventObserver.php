<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Historic;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        $event->compareDatesGetEventStatus();//atualização de status de acordo com as datas
        $event->save();
        Historic::create(['registry' => "O evento {$event->name} foi criado"]);
    }

    /**
     * Handle the Event "updated" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        //evitando loop gerado ao cadastrar com save
        $event->withoutEvents(function () use ($event) {
            $event->compareDatesGetEventStatus();
            $event->save();
        });
        Historic::create(['registry' => "O evento {$event->name} foi atualizado"]);
    }

    /**
     * Handle the Event "deleted" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        Historic::create(['registry' => "O evento {$event->name} foi deletado"]);
    }

    /**
     * Handle the Event "restored" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        Historic::create(['registry' => "O evento {$event->name} foi restaurado"]);
    }

    /**
     * Handle the Event "force deleted" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        Historic::create(['registry' => "O evento {$event->name} foi deletado permanentemente"]);
    }
}
