<?php

namespace App\Observers;

use App\Enums\EventStatus;
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
        //where para evitar de ir para metodo update
        Event::where('id', $event->id)->update([
            'status' => Event::staticCompareDatesGetEventStatus($event)
        ]);
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
        //evitando loop caso cadastrar com save
        $event->withoutEvents(function () use ($event) {
            if(!($event->status == EventStatus::CANCELED->value)){
                $event->compareDatesGetEventStatus();
                $event->save();
            }
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
