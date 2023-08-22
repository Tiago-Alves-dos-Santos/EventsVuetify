<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventCrudTest extends TestCase
{
    private int $id = 1;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
        $carbonStart = Carbon::now();
        $carbonEnd = Carbon::now();
        $carbonEnd->addMinutes(30);

        $dataRequest = [
            'name' => 'Evento teste feature',
            'date_start' => $carbonStart->format('Y-m-d'),
            'date_end'  => $carbonEnd->format('Y-m-d'),
            'time_start' => $carbonStart->format('H:i'),
            'time_end' => $carbonEnd->format('H:i'),
            'text_color' => '#FFFFFF',
            'text_background' => '#0008FF',
        ];
        $response = $this->post(route('event.create'), $dataRequest);
        $this->assertDatabaseHas('events', $dataRequest);
        $response->assertStatus(302);
    }
    public function test_update()
    {
        $carbonStart = Carbon::now();
        $carbonEnd= $carbonStart->copy();
        $carbonEnd->addMinutes(30);

        $event = Event::find($this->id);
        $newEvent = [
            'id' => $event->id,
            'name' => 'Evento editado feature',
            'old_date_start' => $event->date_start,
            'date_start' => $carbonStart->format('Y-m-d'),
            'date_end'  => $carbonEnd->format('Y-m-d'),
            'time_start' => $carbonStart->format('H:i'),
            'time_end' => $carbonEnd->format('H:i'),
            'text_color' => '#FFFFFF',
            'text_background' => '#0008FF',
        ];
        $response = $this->put(route('event.update'), $newEvent);
        unset($newEvent['old_date_start']);
        $this->assertDatabaseHas('events', $newEvent);
        $response->assertStatus(302);
    }
    public function test_cancel()
    {
        $response = $this->put(route('event.cancel'), ['id' => $this->id]);
        $this->assertDatabaseHas('events', [
            'status' => EventStatus::CANCELED->value
        ]);
        $response->assertStatus(302);
    }
    public function test_delete()
    {
        $response = $this->delete(route('event.delete', ['id' => $this->id]));
        $response->assertStatus(302);
    }
    public function test_restore()
    {
        $response = $this->put(route('event.restore', ['id' => $this->id]));
        $response->assertStatus(302);
    }
}
