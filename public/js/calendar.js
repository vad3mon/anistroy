/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const elem = document.querySelector('.calendar');
const datepicker = new DateRangePicker(elem, {
  autohide: true,
  weekStart: 1,
  daysOfWeekHighlighted: [0, 6],
  format: 'dd.mm.yyyy',
  orientation: 'right'
});
/******/ })()
;