/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const showButtons = document.querySelectorAll('[data-open]');
const body = document.querySelector('body');
const fixedElements = document.querySelectorAll('[data-fixed]'); // открытие / закрытие попапов

if (showButtons.length > 0) {
  showButtons.forEach(btn => {
    btn.addEventListener('click', evt => {
      evt.preventDefault();
      const idBtn = btn.dataset.open;
      const popup = document.querySelector(`[data-popup="${idBtn}"]`);
      popup.classList.add('open');
      bodyLock();
    });
    const closeBtns = document.querySelectorAll(`[data-close]`);

    if (closeBtns.length > 0) {
      closeBtns.forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
          closeBtn.closest('[data-popup]').classList.remove('open');
          bodyUnlock();
        });
      });
    }
  });
} // плавное скрытие скролла у body {overflow-y: hidden} при появлении модалок


function bodyLock() {
  const scrollWidth = window.innerWidth - body.offsetWidth + 'px';

  for (let i = 0; i < fixedElements.length; i++) {
    const element = fixedElements[i];
    element.style.paddingRight = scrollWidth;
  }

  body.classList.add('lock');
}

function bodyUnlock() {
  for (let i = 0; i < fixedElements.length; i++) {
    const element = fixedElements[i];
    element.style.paddingRight = 0;
  }

  body.classList.remove('lock');
}
/******/ })()
;