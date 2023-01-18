/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// CATALOG.JS
const catalog = document.querySelector('.catalog');

if (catalog) {
  const catalogList = catalog.querySelector('.catalog__list');
  const filterCheckbox = catalog.querySelectorAll('.catalog__filter-label');
  const filterBubble = catalog.querySelector('.catalog__bubble');
  const bubbleClose = filterBubble.querySelector('.catalog__bubble-close');
  catalogList.addEventListener('mouseover', evt => {
    if (!evt.target.classList.contains('catalog__sub')) return;
    closeAllSubmenu(evt.target.nextElementSibling);
    evt.target.nextElementSibling.classList.add('submenu-active');
    evt.target.classList.add('submenu-active-span');
  });
  catalogList.addEventListener('mouseout', evt => {
    if (evt.relatedTarget.closest('ul') && evt.relatedTarget.closest('ul').previousElementSibling == evt.target) {
      evt.target.classList.add('submenu-active-span');
      evt.target.nextElementSibling.classList.add('submenu-active');
    } else {
      closeAllSubmenu(evt.target);
      evt.target.classList.remove('submenu-active-span');
    }
  });
  catalogList.addEventListener('mouseleave', closeAllSubmenu);

  function closeAllSubmenu(current = null) {
    let parents = [];

    if (current) {
      let currentParent = current.parentNode;

      while (currentParent) {
        if (currentParent.classList.contains('catalog__list')) break;
        if (currentParent.nodeName === 'UL') parents.push(currentParent);
        currentParent = currentParent.parentNode;
      }
    }

    const subMenu = document.querySelectorAll('.catalog__list ul');
    subMenu.forEach(item => {
      if (item != current && !parents.includes(item)) {
        item.classList.remove('submenu-active');

        if (item.previousElementSibling.classList.contains('catalog__sub')) {
          item.previousElementSibling.classList.remove('submenu-active-span');
        }
      }
    });
  }

  filterCheckbox.forEach(item => {
    item.addEventListener('click', () => {
      let filterBubbleHeight = filterBubble.offsetHeight / 2;
      filterBubble.style.top = window.scrollY + item.getBoundingClientRect().top - filterBubbleHeight + 'px';
      filterBubble.classList.add('active');
    });
  });
  bubbleClose.addEventListener('click', () => filterBubble.classList.remove('active'));
} // сладйер с ценами


const parent = document.querySelector(".range-slider");

if (parent) {
  let rangeS = parent.querySelectorAll("input[type=range]");
  let numberS = parent.querySelectorAll("input[type=number]");
  rangeS.forEach(el => {
    el.addEventListener('input', () => {
      let slide1 = parseFloat(rangeS[0].value);
      let slide2 = parseFloat(rangeS[1].value);

      if (slide1 > slide2) {
        [slide1, slide2] = [slide2, slide1];
      }

      numberS[0].value = slide1;
      numberS[1].value = slide2;
    });
  });
  numberS.forEach(el => {
    el.addEventListener('input', () => {
      let number1 = parseFloat(numberS[0].value);
      let number2 = parseFloat(numberS[1].value);

      if (number1 > number2) {
        let tmp = number1;
        numberS[0].value = number2;
        numberS[1].value = tmp;
      }

      rangeS[0].value = number1;
      rangeS[1].value = number2;
    });
  });
} // SPOILER.JS

/*
Для родителя спойлеров пишем атрибут data-spoilers
Для заголовков спойлеров пишем атрибут data-spoiler
Если нужно включать\выключать работу спойлеров на разных размерах экранов
пишем параметры ширины и типа брейкпоинта.
Например:
data-spoilers="992,max" - спойлеры будут работать только на экранах меньше или равно 992px
data-spoilers="768,min" - спойлеры будут работать только на экранах больше или равно 768px

Если нужно, чтобы в блоке открывался только один спойлер, добавляем атрибут data-one-spoiler
*/


"use strict"; // spoilers


const spoilersArray = document.querySelectorAll('[data-spoilers]');

