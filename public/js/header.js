/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const burgerBtn = document.querySelector('.header__mobile-menu');
const nav = document.querySelector('.site-nav');
const stickyHeader = document.querySelector('.header__bottom');
const staticHeader = document.querySelector('.header__top');
//const searchBar = document.querySelector('.header__search-box');
const mainContent = document.querySelector('.main');
const mobileButtonTriggers = document.querySelectorAll('[data-trigger]');
if (mobileButtonTriggers.length) {
  mobileButtonTriggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
      const idBtn = trigger.dataset.trigger;
      const submenu = document.querySelector(`[data-submenu="${idBtn}"]`);
      const prevSubmenu = document.querySelector('[data-submenu].open');
      if (prevSubmenu && submenu !== prevSubmenu) prevSubmenu.classList.remove('open');
      if (submenu.classList.contains('open')) {
        submenu.classList.remove('open');
      } else {
        submenu.classList.add('open');
      }
    });
  });
}
if (burgerBtn) {
  burgerBtn.addEventListener('click', () => {
    burgerBtn.classList.toggle('active');
    nav.classList.toggle('active');
  });
  document.addEventListener('click', evt => {
    if (!evt.target.closest('.header')) {
      nav.classList.remove('active');
      burgerBtn.classList.remove('active');
    }
  });
}

// if (searchBar) {
//   const searchButton = searchBar.querySelector('.header__search-button');
//   const submitButton = searchBar.querySelector('.header__submit-button');
//
//   searchButton.addEventListener('click', evt => {
//     if (searchBar.classList.contains('header__search-box--active')) {
//       searchBar.classList.remove('header__search-box--active');
//       submitButton.classList.remove('active');
//       searchButton.classList.add('active');
//     } else {
//       searchBar.classList.add('header__search-box--active');
//       submitButton.classList.add('active');
//       searchButton.classList.remove('active');
//     }
//   });
//
//   document.addEventListener('click', evt => {
//     if (!evt.target.closest('.header__search-box')) {
//       searchBar.classList.remove('header__search-box--active');
//       submitButton.classList.remove('active');
//       searchButton.classList.add('active');
//     }
//   });
// }

if (stickyHeader) {
  window.addEventListener('scroll', scrollHeader);
}
function scrollHeader() {
  if (window.scrollY > staticHeader.offsetHeight && window.matchMedia('(min-width: 768px)').matches) {
    stickyHeader.classList.add('scroll');
    mainContent.classList.add('scroll');
  } else {
    mainContent.classList.remove('scroll');
    stickyHeader.classList.remove('scroll');
  }
}
/******/ })()
;