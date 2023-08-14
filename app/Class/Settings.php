<?php
namespace App\Class;



use App\Class\Constants;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class Settings
{
    public static function erroInesperadoAlert($texto, $titulo = 'Erro na execução', $tipo = Constants::FEEDBACK_ERROR)
    {
        return [
            'titulo' => $titulo,
            'texto' => $texto,
            'icon' => $tipo,
            'show' => true,
        ];
    }
    public static function alert($titulo,$texto, $tipo = Constants::FEEDBACK_INFO)
    {
        return [
            'titulo' => $titulo,
            'texto' => $texto,
            'icon' => $tipo,
            'show' => true,
        ];
    }
    public static function toast($titulo,$texto, $tipo = Constants::FEEDBACK_INFO)
    {
        return [
            'titulo' => $titulo,
            'texto' => $texto,
            'icon' => $tipo,
            'show' => true,
        ];
    }

}
