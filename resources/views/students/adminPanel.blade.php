<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="adminPanel.css">

    <title>Администрирование учеников</title>
</head>
<body>
<a href="/create">добавить нового ученика!</a>
<table>
    <thead>
    <tr>
        <th>Имя</th>
        <th>Расписание</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $student)
    <tr>
        <td>{{ $student->name }}</td>
        <td><a href="change/{{ $student->id }}">расписание ученика</a></td>
        <td><button class='remove_button' student_id="{{ $student->id }}">удалить</button></td>
    </tr>
    @endforeach
    </tbody>
</table>
<div class="hidden remove_menu">
</div>
<script>
    let buttons_remove = document.querySelectorAll('button.remove_button');
    for(let button of buttons_remove){
        button.addEventListener('click', create_remove_menu);
    }

    function create_remove_menu(){
        let menu = document.querySelector('div.remove_menu');
        menu.classList.remove('hidden');
        menu.innerHTML = 'если желаете удалить ученика напишите УДАЛИТЬ';
        let input = document.createElement('input');
        input.classList.add('remove_input');
        menu.append(input);
        let button_end_remove = document.createElement('button');
        button_end_remove.innerHTML = 'удалить';
        button_end_remove.addEventListener('click', function(){
            let input = document.querySelector('input.remove_input');
            if(input.value === 'УДАЛИТЬ') {
                alert('удален');
                hidden();
            } else {
                alert('не удален!');
            }
        });
        menu.append(button_end_remove);
        let button_close = document.createElement('button');
        button_close.innerHTML = 'закрыть';
        button_close.addEventListener('click', hidden);
        menu.append(button_close);
    }
    function hidden() {
        let remove_menu = document.querySelector('div.remove_menu');
        remove_menu.classList.add('hidden');
    }
</script>
</body>
</html>
