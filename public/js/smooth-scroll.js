/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const smoothLinks = document.querySelectorAll('.anchor__item');
if (smoothLinks.length > 0) {
  for (let smoothLink of smoothLinks) {
    smoothLink.addEventListener('click', evt => {
      const activeLink = document.querySelector('.anchor__item--active');
      activeLink.classList.remove('anchor__item--active');
      evt.target.classList.add('anchor__item--active');
      evt.preventDefault();
      const id = smoothLink.getAttribute('href');
      document.querySelector(id).scrollIntoView({
        behavior: 'smooth',
        block: 'nearest'
      });
    });
  }
  ;
}
/******/ })()
;