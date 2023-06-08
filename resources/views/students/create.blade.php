<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/adminPanel.css">

    <title>Создание ученика</title>
</head>
<body>
<div class="wrapper">
    <form class="create_form" method="POST" action="/create_end">
        @csrf
        <div class="create_header">Добавление нового ученика:</div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="create_block">
            <label>
                Имя:
                <input name="name" value={{ old('name') }}>
            </label>
        </div>
        <div class='create_block'>
            <label>
                Почта:
                <input name="email" value={{ old('email') }}>
            </label>
        </div>
        <div class="create_block">
            <label>
                Пароль:
                <input name="password">
            </label>
            <button class="pass_gen" type="button">
                сгенерировать
            </button>
        </div>

        <div class="create_block">
            @foreach($days_week_array as $key=>$elem)
                <div class="create_block_checkbox">
                    <label>{{ $elem }}</label>
                    <input class="checkbox_day" value="{{ $key }}" type="checkbox">
                    <div class="create_block_checkbox_time hidden" key="{{ $key }}">
                        <select name="{{$key}}">
                            <option selected value="null">выберите время</option>
                            @foreach($hours_array as $hour)
                                <option value="{{ $hour }}">{{ $hour }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </div>

        <input type="submit">
    </form>
</div>
</body>



<script>
    let checkboxs = document.querySelectorAll('input.checkbox_day');
    for(let checkbox of checkboxs){
        checkbox.addEventListener('change', function(){
            let div_time = document.querySelector("div.create_block_checkbox_time[key='" + this.getAttribute('value') + "']");
            let inputWeekDays = document.querySelector("input[name='week_days']");
            if(this.checked){
                div_time.classList.remove('hidden');
                inputWeekDays.value = this.getAttribute('value') + ' ';
            } else {
                div_time.classList.add('hidden');
                let values = inputWeekDays.value.split(' ');
                let result = [];
                for(let day of values){
                    if(day != this.getAttribute('value')){
                        result.push(day);
                    }
                }
                inputWeekDays.value = result.join(' ');
            }
        });
    }

    let buttonGenPass = document.querySelector('button.pass_gen');
    buttonGenPass.addEventListener('click', function(){
        let inputPass = document.querySelector("input[name='password']");
        inputPass.value = generatePassword();
    });
    function generatePassword(){
        var length = 8,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        res = '';
        for (var i = 0, n = charset.length; i < length; ++i) {
            res += charset.charAt(Math.floor(Math.random() * n));
        }
        return res;
    }
</script>
</html>
