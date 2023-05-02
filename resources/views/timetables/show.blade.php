<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .notdone{
        background: lightcyan;
        }
        .done{
            background: lightgray;
        }
        .close{
            background: darkkhaki;
        }
    </style>
    <title>Laravel</title>

</head>
<body>
show_table {{ $id }}</br>
<table>
    <thead>
    <tr>
        <th>ПН</th>
        <th>ВТ</th>
        <th>СР</th>
        <th>ЧТ</th>
        <th>ПТ</th>
        <th>СБ</th>
        <th>ВСК</th>
    </tr>
    </thead>
    <tbody>
        {!! $calendar !!}
    </tbody>
</table>


</body>
</html>
