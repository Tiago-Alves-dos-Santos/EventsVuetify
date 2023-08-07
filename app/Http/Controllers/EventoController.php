<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Home',[
            'pageValue' => 0
        ]);
    }
    public function eventos(Request $request)
    {
        return Inertia::render('Evento',[
            'pageValue' => 1
        ]);
    }
}
