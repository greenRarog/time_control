<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="app.css">

    <title>Недельное расписание</title>
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
<script>
let tds = document.querySelectorAll('td');
for(let td of tds){
    td.addEventListener('click', function(){
        let olds = document.querySelectorAll('.active');
        for(let old of olds){
            old.classList.remove('active');
        }
        this.classList.add('active');
        let year = this.getAttribute('year');
        let month = this.getAttribute('month');
        let day = this.getAttribute('day');
        if (day<10){
            day = '0' + day;
        }
        let time = this.innerHTML.substr(0,8);
        fetch('api/read?year=' + year + '&month=' + month + '&day=' + day + '&time=' + time).then(
            response => {
                return response.json();
            }
                ).then(
            data => {
                menu_lesson(data.array);
            }
            )
     });
}
function menu_lesson(lessons){
    hidden_all();
    let menu = document.querySelector('div.menu_lesson');
    menu.innerHTML = '';
    menu.classList.remove('hidden');
    let header = document.createElement('h4');
    header.innerHTML = 'меню урока';
    menu.append(header);
    menu.classList.remove('hidden');
    for(let lesson in lessons) {
        let nameSpan = document.createElement('span');
        nameSpan.innerHTML = 'ученик: ' + lessons[lesson].name + '<br>';
        menu.append(nameSpan);
        let dateSpan = document.createElement('span');
        dateSpan.innerHTML = 'дата: ' + lessons[lesson].date + '<br>время: ' + lessons[lesson].time + '<br>';
        menu.append(dateSpan);
        let paidSpan = document.createElement('span');
        if(lessons[lesson].paid){
            paidSpan.innerHTML = 'урок оплачен <br>';
        } else {
            paidSpan.innerHTML = 'урок еще оплачен<br>';
        }
        menu.append(paidSpan);
        let change_button = document.createElement('button');
        change_button.innerHTML = 'изменить';
        change_button.classList.add('lesson_change_button');
        menu.append(change_button);
        change_button.addEventListener('click', create_change_menu(lessons[lesson]));
        let remove_button = document.createElement('button');
        remove_button.innerHTML = 'удалить урок';
        remove_button.classList.add('lesson_remove_button');
        remove_button.addEventListener('click', menu_remove_lesson(lessons[lesson]));
        menu.append(remove_button);
    }
}
function menu_remove_lesson(lesson) {
    return function () {
        hidden_all()
        let menu_remove_lesson = document.querySelector('div.menu_remove_lesson');
        menu_remove_lesson.classList.remove('hidden');
        menu_remove_lesson.innerHTML = 'если хотите удалить урок напишите слово УДАЛИТЬ<br>';
        let inputConfirm = document.createElement('input');
        inputConfirm.classList.add('input_confirm_delete');
        menu_remove_lesson.append(inputConfirm);
        menu_remove_lesson.innerHTML += '<br>';
        let buttonConfirmRemove = document.createElement('button');
        buttonConfirmRemove.innerHTML = 'удалить';
        buttonConfirmRemove.addEventListener('click', remove_lesson(lesson.lesson_id));
        menu_remove_lesson.append(buttonConfirmRemove);
        let buttonCloseMenuRemove = document.createElement('button');
        buttonCloseMenuRemove.innerHTML = 'закрыть';
        buttonCloseMenuRemove.addEventListener('click', hidden_all);
        menu_remove_lesson.append(buttonCloseMenuRemove);
    }
}
function remove_lesson(id) {
    return function () {
        let value = document.querySelector('input.input_confirm_delete').value;
        if (value == 'УДАЛИТЬ') {
            fetch('/api/delete/' + id).then(
                response => {
                    return response.text();
                }
            ).then(
                text => {
                    console.log(text);
                }
            )
        } else {
            alert('удаление НЕ подтверждено! или подтвердите или закройте!');
        }
    }
}
function create_change_menu(lesson) {
    return function () {
        hidden_all();
        let menu_edit = document.querySelector('div.menu_edit_lesson');
        menu_edit.classList.remove('hidden');
        let edit_form = document.querySelector('form.edit_form');
        edit_form.innerHTML = '';
        let divDate = document.createElement('div');
        let spanDate = document.createElement('span');
        spanDate.innerHTML = 'Дата :';
        divDate.append(spanDate);
        let inputDate = document.createElement('input');
        inputDate.value = lesson.date;
        inputDate.setAttribute('name','date');
        divDate.append(inputDate);
        let divTime = document.createElement('div');
        let spanTime = document.createElement('span');
        spanTime.innerHTML = 'Время :';
        divTime.append(spanTime);
        let inputTime = document.createElement('input');
        inputTime.value = lesson.time;
        inputTime.setAttribute('name','time');
        divTime.append(inputTime);
        let divPaid = document.createElement('div');
        divPaid.classList.add('div_paid');
        let spanPaid = document.createElement('span');
        spanPaid.innerHTML = 'Оплата :';
        divPaid.append(spanPaid);
        let selectPaid = document.createElement('select');
        selectPaid.setAttribute('name', 'paid');
        let optionPaid = document.createElement('option');
        optionPaid.innerHTML = 'оплачен';
        optionPaid.setAttribute('value', true);
        selectPaid.append(optionPaid);
        let optionNotPaid = document.createElement('option');
        optionNotPaid.innerHTML = 'не оплачен';
        optionNotPaid.setAttribute('value', false);
        selectPaid.append(optionNotPaid);
        if(lesson.paid){
            optionPaid.setAttribute('selected', true);
        } else {
            optionNotPaid.setAttribute('selected', false);
        }
        divPaid.append(selectPaid);
        let divStatus = document.createElement('div');
        let spanStatus = document.createElement('span');
        spanStatus.innerHTML = 'Статус :';
        divStatus.append(spanStatus);
        let selectStatus = document.createElement('select');
        selectStatus.setAttribute('name', 'status');
        let optionDone = document.createElement('option');
        optionDone.innerHTML = 'урок проведен';
        optionDone.setAttribute('value', 'done');
        selectStatus.append(optionDone);
        let optionNotDone = document.createElement('option');
        optionNotDone.innerHTML = 'урок не проведен';
        optionNotDone.setAttribute('value', 'notdone');
        selectStatus.append(optionNotDone);
        let optionClose = document.createElement('option');
        optionClose.innerHTML = 'урок отменен';
        optionClose.setAttribute('value', 'close');
        selectStatus.append(optionClose);
        if (lesson.status == 'done') {
            optionDone.setAttribute('selected', 'true');
        } else if(lesson.status == 'notdone'){
            optionNotDone.setAttribute('selected', 'true');
        } else {
            optionClose.setAttribute('selected', 'true');
        }
        divStatus.append(selectStatus);
        let buttonUpdate = document.createElement('input');
        buttonUpdate.classList.add('update_button');
        buttonUpdate.value = 'изменить';
        buttonUpdate.setAttribute('type', 'submit');
        edit_form.addEventListener('submit', change_lesson);
        let buttonClose = document.createElement('button');
        buttonClose.innerHTML = 'закрыть';
        buttonClose.setAttribute('type','button');
        buttonClose.addEventListener('click', hidden_all);
        let inputId = document.createElement('input');
        inputId.setAttribute('name', 'id');
        inputId.classList.add('hidden');
        inputId.value = lesson.lesson_id;
        edit_form.append(inputId);
        edit_form.append(divDate);
        edit_form.append(divTime);
        edit_form.append(divPaid);
        edit_form.append(divStatus);
        edit_form.append(buttonUpdate);
        edit_form.append(buttonClose);
    }
}
function change_lesson(event) {
    fetch('/student/api/update', {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    }).then(
        response => {
            return response.text()
        }
    ).then(
        text => {
            alert(text);
        }
    )
    hidden_all();
    event.preventDefault();
}

function hidden_all(){
    let menu_lesson = document.querySelector('div.menu_lesson');
    let menu_edit_lesson = document.querySelector('div.menu_edit_lesson');
    let menu_remove_lesson = document.querySelector('div.menu_remove_lesson');
    menu_lesson.classList.add('hidden');
    menu_edit_lesson.classList.add('hidden');
    menu_remove_lesson.classList.add('hidden');
}
</script>
</html>
