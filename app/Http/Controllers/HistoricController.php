<?php

namespace App\Http\Controllers;

use App\Models\Historic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoricController extends Controller
{
    public function index(Request $request)
    {
        $historics = Historic::orderBy('id', 'desc')->get();
        //formatação de datas e status em português
        $historics = $historics->map(function ($historic) {
            $historic->created_at_formatted =  $historic->created_at;
            return $historic;
        });
        return Inertia::render('Historic', [
            'pageValue' => 'historic.index',
            'historics' => $historics
        ]);
    }
    public function truncate()
    {
        Historic::truncate();
    }
}
