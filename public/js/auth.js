/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const iconEyes = document.querySelectorAll('input[type="password"] + .form__eye-btn');
if (iconEyes.length > 0) {
  iconEyes.forEach(item => {
    item.addEventListener('click', () => {
      const input = item.previousElementSibling;
      if (input.getAttribute('type') == 'password') {
        item.classList.add('show');
        input.setAttribute('type', 'text');
      } else {
        item.classList.remove('show');
        input.setAttribute('type', 'password');
      }
    });
  });
}
/******/ })()
;