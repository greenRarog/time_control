/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/handmade_script.js ***!
  \*****************************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
var tds = document.querySelectorAll('td');
var inputDay = document.querySelector('.inputDay');
var _iterator = _createForOfIteratorHelper(tds),
  _step;
try {
  for (_iterator.s(); !(_step = _iterator.n()).done;) {
    var td = _step.value;
    td.addEventListener('click', getInfo);
  }
} catch (err) {
  _iterator.e(err);
} finally {
  _iterator.f();
}
function getInfo() {
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
  var table = this.parentNode.parentNode.parentNode;
  var year = table.getAttribute('tableyear');
  var month = table.getAttribute('tablemonth');
  var day = this.innerHTML;
  if (day < 10) {
    day = '0' + day;
  }
  var date = year + '-' + month + '-' + day;
  fetch('api/read/' + year + '/' + month + '/' + day).then(function (response) {
    return response.json();
  }).then(function (data) {
    create_menu(data.array, date);
  });
}
function hiddenAll() {
  var menu = document.querySelector('div.menu');
  menu.classList.add('hidden');
  var edit_menu = document.querySelector('div.edit_menu');
  edit_menu.classList.add('hidden');
  var create_menu = document.querySelector('div.create_menu');
  create_menu.classList.add('hidden');
}
function create_menu(lessons, date) {
  var menu_div = document.querySelector('div.menu');
  hiddenAll();
  menu_div.classList.remove('hidden');
  menu_div.innerHTML = '';
  var header_menu = document.createElement('h3');
  header_menu.innerHTML = 'меню дня';
  menu_div.append(header_menu);
  var create_button = document.createElement('button');
  create_button.classList.add('menu_button');
  create_button.innerHTML = 'добавить урок';
  create_button.addEventListener('click', create_menu_create.bind(create_button, date));
  menu_div.append(create_button);
  create_edit_button(lessons);
  var close_button = document.createElement('button');
  close_button.innerHTML = 'закрыть меню';
  close_button.classList.add('menu_button');
  menu_div.append(close_button);
  close_button.addEventListener('click', hiddenAll);
}
function create_edit_button(lessons) {
  var menu_div = document.querySelector('div.menu');
  for (var lesson in lessons) {
    var edit_button = document.createElement('button');
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
function create_edit_menu() {
  hiddenAll();
  var edit_menu = document.querySelector('div.edit_menu');
  edit_menu.classList.remove('hidden');
  var input_id = document.querySelector("input.edit_menu_input[name='id']");
  input_id.value = this.getAttribute('id');
  var input_student_id = document.querySelector("input.edit_menu_input[name='student_id']");
  input_student_id.value = this.getAttribute('student_id');
  var input_date = document.querySelector("input.edit_menu_input[name='date']");
  input_date.value = this.getAttribute('date');
  var input_time = document.querySelector("input.edit_menu_input[name='time']");
  input_time.value = this.getAttribute('time');
  var input_paid = document.querySelector("input.edit_menu_input[name='paid']");
  input_paid.value = this.getAttribute('paid');
  var input_status = document.querySelector("input.edit_menu_input[name='status']");
  input_status.value = this.getAttribute('status');
  var input_cost = document.querySelector("input.edit_menu_input[name='cost']");
  input_cost.value = this.getAttribute('cost');
  var form_update = document.querySelector('form.edit_menu');
  form_update.addEventListener('submit', update);
  var close_button = document.querySelector('button.close_edit_button');
  close_button.addEventListener('click', hiddenAll);
}
function create_menu_create(date) {
  hiddenAll();
  var menu_create = document.querySelector('div.create_menu');
  menu_create.classList.remove('hidden');
  var inputDate = document.querySelector("input.create_menu_input[name='date']");
  inputDate.value = date;
  var close_button = document.querySelector('button.close_create_button');
  close_button.addEventListener('click', hiddenAll);
}
function update(event) {
  var TestForm = new FormData(this);
  fetch('/student/api/update', {
    method: 'POST',
    body: TestForm,
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  }).then(function (response) {
    return response.text();
  }).then(function (text) {
    alert(text);
  });
  //event.preventDefault();
}
/******/ })()
;