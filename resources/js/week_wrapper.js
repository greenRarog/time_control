let tds = document.querySelectorAll('td');
for(let td of tds){
    td.addEventListener('click', function(){
        let olds = document.querySelectorAll('.active');
        for(let old of olds){
            old.classList.remove('active');
        }
        this.classList.add('active');
        let year = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute('year');
        let month = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute('month');
        let day = this.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute('day');
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
        console.log(lessons[lesson]);
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
        change_button.addEventListener('click', bind.change(change_button, lessons[lesson]));
        let remove_button = document.createElement('button');
        remove_button.innerHTML = 'X';
        remove_button.classList.add('lesson_remove_button');
        menu.append(remove_button);
        remove_button.addEventListener('click', function(){
            console.log('remove!');
        });
    }
}

function change(lesson){
    hidden_all();
    let menu_edit = document.querySelector('div.menu_edit_lesson');
    menu_edit.innerHTML = '';
    menu_edit.classList.remove('hidden');
    let divDate = document.createElement('div');
    let spanDate = document.createElement('span');
    spanDate.innerHTML = 'Дата :';
    divDate.append(spanDate);
    let inputDate = document.createElement('input');
    inputDate.value = lesson.date;
    divDate.append(inputDate);
    let divTime = document.createElement('div');
    let spanTime = document.createElement('span');
    spanTime.innerHTML = 'Время :';
    divTime.append(spanTime);
    let inputTime = document.createElement('input');
    inputTime.value = lesson.time;
    divTime.append(inputTime);
    let divPaid = document.createElement('div');
    let spanPaid = document.createElement('span');
    spanPaid.innerHTML = 'Оплата :';
    divPaid.append(spanPaid);
    //тут надо с оплатой выебнуться мне кажется
    let divStatus = document.createElement('div');
    let spanStatus = document.createElement('span');
    spanStatus.innerHTML = 'Статус :';
    divStatus.append(spanStatus);
    //тут надо со статусом выебнуться мне кажется

    menu_edit.append(divDate);
    menu_edit.append(divTime);
    menu_edit.append(divPaid);
    menu_edit.append(divStatus);
}
function hidden_all(){
    let menu_lesson = document.querySelector('.menu_lesson');
    let menu_edit_lesson = document.querySelector('.menu_edit_lesson');
    menu_lesson.classList.add('hidden');
    menu_edit_lesson.classList.add('hidden');
}
