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
</div>

<script>
let tables = document.querySelectorAll('table');
let inputMonth = document.querySelector('.inputMonth');
for(let table of tables){
    table.addEventListener('click', function(){
        inputMonth.value = table.getAttribute('tablemonth');
    });
}

let tds = document.querySelectorAll('td');
let inputDay = document.querySelector('.inputDay');
for(let td of tds){
    td.addEventListener('click', function() {
        inputDay.value = td.innerHTML;
        let old = document.querySelectorAll('.active');
        for(let o of old){
            o.classList.remove('active');
        }
        td.classList.add('active');
    });
}

function getInfo(day, month){
    fetch('api/' + month + '/' + day).then(
        response => {
            return response.text();
        }
    ).then(
        text => {
            console.log(text);
        }
    )
}
</script>
</body>
</html>
