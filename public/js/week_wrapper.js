/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/week_wrapper.js ***!
  \**************************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
var tds = document.querySelectorAll('td');
var _iterator = _createForOfIteratorHelper(tds),
  _step;
try {
  for (_iterator.s(); !(_step = _iterator.n()).done;) {
    var td = _step.value;
    td.addEventListener('click', function () {
      var olds = document.querySelectorAll('.active');
      var _iterator2 = _createForOfIteratorHelper(olds),
        _step2;
      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var old = _step2.value;
          old.classList.remove('active');
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }
      this.classList.add('active');
      var year = this.getAttribute('year');
      var month = this.getAttribute('month');
      var day = this.getAttribute('day');
      var student_id = this.getAttribute('student_id');
      if (day < 10) {
        day = '0' + day;
      }
      var time = this.innerHTML.substr(0, 8);
      fetch('api/read?student_id=' + student_id + '&year=' + year + '&month=' + month + '&day=' + day + '&time=' + time).then(function (response) {
        return response.json();
      }).then(function (data) {
        menu_lesson(data.array);
      });
    });
  }
} catch (err) {
  _iterator.e(err);
} finally {
  _iterator.f();
}
function menu_lesson(lessons) {
  hidden_all();
  var menu = document.querySelector('div.menu_lesson');
  menu.innerHTML = '';
  menu.classList.remove('hidden');
  var header = document.createElement('h4');
  header.innerHTML = 'меню урока';
  menu.append(header);
  menu.classList.remove('hidden');
  for (var lesson in lessons) {
    var nameSpan = document.createElement('span');
    nameSpan.innerHTML = 'ученик: ' + lessons[lesson].name + '<br>';
    menu.append(nameSpan);
    var dateSpan = document.createElement('span');
    dateSpan.innerHTML = 'дата: ' + lessons[lesson].date + '<br>время: ' + lessons[lesson].time + '<br>';
    menu.append(dateSpan);
    var paidSpan = document.createElement('span');
    if (lessons[lesson].paid) {
      paidSpan.innerHTML = 'урок оплачен <br>';
    } else {
      paidSpan.innerHTML = 'урок еще оплачен<br>';
    }
    menu.append(paidSpan);
    var change_button = document.createElement('button');
    change_button.innerHTML = 'изменить';
    change_button.classList.add('lesson_change_button');
    menu.append(change_button);
    change_button.addEventListener('click', create_change_menu(lessons[lesson]));
    var remove_button = document.createElement('button');
    remove_button.innerHTML = 'удалить урок';
    remove_button.classList.add('lesson_remove_button');
    remove_button.addEventListener('click', menu_remove_lesson(lessons[lesson]));
    menu.append(remove_button);
  }
}
function menu_remove_lesson(lesson) {
  return function () {
    hidden_all();
    var menu_remove_lesson = document.querySelector('div.menu_remove_lesson');
    menu_remove_lesson.classList.remove('hidden');
    menu_remove_lesson.innerHTML = 'если хотите удалить урок напишите слово УДАЛИТЬ<br>';
    var inputConfirm = document.createElement('input');
    inputConfirm.classList.add('input_confirm_delete');
    menu_remove_lesson.append(inputConfirm);
    menu_remove_lesson.innerHTML += '<br>';
    var buttonConfirmRemove = document.createElement('button');
    buttonConfirmRemove.innerHTML = 'удалить';
    buttonConfirmRemove.addEventListener('click', remove_lesson(lesson.lesson_id));
    menu_remove_lesson.append(buttonConfirmRemove);
    var buttonCloseMenuRemove = document.createElement('button');
    buttonCloseMenuRemove.innerHTML = 'закрыть';
    buttonCloseMenuRemove.addEventListener('click', hidden_all);
    menu_remove_lesson.append(buttonCloseMenuRemove);
  };
}
function remove_lesson(id) {
  return function () {
    var value = document.querySelector('input.input_confirm_delete').value;
    if (value == 'УДАЛИТЬ') {
      fetch('/api/delete/' + id).then(function (response) {
        return response.text();
      }).then(function (text) {
        console.log(text);
      });
    } else {
      alert('удаление НЕ подтверждено! или подтвердите или закройте!');
    }
  };
}
function create_change_menu(lesson) {
  return function () {
    hidden_all();
    var menu_edit = document.querySelector('div.menu_edit_lesson');
    menu_edit.classList.remove('hidden');
    var edit_form = document.querySelector('form.edit_form');
    edit_form.innerHTML = '';
    var divDate = document.createElement('div');
    var spanDate = document.createElement('span');
    spanDate.innerHTML = 'Дата :';
    divDate.append(spanDate);
    var inputDate = document.createElement('input');
    inputDate.value = lesson.date;
    inputDate.setAttribute('name', 'date');
    divDate.append(inputDate);
    var divTime = document.createElement('div');
    var spanTime = document.createElement('span');
    spanTime.innerHTML = 'Время :';
    divTime.append(spanTime);
    var inputTime = document.createElement('input');
    inputTime.value = lesson.time;
    inputTime.setAttribute('name', 'time');
    divTime.append(inputTime);
    var divPaid = document.createElement('div');
    divPaid.classList.add('div_paid');
    var spanPaid = document.createElement('span');
    spanPaid.innerHTML = 'Оплата :';
    divPaid.append(spanPaid);
    var selectPaid = document.createElement('select');
    selectPaid.setAttribute('name', 'paid');
    var optionPaid = document.createElement('option');
    optionPaid.innerHTML = 'оплачен';
    optionPaid.setAttribute('value', true);
    selectPaid.append(optionPaid);
    var optionNotPaid = document.createElement('option');
    optionNotPaid.innerHTML = 'не оплачен';
    optionNotPaid.setAttribute('value', false);
    selectPaid.append(optionNotPaid);
    if (lesson.paid) {
      optionPaid.setAttribute('selected', true);
    } else {
      optionNotPaid.setAttribute('selected', false);
    }
    divPaid.append(selectPaid);
    var divStatus = document.createElement('div');
    var spanStatus = document.createElement('span');
    spanStatus.innerHTML = 'Статус :';
    divStatus.append(spanStatus);
    var selectStatus = document.createElement('select');
    selectStatus.setAttribute('name', 'status');
    var optionDone = document.createElement('option');
    optionDone.innerHTML = 'урок проведен';
    optionDone.setAttribute('value', 'done');
    selectStatus.append(optionDone);
    var optionNotDone = document.createElement('option');
    optionNotDone.innerHTML = 'урок не проведен';
    optionNotDone.setAttribute('value', 'notdone');
    selectStatus.append(optionNotDone);
    var optionClose = document.createElement('option');
    optionClose.innerHTML = 'урок отменен';
    optionClose.setAttribute('value', 'close');
    selectStatus.append(optionClose);
    if (lesson.status == 'done') {
      optionDone.setAttribute('selected', 'true');
    } else if (lesson.status == 'notdone') {
      optionNotDone.setAttribute('selected', 'true');
    } else {
      optionClose.setAttribute('selected', 'true');
    }
    divStatus.append(selectStatus);
    var buttonUpdate = document.createElement('input');
    buttonUpdate.classList.add('update_button');
    buttonUpdate.value = 'изменить';
    buttonUpdate.setAttribute('type', 'submit');
    edit_form.addEventListener('submit', change_lesson);
    var buttonClose = document.createElement('button');
    buttonClose.innerHTML = 'закрыть';
    buttonClose.setAttribute('type', 'button');
    buttonClose.addEventListener('click', hidden_all);
    var inputId = document.createElement('input');
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
  };
}
function change_lesson(event) {
  fetch('/student/api/update', {
    method: 'POST',
    body: new FormData(this),
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  }).then(function (response) {
    return response.text();
  }).then(function (text) {
    alert(text);
  });
  hidden_all();
  event.preventDefault();
}
function hidden_all() {
  var menu_lesson = document.querySelector('div.menu_lesson');
  var menu_edit_lesson = document.querySelector('div.menu_edit_lesson');
  var menu_remove_lesson = document.querySelector('div.menu_remove_lesson');
  menu_lesson.classList.add('hidden');
  menu_edit_lesson.classList.add('hidden');
  menu_remove_lesson.classList.add('hidden');
}
/******/ })()
;