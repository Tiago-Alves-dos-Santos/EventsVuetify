<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Evento Fácil</title>
    <link rel="icon" href="{{ asset('img/favicon/favico.ico') }}">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @inertiaHead
    {{-- Pacote ziggy --}}
    @routes
  </head>
  <body>
    @inertia
  </body>
</html>

