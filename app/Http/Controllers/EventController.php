<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Class\Settings;
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
            'pickerInputStart' => 'data inicial',
            'pickerInputEnd' => 'data final',
            'time_start' => 'hora inicial',
            'time_end' => 'hora final',
            'colorText' => 'cor do texto',
            'bgColor' => 'cor do fundo do texto',
        ];
        $request->validate([
            'name' => 'required|min:3|max:100',
            'pickerInputStart' => [
                'required',
                'date',
                'after_or_equal:' . Carbon::now()->startOfDay()
            ],
            'pickerInputEnd' => 'required|date|after_or_equal:pickerInputStart',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after_or_equal:time_start',
            'colorText' => 'required|max:20',
            'bgColor' => 'required|max:20'
        ], [
            'pickerInputStart.after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a '.Carbon::now()->startOfDay()->format('d/m/Y')
        ], $customAttributes);
        try {
            dd($request->all());
        } catch (\Exception $e) {
            $errors = new MessageBag();
            // add your error messages:
            $errors->add('error', Settings::erroInesperadoAlert(texto:$e->getMessage()));

        }
    }
}