if (spoilersArray.length > 0) {
  // Получение обычных спойлеров
  const spoilersRegular = Array.from(spoilersArray).filter(function (item, index, self) {
    return !item.dataset.spoilers.split(",")[0];
  }); // Инициализация обычных спойлеров

  if (spoilersRegular.length > 0) {
    initspoilers(spoilersRegular);
  } // Получение спойлеров с медиа запросами


  const spoilersMedia = Array.from(spoilersArray).filter(function (item, index, self) {
    return item.dataset.spoilers.split(",")[0];
  }); // Инициализация спойлеров с медиа запросами

  if (spoilersMedia.length > 0) {
    const breakpointsArray = [];
    spoilersMedia.forEach(item => {
      const params = item.dataset.spoilers;
      const breakpoint = {};
      const paramsArray = params.split(",");
      breakpoint.value = paramsArray[0];
      breakpoint.type = paramsArray[1] ? paramsArray[1].trim() : "max";
      breakpoint.item = item;
      breakpointsArray.push(breakpoint);
    }); // Получаем уникальные брейкпоинты

    let mediaQueries = breakpointsArray.map(function (item) {
      return '(' + item.type + "-width: " + item.value + "px)," + item.value + ',' + item.type;
    });
    mediaQueries = mediaQueries.filter(function (item, index, self) {
      return self.indexOf(item) === index;
    }); // Работаем с каждым брейкпоинтом

    mediaQueries.forEach(breakpoint => {
      const paramsArray = breakpoint.split(",");
      const mediaBreakpoint = paramsArray[1];
      const mediaType = paramsArray[2];
      const matchMedia = window.matchMedia(paramsArray[0]); // Объекты с нужными условиями

      const spoilersArray = breakpointsArray.filter(function (item) {
        if (item.value === mediaBreakpoint && item.type === mediaType) {
          return true;
        }
      }); // Событие

      matchMedia.addListener(function () {
        initspoilers(spoilersArray, matchMedia);
      });
      initspoilers(spoilersArray, matchMedia);
    });
  } // Инициализация


  function initspoilers(spoilersArray, matchMedia = false) {
    spoilersArray.forEach(spoilersBlock => {
      spoilersBlock = matchMedia ? spoilersBlock.item : spoilersBlock;

      if (matchMedia.matches || !matchMedia) {
        spoilersBlock.classList.add('init');
        initspoilerBody(spoilersBlock);
        spoilersBlock.addEventListener("click", setspoilerAction);
      } else {
        spoilersBlock.classList.remove('init');
        initspoilerBody(spoilersBlock, false);
        spoilersBlock.removeEventListener("click", setspoilerAction);
      }
    });
  } // Работа с контентом


  function initspoilerBody(spoilersBlock, hidespoilerBody = true) {
    const spoilerTitles = spoilersBlock.querySelectorAll('[data-spoiler]');

    if (spoilerTitles.length > 0) {
      spoilerTitles.forEach(spoilerTitle => {
        if (hidespoilerBody) {
          spoilerTitle.removeAttribute('tabindex');

          if (!spoilerTitle.classList.contains('active')) {
            spoilerTitle.nextElementSibling.hidden = true;
          }
        } else {
          spoilerTitle.setAttribute('tabindex', '-1');
          spoilerTitle.nextElementSibling.hidden = false;
        }
      });
    }
  }

  function setspoilerAction(e) {
    const el = e.target;

    if (el.hasAttribute('data-spoiler') || el.closest('[data-spoiler]')) {
      const spoilerTitle = el.hasAttribute('data-spoiler') ? el : el.closest('[data-spoiler]');
      const spoilersBlock = spoilerTitle.closest('[data-spoilers]');
      const onespoiler = spoilersBlock.hasAttribute('data-one-spoiler') ? true : false;

      if (!spoilersBlock.querySelectorAll('.slide').length) {
        if (onespoiler && !spoilerTitle.classList.contains('active')) {
          hidespoilersBody(spoilersBlock);
        }

        spoilerTitle.classList.toggle('active');

        _slideToggle(spoilerTitle.nextElementSibling, 300);
      }

      e.preventDefault();
    }
  }

  function hidespoilersBody(spoilersBlock) {
    const spoilerActiveTitle = spoilersBlock.querySelector('[data-spoiler].active');

    if (spoilerActiveTitle) {
      spoilerActiveTitle.classList.remove('active');

      _slideUp(spoilerActiveTitle.nextElementSibling, 300);
    }
  }
} //========================================================================================================================================================
//SlideToggle


let _slideUp = (target, duration = 300) => {
  if (!target.classList.contains('slide')) {
    target.classList.add('slide');
    target.style.transitionProperty = 'height, margin, padding';
    target.style.transitionDuration = duration + 'ms';
    target.style.height = target.offsetHeight + 'px';
    target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    window.setTimeout(() => {
      target.hidden = true;
      target.style.removeProperty('height');
      target.style.removeProperty('padding-top');
      target.style.removeProperty('padding-bottom');
      target.style.removeProperty('margin-top');
      target.style.removeProperty('margin-bottom');
      target.style.removeProperty('overflow');
      target.style.removeProperty('transition-duration');
      target.style.removeProperty('transition-property');
      target.classList.remove('slide');
    }, duration);
  }
};

let _slideDown = (target, duration = 300) => {
  if (!target.classList.contains('slide')) {
    target.classList.add('slide');

    if (target.hidden) {
      target.hidden = false;
    }

    let height = target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + 'ms';
    target.style.height = height + 'px';
    target.style.removeProperty('padding-top');
    target.style.removeProperty('padding-bottom');
    target.style.removeProperty('margin-top');
    target.style.removeProperty('margin-bottom');
    window.setTimeout(() => {
      target.style.removeProperty('height');
      target.style.removeProperty('overflow');
      target.style.removeProperty('transition-duration');
      target.style.removeProperty('transition-property');
      target.classList.remove('slide');
    }, duration);
  }
};

let _slideToggle = (target, duration = 300) => {
  if (target.hidden) {
    return _slideDown(target, duration);
  } else {
    return _slideUp(target, duration);
  }
};
/******/ })()
;