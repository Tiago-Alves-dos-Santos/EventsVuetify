<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
        // dd($request->all());
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
        ]);
        try {
            //code...
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
