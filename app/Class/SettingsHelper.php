<?php
namespace App\Class;


use App\Class\ConstantHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingsHelper
{
    public static function erroInesperadoAlert($texto, $titulo = 'Erro na execução', $tipo = ConstantHelper::FEEDBACK_ERROR)
    {
        return [
            'titulo' => $titulo,
            'texto' => $texto,
            'icon' => $tipo,
            'show' => true,
        ];
    }
    public static function alert($titulo,$texto, $tipo = ConstantHelper::FEEDBACK_INFO)
    {
        return [
            'titulo' => $titulo,
            'texto' => $texto,
            'icon' => $tipo,
            'show' => true,
        ];
    }
    public static function toast($titulo,$texto, $tipo = ConstantHelper::FEEDBACK_INFO)
    {
        return [
            'titulo' => $titulo,
            'texto' => $texto,
            'icon' => $tipo,
            'show' => true,
        ];
    }

}
