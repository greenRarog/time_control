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
        <input hidden class="inputYear"><br>
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
    //console.log(this.param);
    /*fetch('api/year=' + year '&month=' + month + '&day=' + this.innerHTML).then(
        response => {
            return response.json();
        }
    ).then(
        data => {
            console.log(data);
        }
    )*/
}
</script>
</body>
</html>
