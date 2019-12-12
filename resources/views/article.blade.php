<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset=utf-8>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <!-- Styles -->
  <title>{{$title}}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body>
<div id="app">
  <div style="max-width: 960px;margin: 0 auto;">
    <div style="padding: 10px 0;display: none;">
      <h1>{{$title}}</h1>
      <div style="color: #8799a3">{{$created_at}}</div>
    </div>
    <div style="padding: 0;">{!! $content !!}</div>
  </div>
</div>
</body>
</html>
