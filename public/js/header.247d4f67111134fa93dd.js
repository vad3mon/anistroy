/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/* <меню-бургер> */
const burgerBtn = document.querySelector('.header__mobile-menu');
const nav = document.querySelector('.header__nav-wrapper');

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
/* </меню-бургер> */


const searchBar = document.querySelector('.header__search-box');

if (searchBar) {
  const searchButton = searchBar.querySelector('.header__search-button');
  const searchInput = searchBar.querySelector('.header__search-input');
  searchButton.addEventListener('click', evt => {
    evt.preventDefault();
    searchBar.classList.toggle('header__search-box--active');

    if (searchBar.classList.contains('header__search-box--active')) {
      searchButton.setAttribute('type', 'submit');
      searchInput.focus();
    } else {
      searchButton.setAttribute('type', 'button');
    }
  });
  document.addEventListener('click', evt => {
    if (!evt.target.closest('.header__search-box')) {
      searchBar.classList.remove('header__search-box--active');
    }
  });
}
/******/ })()
;