<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Недельное расписание</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
</head>
<body>
<div class="support">обозначения<br>
    <div class="paid">урок оплачен</div>
    <div class="notpaid">урок НЕ оплачен</div>
    <div class="done">урок проведен</div>
    <div class="notdone">урок НЕ проведет</div>
    <div class="close">урок закрыт(не проведен и проведен не будет)</div>
</div>

<div class="main">
    {!! $last_week !!}
    {!! $actual_week !!}
    {!! $next_week !!}
</div>
<div class="menu_lesson hidden"></div>
<div class="menu_edit_lesson hidden">
    <form class="edit_form" method="POST"></form>
</div>
<div class="menu_remove_lesson hidden"></div>
</body>
<script src="{{ asset('js/week_wrapper.js') }}"></script>
</html>
