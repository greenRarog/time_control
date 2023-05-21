<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="app.css">
    <title>Недельное расписание</title>

</head>
<body>
<div class="main">
    {!! $last_week !!}
    {!! $actual_week !!}
    {!! $next_week !!}
</div>
</body>
</html>
