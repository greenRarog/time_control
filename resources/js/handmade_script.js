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
    let student_id = table.getAttribute('student_id');
    if (day<10) {
        day = '0' + day;
    }
    let date = year + '-' + month + '-' + day;
    fetch('/api/read/?student_id=' + student_id + '&year=' + year + '&month=' + month + '&day=' + day).then(
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
    let massive_change_menu = documen.querySelector('div.massive_change_menu');
    massive_change_menu.classList.add('hidden');
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
    close_button.addEventListener('click', hiddenAll);
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
        edit_button.addEventListener('click', create_edit_menu);
    }
}
function create_edit_menu(){
    hiddenAll();
    let edit_menu = document.querySelector('div.edit_menu');
    edit_menu.classList.remove('hidden');
    let input_id = document.querySelector(`input.edit_menu_input[name='id']`);
    input_id.value = this.getAttribute('id');
    let input_student_id = document.querySelector(`input.edit_menu_input[name='student_id']`);
    input_student_id.value = this.getAttribute('student_id');
    let input_date = document.querySelector(`input.edit_menu_input[name='date']`);
    input_date.value = this.getAttribute('date');
    let input_time = document.querySelector(`input.edit_menu_input[name='time']`);
    input_time.value = this.getAttribute('time');
    let input_paid = document.querySelector(`input.edit_menu_input[name='paid']`);
    input_paid.value = this.getAttribute('paid');
    let input_status = document.querySelector(`input.edit_menu_input[name='status']`);
    input_status.value = this.getAttribute('status');
    let input_cost = document.querySelector(`input.edit_menu_input[name='cost']`);
    input_cost.value = this.getAttribute('cost');
    let form_update = document.querySelector('form.edit_menu');
    form_update.addEventListener('submit', update);
    let close_button = document.querySelector('button.close_edit_button');
    close_button.addEventListener('click', hiddenAll);
}
function create_menu_create(date){
    hiddenAll();
    let menu_create = document.querySelector('div.create_menu');
    menu_create.classList.remove('hidden');
    let inputDate = document.querySelector(`input.create_menu_input[name='date']`);
    inputDate.value = date;
    let close_button = document.querySelector('button.close_create_button');
    close_button.addEventListener('click', hiddenAll);
}
function update(event){
    let TestForm = new FormData(this);
    fetch('/student/api/update', {
        method: 'POST',
        body: TestForm,
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
    //event.preventDefault();
}

let massive_change_lessons = document.querySelector('button.massive_change_lessons');
massive_change_lessons.addEventListener('click', function(){
    hiddenAll();
    let menu = documen.querySelector('div.massive_change_menu');
    menu.classList.remove('hidden');
})

let massive_remove_lessons = document.querySelector('button.massive_remove_lessons');
massive_remove_lessons.addEventListener('click', function(){
    console.log('remove all');
})

let massive_add_lessons = document.querySelector('button.massive_add_lessons');
massive_add_lessons.addEventListener('click', function(){
    console.log('add');
})

let close_buttons = document.querySelectorAll('button.close_button');
for(let button of close_buttons){
    button.addEventListener('click', hiddenAll);
}
