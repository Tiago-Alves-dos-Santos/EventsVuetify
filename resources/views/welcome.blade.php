<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>
<body>

    <div id="app" style="width: 100%">
        <v-app app>
            <example-tify></example-tify>
            <v-container>
                <v-alert
                border="left"
                color="indigo"
                dark
                >
                I'm an alert with a border left type info
                </v-alert>
            </v-container>
        </v-app>
    </div>

    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
