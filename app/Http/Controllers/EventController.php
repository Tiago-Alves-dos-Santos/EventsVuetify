<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Event;
use App\Class\Settings;
use App\Class\Constants;
use App\Enums\EventStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Home', [
            'pageValue' => 0,

        ]);
    }
    public function viewEventos(Request $request)
    {
        $events = Event::get();
        $events = $events->map(function ($event) {
            $event->date_start =  $event->date_start.' '.$event->time_start;
            $event->date_end =  $event->date_end.' '.$event->time_end;
            $event->getStatusInPortuguesBr();
            return $event;
        });

        return Inertia::render('Evento', [
            'pageValue' => 1,
            'events' => $events,
        ]);
    }

    public function create(Request $request)
    {
        $customAttributes = [
            'name' => 'nome',
            'date_start' => 'data inicial',
            'date_end' => 'data final',
            'time_start' => 'hora inicial',
            'time_end' => 'hora final',
            'text_color' => 'cor do texto',
            'text_background' => 'cor do fundo do texto',
        ];
        $request->validate([
            'name' => 'required|min:3|max:100',
            'date_start' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::now()->startOfDay()
            ],
            'date_end' => 'required|date|after_or_equal:date_start',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after_or_equal:time_start',
            'text_color' => 'required|max:20',
            'text_background' => 'required|max:20'
        ], [
            'pickerInputStart.after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a ' . Carbon::now()->startOfDay()->format('d/m/Y')
        ], $customAttributes);

        try {
            Event::create($request->all());
            return redirect()->back()->with([
                'message' => Settings::alert('Sucesso', 'Usuario cadastrado com sucesso', Constants::FEEDBACK_INFO)
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));
        }
    }
}
