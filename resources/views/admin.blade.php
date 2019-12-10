<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('/dist/css/backend/app.css') }}" rel="stylesheet">
    <title>{{$config['title']}}</title>

    <!-- Fonts -->

    <!-- Styles -->
    <style>

    </style>
</head>
<body>
<div id="app"></div>
<script>
    window.config = {
        logo: '{{$config['logo']}}',
        header_name: '{{$config['header_name']}}',
    }
</script>
<script src="{{ mix('/dist/js/backend/app.js') }}"></script>
</body>
</html>