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
      var year = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute('year');
      var month = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute('month');
      var day = this.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute('day');
      if (day < 10) {
        day = '0' + day;
      }
      var time = this.innerHTML.substr(0, 8);
      fetch('api/read?year=' + year + '&month=' + month + '&day=' + day + '&time=' + time).then(function (response) {
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
    console.log(lessons[lesson]);
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
    change_button.addEventListener('click', bind.change(change_button, lessons[lesson]));
    var remove_button = document.createElement('button');
    remove_button.innerHTML = 'X';
    remove_button.classList.add('lesson_remove_button');
    menu.append(remove_button);
    remove_button.addEventListener('click', function () {
      console.log('remove!');
    });
  }
}
function change(lesson) {
  hidden_all();
  var menu_edit = document.querySelector('div.menu_edit_lesson');
  menu_edit.innerHTML = '';
  menu_edit.classList.remove('hidden');
  var divDate = document.createElement('div');
  var spanDate = document.createElement('span');
  spanDate.innerHTML = 'Дата :';
  divDate.append(spanDate);
  var inputDate = document.createElement('input');
  inputDate.value = lesson.date;
  divDate.append(inputDate);
  var divTime = document.createElement('div');
  var spanTime = document.createElement('span');
  spanTime.innerHTML = 'Время :';
  divTime.append(spanTime);
  var inputTime = document.createElement('input');
  inputTime.value = lesson.time;
  divTime.append(inputTime);
  var divPaid = document.createElement('div');
  var spanPaid = document.createElement('span');
  spanPaid.innerHTML = 'Оплата :';
  divPaid.append(spanPaid);
  //тут надо с оплатой выебнуться мне кажется
  var divStatus = document.createElement('div');
  var spanStatus = document.createElement('span');
  spanStatus.innerHTML = 'Статус :';
  divStatus.append(spanStatus);
  //тут надо со статусом выебнуться мне кажется

  menu_edit.append(divDate);
  menu_edit.append(divTime);
  menu_edit.append(divPaid);
  menu_edit.append(divStatus);
}
function hidden_all() {
  var menu_lesson = document.querySelector('.menu_lesson');
  var menu_edit_lesson = document.querySelector('.menu_edit_lesson');
  menu_lesson.classList.add('hidden');
  menu_edit_lesson.classList.add('hidden');
}
/******/ })()
;