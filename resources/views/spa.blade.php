<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravue</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <app></app>
    </div>

    {{-- <script src=/static/tinymce4.7.5/tinymce.min.js></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
