/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const cookie = document.querySelector('.cookie');

if (cookie) {
  if (!localStorage.getItem('cookieSubmit')) {
    cookie.classList.add('open');
    const cookieSubmit = cookie.querySelector('.cookie__save-btn');
    cookieSubmit.addEventListener('click', () => {
      localStorage.setItem('cookieSubmit', true);
      cookie.classList.remove('open');
    });
  } else {
    cookie.classList.remove('open');
  }
}
/******/ })()
;