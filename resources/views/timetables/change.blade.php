<x-app-layout>
<div class="main">
    <div>{!! $before_month_calendar !!}</div>
    <div>{!! $actual_calendar !!}</div>
    <div>{!! $next_month_calendar !!}</div>
</div>

<div class="massive_change_menu hidden">
    <button class="massive_remove_lessons">удалить все уроки</button>
    <button class="massive_add_lessons">добавить периодичный урок</button>
    <button class="close_button">Х</button>
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
        <button class="close_button">X</button>
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
        <button class="close_button">X</button>
    </div>
</div>
</x-app-layout>
