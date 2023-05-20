<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .notdone{
            background: lightcoral;
        }
        .done{
            background: lightgreen;
        }
        .close{
            background: darkkhaki;
        }
        .headerMonth{
            text-align: center;
            font-size: 20px;
            text-decoration: underline;
        }
        .paid{
            border:3px solid lightgreen;
        }
        .notpaid{
            border:3px solid lightcoral;
        }
        .notpaid.close{
            background: none;
            border: 0px;
        }
    </style>
    <title>Недельное расписание</title>

</head>
<body>
<div>
    {{ $last_week }}
    {{ $actual_week }}
    {{ $next_week }}
</div>
</body>
</html>
