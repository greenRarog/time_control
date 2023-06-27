<x-app-layout>
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
<script src="{{ asset('js/week_wrapper.js') }}"></script>
</x-app-layout>
