<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Event;
use App\Class\Settings;
use App\Class\Constants;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::get();
        //montagem de array de acordo com oq v-calendar pede
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
            'pageValue' => 0,
            'events' => $events

        ]);
    }
    public function viewEventos(Request $request)
    {
        $events = Event::get();
        //formatação de datas e status em português
        $events = $events->map(function ($event) {
            $event->date_start_formated =  $event->date_start . ' ' . $event->time_start;
            $event->date_end_formated =  $event->date_end . ' ' . $event->time_end;
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
            //formatação de data para mensagem de erro
            'date_start.after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a ' . Carbon::now()->startOfDay()->format('d/m/Y')
        ], $customAttributes);

        try {
            Event::create($request->all());
            return redirect()->back()->with([
                'message' => Settings::alert('Sucesso', 'Usuario cadastrado com sucesso', Constants::FEEDBACK_INFO)
            ]);
        } catch (\Exception $e) {//erros não trabalhados front-end
            dd($e->getMessage());
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
            //usei o find para capturar o observer,
            Event::find($request->id)->update($request->except(['old_date_start', 'id']));//except, não necessarios para atualização em array
            return redirect()->back()->with([
                'message' => Settings::alert('Sucesso', 'Usuario atualizado com sucesso', Constants::FEEDBACK_INFO)
            ]);
        } catch (\Exception $e) {//erros não trabalhados front-end
            dd($e->getMessage());
            $errors = new MessageBag();
            $errors->add('error', Settings::erroInesperadoAlert($e->getMessage()));
            return redirect()->back()->withErrors($errors);
        }
    }
}
