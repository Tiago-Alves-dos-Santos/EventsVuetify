<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventCrudTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
        $carbonStart = Carbon::now();
        $carbonEnd= $carbonStart->copy();
        $carbonEnd->addMinutes(30);

        $dataRequest = [
            'name' => 'User teste feature',
            'date_start' => $carbonStart->format('Y-m-d'),
            'date_end'  => $carbonEnd->format('Y-m-d'),
            'time_start' => $carbonStart->format('H:i'),
            'time_end' => $carbonStart->format('H:i'),
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

        $event = Event::find(1);
        $newEvent = [
            'id' => $event->id,
            'name' => 'User teste feature teste update, feito',
            'old_date_start' => $event->date_start,
            'date_start' => $carbonStart->format('Y-m-d'),
            'date_end'  => $carbonEnd->format('Y-m-d'),
            'time_start' => $carbonStart->format('H:i'),
            'time_end' => $carbonStart->format('H:i'),
            'text_color' => '#FFFFFF',
            'text_background' => '#0008FF',
        ];
        $response = $this->put(route('event.update'), $newEvent);
        unset($newEvent['old_date_start']);
        $this->assertDatabaseHas('events', $newEvent);
        $response->assertStatus(302);
    }
}
