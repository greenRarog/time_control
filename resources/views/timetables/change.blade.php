<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ученик {{ $student->name }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">


</head>
<body>
расписание ученика {{ $student->name }}</br>
<div class="main">
    <div>{!! $before_month_calendar !!}</div>
    <div>{!! $actual_calendar !!}</div>
    <div>{!! $next_month_calendar !!}</div>
</div>
<div class="menu hidden">
</div>
<div class="create_menu hidden">
    <form class="create_menu">
        @csrf
        <span class="create_menu_header">Добавление урока</span>
        <div class="create_menu_elem">
            student_id:
            <input class="create_menu_input" name="student_id" value={{ $id }}>
            <br>
        </div>
        <div class="create_menu_elem">
            Date:
            <input class="create_menu_input" name="date">
            <br>
        </div>
        <div class="create_menu_elem">
            Time:
            <input class="create_menu_input" name="time">
            <br>
        </div>
        <div class="create_menu_elem">
            Paid:
            <input class="create_menu_input" name="paid">
            <br>
        </div>
        <div class="create_menu_elem">
            Status:
            <input class="create_menu_input" name="status">
            <br>
        </div>
        <div class="create_menu_elem">
            Cost:
            <input class="create_menu_input" name="cost">
            <br>
        </div>
        <div class="create_menu_elem">
            <input class="create_menu_input" type="submit" value="добавить урок">
        </div>
    </form>
    <div class="create_menu_elem">
        <button class="close_create_button">закрыть меню</button>
    </div>
</div>
<div class="edit_menu hidden">
    <form class="edit_menu" method="POST">
        @csrf
        <span class="edit_menu_header">Изменение существующего урока</span>
        <div class="edit_menu_elem">
            ID:
            <input class='edit_menu_input' name="id">
            <br>
        </div>
        <div class="edit_menu_elem">
            student_ID:
            <input class='edit_menu_input' name="student_id">
            <br>
        </div>
        <div class="edit_menu_elem">
            Date:
            <input class='edit_menu_input' name="date">
            <br>
        </div>
        <div class="edit_menu_elem">
            Time:
            <input class='edit_menu_input' name="time">
            <br>
        </div>
        <div class="edit_menu_elem">
            Paid:
            <input class='edit_menu_input' name="paid">
            <br>
        </div>
        <div class="edit_menu_elem">
            Status:
            <input class='edit_menu_input' name="status">
            <br>
        </div>
        <div class="edit_menu_elem">
            Cost:
            <input class='edit_menu_input' name="cost">
            <br>
        </div>
        <div class="edit_menu_elem">
            <input class="edit_menu_input" type="submit" value="обновить урок">
        </div>
    </form>
    <div class="edit_menu_elem">
        <button class="close_edit_button">закрыть меню</button>
    </div>
</div>

<script src="{{ asset('js/handmade_script.js') }}"></script>
</body>
</html>
