<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .hidden{
            display: none !important;
        }
        td:hover{
            background: yellow;
            cursor: pointer;
        }
        .active{
            background: yellow;
        }
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
        .main{
            display:flex;
            justify-content: space-around;
        }
        .menu {
            border: 5px solid black;
            display: inline-block;
        }
        .menu_button{
            display: block;
        }
    </style>
    <title>ученик {{ $student->name }}</title>
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
    <form class="create_menu" method="POST">
        <span class="create_menu_header">Добавление урока</span>
        <div class="create_menu_elem">student_id: <input name="student_id" value={{ $id }}><br></div>
        <div class="create_menu_elem">Date: <input name="date"><br></div>
        <div class="create_menu_elem">Time: <input name="time"><br></div>
        <div class="create_menu_elem">Paid: <input name="paid"><br></div>
        <div class="create_menu_elem">Status: <input name="status"><br></div>
        <div class="create_menu_elem">Cost: <input name="cost"><br></div>
        <div class="create_menu_elem"><input type="submit" value="добавить урок"></div>
    </form>
    <div class="create_menu_elem"><button class="close_edit_button">закрыть меню</button></div>
</div>
<div class="edit_menu hidden">
<form class="edit_menu" method="POST">
    <span class="edit_menu_header">Изменение существующего урока</span>
    <div class="edit_menu_elem">ID: <input name="id"><br></div>
    <div class="edit_menu_elem">student_ID: <input name="student_id"><br></div>
    <div class="edit_menu_elem">Date: <input name="date"><br></div>
    <div class="edit_menu_elem">Time: <input name="time"><br></div>
    <div class="edit_menu_elem">Paid: <input name="paid"><br></div>
    <div class="edit_menu_elem">Status: <input name="status"><br></div>
    <div class="edit_menu_elem">Cost: <input name="cost"><br></div>
    <div class="edit_menu_elem"><input type="submit" value="обновить урок"></div>
</form>
<div class="edit_menu_elem"><button class="close_edit_button">закрыть меню</button></div>
</div>
<script>
let tds = document.querySelectorAll('td');
let inputDay = document.querySelector('.inputDay');
for(let td of tds){
    td.addEventListener('click', getInfo);
}
function getInfo(){
    let olds = document.querySelectorAll('.active');
    for(let old of olds){
        old.classList.remove('active');
    }
    this.classList.add('active');
    let table = this.parentNode.parentNode.parentNode;
    let year = table.getAttribute('tableyear');
    let month = table.getAttribute('tablemonth');
    let day = this.innerHTML;
    if (day<10) {
        day = '0' + day;
    }
    let date = year + '-' + month + '-' + day;
    fetch('api/read/' + year + '/' + month + '/' + day).then(
        response => {
            return response.json();
        }
    ).then(
        data => {
            create_menu(data.array, date);
        }
    )
}
function hiddenAll(){
    let menu = document.querySelector('div.menu');
    menu.classList.add('hidden');
    let edit_menu = document.querySelector('div.edit_menu');
    edit_menu.classList.add('hidden');
    let create_menu = document.querySelector('div.create_menu');
    create_menu.classList.add('hidden');
}
function create_menu(lessons, date){
    let menu_div = document.querySelector('div.menu');
    hiddenAll();
    menu_div.classList.remove('hidden');
    menu_div.innerHTML = '';
    let header_menu = document.createElement('h3');
    header_menu.innerHTML = 'меню дня';
    menu_div.append(header_menu);
    let create_button = document.createElement('button');
    create_button.classList.add('menu_button');
    create_button.innerHTML = 'добавить урок';
    create_button.addEventListener('click', create_menu_create.bind(create_button, date));
    menu_div.append(create_button);
    create_edit_button(lessons);
    let close_button = document.createElement('button');
    close_button.innerHTML = 'закрыть меню';
    close_button.classList.add('menu_button');
    menu_div.append(close_button);
    close_button.addEventListener('click', function(){
        let menu_div = document.querySelector('div.menu');
        menu_div.classList.add('hidden');
    })
}
function create_edit_button(lessons){
    let menu_div = document.querySelector('div.menu');
    for(let lesson in lessons) {
        let edit_button = document.createElement('button');
        edit_button.classList.add('menu_button');
        edit_button.innerHTML = 'изменить урок на ' + lessons[lesson].time;
        edit_button.setAttribute('id', lesson);
        edit_button.setAttribute('student_id', lessons[lesson].student_id);
        edit_button.setAttribute('time', lessons[lesson].time);
        edit_button.setAttribute('date', lessons[lesson].date);
        edit_button.setAttribute('paid', lessons[lesson].paid);
        edit_button.setAttribute('status', lessons[lesson].status);
        edit_button.setAttribute('cost', lessons[lesson].cost);
        menu_div.append(edit_button);
        edit_button.addEventListener('click', create_edit_menu.bind(edit_button));
    }
}
function create_edit_menu(){
    hiddenAll();
    let edit_menu = document.querySelector('div.edit_menu');
    edit_menu.classList.remove('hidden');
    let input_id = document.querySelector(`input[name='id']`);
    input_id.value = this.getAttribute('id');
    let input_student_id = document.querySelector(`input[name='student_id']`);
    input_student_id.value = this.getAttribute('student_id');
    let input_date = document.querySelector(`input[name='date']`);
    input_date.value = this.getAttribute('date');
    let input_time = document.querySelector(`input[name='time']`);
    input_time.value = this.getAttribute('time');
    let input_paid = document.querySelector(`input[name='paid']`);
    input_paid.value = this.getAttribute('paid');
    let input_status = document.querySelector(`input[name='status']`);
    input_status.value = this.getAttribute('status');
    let input_cost = document.querySelector(`input[name='cost']`);
    input_cost.value = this.getAttribute('cost');
    let close_button = document.querySelector('button.close_edit_button');
    close_button.addEventListener('click', function(){
       let edit_menu = document.querySelector('div.edit_menu');
       edit_menu.classList.add('hidden');
    });
}
function create_menu_create(date){
    hiddenAll();
    let menu_create = document.querySelector('div.create_menu');
    menu_create.classList.remove('hidden');
    let inputDate = document.querySelector(`input.create_menu_elem[name='date']`);
    inputDate.value = date;
}
function update(){

}
</script>
</body>
</html>
