<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Event;
use App\Class\Settings;
use App\Class\Constants;
use App\Enums\EventStatus;
use App\Enums\EventTime;
use App\Models\Historic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use ReflectionClass;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $valueCalendar = $request->valueCalendar ?? Carbon::now();
        $events = Event::where('status', '!=', EventStatus::CANCELED->value)->cursor();
        //montagem de array de acordo com o que v-calendar pede e com acrescimos de cor
        $events = $events->map(function ($event) {
            return [
                'name' => $event->name,
                'start' => $event->date_start . 'T' . $event->time_start,
                'end' => $event->date_end . 'T' . $event->time_end,
                'color' => $event->text_background,
                'textColor' => $event->text_color,
            ];
        });
        return Inertia::render('Home', [
            'pageValue' => 'index',
            'events' => $events,
            'valueCalendar' => $valueCalendar
        ]);
    }
    public function viewEvents(Request $request)
    {
        $visibleDeletedEvents = (bool)$request->visibleDeletedEvents ?? false;
        //filtro de tempo
        $eventTimeFilter = $request->eventTimeFilter ?? EventTime::EVENTS_YEAR->value;
        if ($visibleDeletedEvents) {//aplica consulta de deletados e por tempo
            $events = Event::onlyTrashed()->eventsOf($eventTimeFilter)->cursor();
        } else { //apenas por tempo
            $events = Event::eventsOf($eventTimeFilter)->cursor();
        }

        //formatação de datas e status em português
        $events = $events->map(function ($event) {
            $event->date_start_formated =  $event->date_start . ' ' . $event->time_start;
            $event->date_end_formated =  $event->date_end . ' ' . $event->time_end;
            $event->getStatusInPortuguesBr();
            return $event;
        });
        //nativa do php, usada para trabalhar com classes e suas propiedades
        $reflectionClass = new ReflectionClass(EventStatus::class);
        return Inertia::render('Evento', [
            'pageValue' => 'event.viewEvents',
            'events' => $events,
            'eventStatus' => $reflectionClass->getConstants(), //retorna os atributos do enum
            'visibleDeletedEvents' => $visibleDeletedEvents,
        ]);
    }

    public function create(Request $request)
    {
        //nomes amigaveis
        $customAttributes = [
            'name' => 'nome',
            'date_start' => 'data inicial',
            'date_end' => 'data final',
            'time_start' => 'hora inicial',
            'time_end' => 'hora final',
            'text_color' => 'cor do texto',
            'text_background' => 'cor do fundo do texto',
        ];
        //validação
        $request->validate([
            'name' => 'required|min:3|max:100',
            'date_start' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::now()->startOfDay(), //data maior ou igual data atual
            ],
            'date_end' => 'required|date|after_or_equal:date_start',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after_or_equal:time_start',
            'text_color' => 'required|max:20',
            'text_background' => 'required|max:20'
        ], [
            'date_start.after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a ' . Carbon::now()->startOfDay()->format('d/m/Y')
        ], $customAttributes);

        try {
            Event::create($request->all());
            return redirect()->back()->with([
                'message' => Settings::alert('Sucesso', 'Evento cadastrado com sucesso', Constants::FEEDBACK_INFO)
            ]);
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));
            return redirect()->back()->withErrors($errors);
        }
    }
    public function update(Request $request)
    {
        //nomes amigaveis
        $customAttributes = [
            'name' => 'nome',
            'date_start' => 'data inicial',
            'date_end' => 'data final',
            'time_start' => 'hora inicial',
            'time_end' => 'hora final',
            'text_color' => 'cor do texto',
            'text_background' => 'cor do fundo do texto',
        ];
        //validação
        $request->validate([
            'name' => 'required|min:3|max:100',
            'date_start' => [
                'required',
                'date',
                //caso data diferente do valor antigo tem que ser maior ou igual data atual
                Rule::when(request()->input('date_start') !== $request->old_date_start, [
                    'after_or_equal:' . Carbon::now()->startOfDay(),
                ]),
                //caso data igual seu valor antigo, antes de ser editado, pode ser salva
                Rule::when(request()->input('date_start') === $request->old_date_start, [
                    'date',
                ]),
            ],
            'date_end' => 'required|date|after_or_equal:date_start',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after_or_equal:time_start',
            'text_color' => 'required|max:20',
            'text_background' => 'required|max:20'
        ], [
            //formatando data para mensagem de erro
            'date_start.after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a ' . Carbon::now()->startOfDay()->format('d/m/Y'),
        ], $customAttributes);
        try {
            //usei o find para capturar o observer
            Event::find($request->id)->update($request->except(['old_date_start', 'id'])); //except, não necessarios para atualização em array
            Historic::create(['registry' => "O evento " . Event::find($request->id)->name . " foi editado"]);
            return redirect()->back()->with([
                'message' => Settings::alert('Sucesso', 'Evento atualizado com sucesso', Constants::FEEDBACK_INFO)
            ]);
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));
            return redirect()->back()->withErrors($errors);
        }
    }
    public function cancel(Request $request)
    {
        try {
            $event = Event::find($request->id);
            if ($event->status == EventStatus::CANCELED->value || $event->status == EventStatus::CONCLUDED->value) {
                return redirect()->back()->with([
                    'message' => Settings::alert('Atenção!', 'Eventos concluidos ou cancelados não podem ser cancelados', Constants::FEEDBACK_WARNING)
                ]);
            } else {
                $event->update([
                    'status' => 'canceled'
                ]);
                Historic::create(['registry' => "O evento " . Event::find($request->id)->name . " foi cancelado"]);
                return redirect()->back()->with([
                    'message' => Settings::alert('Sucesso', 'Evento cancelado com sucesso', Constants::FEEDBACK_INFO)
                ]);
            }
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));
            return redirect()->back()->withErrors($errors);
        }
    }
    public function delete(Request $request)
    {
        try {
            Event::find($request->id)->delete();
            return redirect()->back()->with([
                'message' => Settings::alert('Sucesso', 'Evento deletado com sucesso', Constants::FEEDBACK_INFO)
            ]);
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));
            return redirect()->back()->withErrors($errors);
        }
    }
    public function restore(Request $request)
    {
        try {
            //restaura apenas deletados
            Event::onlyTrashed()->find($request->id)->restore();
            return redirect()->back()->with([
                'message' => Settings::alert('Sucesso', 'Evento resaturado com sucesso', Constants::FEEDBACK_INFO)
            ]);
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));
            return redirect()->back()->withErrors($errors);
        }
    }
}
