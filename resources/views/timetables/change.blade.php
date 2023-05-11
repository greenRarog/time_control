<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
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
        .edit{
            display: inline-block;
            padding: 15px;
            border: 1px solid black;
        }
        .edit_elem{
            padding: 5px;
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
        <input hidden class="inputMonth"><br>
        <input hidden class="inputDay"><br>
        <input hidden class="inputYear"><br>
</div>
<div class="edit" >
    <div class="edit_elem"><input name="id"><br></div>
    <div class="edit_elem">Date: <input name="date"><br></div>
    <div class="edit_elem">Time: <input name="time"><br></div>
    <div class="edit_elem">Paid: <input name="paid"><br></div>
    <div class="edit_elem">Status: <input name="status"><br></div>
    <div class="edit_elem">Cost: <input name="cost"><br></div>
    <div class="edit_elem"><button>edit</button></div>
</div>
<script>
let tables = document.querySelectorAll('table');
let inputMonth = document.querySelector('.inputMonth');
let inputYear = document.querySelector('.inputYear');
for(let table of tables){
    table.addEventListener('click', function(){
        inputMonth.value = table.getAttribute('tablemonth');
        inputYear.value = table.getAttribute('tableyear');
    });
}

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
    fetch('api/' + year + '/' + month + '/' + day).then(
        response => {
            return response.json();
        }
    ).then(
        data => {
            console.log(data);
            data_transform(data);
        }
    )
}

function data_transform(data){
    if(data.not_empty) {
        fill_edit(data.array);
    } else {
        alert('в этот день нет уроков!');
    }
}

function fill_edit(obj){
    let id = document.querySelector(`input[name="id"]`);
    let date = document.querySelector(`input[name="data"]`);
    let time = document.querySelector(`input[name="time"]`);
    let status = document.querySelector(`input[name="status"]`);
    let paid = document.querySelector(`input[name="paid"]`);
    let cost = document.querySelector(`input[name='cost']`);
    console.log(obj);
    id.value = obj.id;
    date.value = obj.date;
    time.value = obj.time;
    status.value = obj.status;
    paid.value = obj.paid;
    cost.value = obj.cost;
}
</script>
</body>
</html>
