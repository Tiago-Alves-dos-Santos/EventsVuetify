<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Class\Settings;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Home', [
            'pageValue' => 0
        ]);
    }
    public function eventos(Request $request)
    {
        return Inertia::render('Evento', [
            'pageValue' => 1
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
            'pickerInputStart.after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a '.Carbon::now()->startOfDay()->format('d/m/Y')
        ], $customAttributes);

        try {
            // $event = Event::create([
            //     'name' => $request->name,
            //     'date_start' => $request->date_start,
            //     'time_start' => $request->time_start,
            //     'date_end' => $request->date_end,
            //     'time_end' => $request->time_end,
            //     'text_color' => $request->text_color,
            //     'text_background' => $request->text_background,
            //     'status' => 'canceled'
            // ]);
            // $status = Event::staticCompareDatesGetEventStatus($event);
            // Event::find($event->id)->update([
            //     'status' => $status
            // ]);
            Event::create($request->all());
        } catch (\Exception $e) {
            dd($e->getMessage());
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));

        }
    }
}
