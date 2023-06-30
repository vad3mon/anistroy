/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const tabBtns = document.querySelectorAll('[data-tab-btn]');
if (tabBtns.length > 0) {
  tabBtns.forEach(tabBtn => {
    tabBtn.addEventListener('click', () => {
      const prevButton = document.querySelector('[data-tab-btn].active');
      prevButton.classList.remove('active');
      const prevContent = document.querySelector('[data-tab].active');
      prevContent.classList.remove('active');
      const id = tabBtn.dataset.tabBtn;
      const content = document.querySelector(`[data-tab=${id}`);
      if (content) {
        content.classList.add('active');
        tabBtn.classList.add('active');
      }
      ;
    });
  });
}
/******/ })()
;