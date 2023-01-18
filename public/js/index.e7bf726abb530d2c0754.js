/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 469:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__webpack_require__.p + "assets/images/icon-cart.svg");

/***/ }),

/***/ 803:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__webpack_require__.p + "assets/images/icon-fav.svg");

/***/ }),

/***/ 46:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__webpack_require__.p + "assets/images/icon-login.svg");

/***/ }),

/***/ 261:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__webpack_require__.p + "assets/images/icon-phone.svg");

/***/ }),

/***/ 280:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__webpack_require__.p + "assets/images/logo.svg");

/***/ }),

/***/ 248:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// Imports
var ___HTML_LOADER_GET_SOURCE_FROM_IMPORT___ = __webpack_require__(370);
var ___HTML_LOADER_IMPORT_0___ = __webpack_require__(280);
var ___HTML_LOADER_IMPORT_1___ = __webpack_require__(261);
var ___HTML_LOADER_IMPORT_2___ = __webpack_require__(803);
var ___HTML_LOADER_IMPORT_3___ = __webpack_require__(469);
var ___HTML_LOADER_IMPORT_4___ = __webpack_require__(46);
// Module
var ___HTML_LOADER_REPLACEMENT_0___ = ___HTML_LOADER_GET_SOURCE_FROM_IMPORT___(___HTML_LOADER_IMPORT_0___);
var ___HTML_LOADER_REPLACEMENT_1___ = ___HTML_LOADER_GET_SOURCE_FROM_IMPORT___(___HTML_LOADER_IMPORT_1___);
var ___HTML_LOADER_REPLACEMENT_2___ = ___HTML_LOADER_GET_SOURCE_FROM_IMPORT___(___HTML_LOADER_IMPORT_2___);
var ___HTML_LOADER_REPLACEMENT_3___ = ___HTML_LOADER_GET_SOURCE_FROM_IMPORT___(___HTML_LOADER_IMPORT_3___);
var ___HTML_LOADER_REPLACEMENT_4___ = ___HTML_LOADER_GET_SOURCE_FROM_IMPORT___(___HTML_LOADER_IMPORT_4___);
var code = "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n  <head>\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n    <title>Document</title>\n    <meta name=\"description\" content=\"\" />\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, user-scalable=0\" />\n  </head>\n\n  <body>\n    <div class=\"site-wrapper\">\n      <header class=\"header\">\n        <div class=\"header__container container\">\n          <a class=\"header__logo\" href=\"index.html\">\n            <img src=\"" + ___HTML_LOADER_REPLACEMENT_0___ + "\" alt=\"\">\n          </a>\n\n          <div class=\"header__nav-wrapper\">\n            <nav class=\"site-nav\">\n              <a class=\"site-nav__link\" href=\"about.html\">О магазине</a>\n              <a class=\"site-nav__link\" href=\"#\">Доставка и оплата</a>\n              <a class=\"site-nav__link\" href=\"#\">Контакты</a>\n            </nav>\n\n            <a class=\"header__phone-box\" href=\"tel:+79221232234\">\n              <img class=\"header__phone-icon\" src=\"" + ___HTML_LOADER_REPLACEMENT_1___ + "\" alt=\"\">\n              <span class=\"header__phone-text\">\n                +7 922 123-22-34\n              </span>\n            </a>\n\n            <form class=\"header__search-box\">\n              <input class=\"header__search-input\" type=\"text\" placeholder=\"Поиск по названию\">\n              <button class=\"header__search-button\">Поиск</button>\n            </form>\n\n            <div class=\"user-nav\">\n              <a class=\"user-nav__link user-nav__link--fav\" href=\"fav.html\">\n                <img class=\"user-nav__icon\" src=\"" + ___HTML_LOADER_REPLACEMENT_2___ + "\" alt=\"\">\n                <span class=\"user-nav__counter user-nav__counter--fav\">0</span>\n                Избранное\n              </a>\n              <a class=\"user-nav__link user-nav__link--cart\" href=\"cart.html\">\n                <img class=\"user-nav__icon\" src=\"" + ___HTML_LOADER_REPLACEMENT_3___ + "\" alt=\"\">\n                <span class=\"user-nav__counter user-nav__counter--cart\">0</span>\n                Корзина\n              </a>\n              <!-- если залогинен -->\n              <!-- <a class=\"user-nav__link user-nav__link--profile\" href=\"profile.html\">\n                <img class=\"user-nav__icon user-nav__icon--profile\" src=\"./assets/images/icon-profile.svg\" alt=\"\">\n                Профиль\n              </a> -->\n              <!-- --- -->\n\n              <!-- если не залогинен -->\n              <a class=\"user-nav__link user-nav__link--login\" href=\"login.html\">\n                <img class=\"user-nav__icon user-nav__icon--login\" src=\"" + ___HTML_LOADER_REPLACEMENT_4___ + "\" alt=\"\">\n                Войти\n              </a>\n              <!-- --- -->\n            </div>\n          </div>\n\n          <button class=\"header__mobile-menu\">\n            <span></span>\n          </button>\n        </div>\n      </header>\n      <main class=\"main\">\n        <div class=\"main__container container\">\n          <aside class=\"aside-menu\" data-spoilers=\"992,max\">\n            <h2 class=\"aside-menu__title\" data-spoiler><span>Личный кабинет</span></h2>\n            <ul class=\"aside-menu__list\">\n              <li><a class=\"aside-menu__link\" href=\"my-orders.html\">Мои заказы</a></li>\n              <li><a class=\"aside-menu__link\" href=\"bonus.html\">Бонусная программа</a></li>\n              <li><a class=\"aside-menu__link active\" href=\"address.html\">Адреса доставки</a></li>\n              <li><a class=\"aside-menu__link\" href=\"profile-info.html\">Мои данные</a></li>\n              <li><a class=\"aside-menu__link\" href=\"change-pass.html\">Смена пароля</a></li>\n            </ul>\n          </aside>\n          \n          <div class=\"content\">\n            <section class=\"profile\">\n              <h2 class=\"profile__title\">\n                Адреса доставки\n                <button class=\"profile__add-btn\" data-open=\"add-address\"></button>\n              </h2>\n\n              <section class=\"address\">\n                <table class=\"address__table\">\n                  <tr class=\"address__item\">\n                    <td class=\"address__cell\">Москва, ул. Крылатская, 28-1-45</td>\n                    <td class=\"address__cell address__cell--right\">\n                      <button class=\"address__edit-btn\" data-open=\"edit-address\"></button>\n                      <button class=\"address__delete-btn\" data-open=\"delete-address\"></button>\n                    </td>\n                  </tr>\n\n                  <tr class=\"address__item\">\n                    <td class=\"address__cell\">Москва, Красная площадь 1, кв. 15</td>\n                    <td class=\"address__cell address__cell--right\">\n                      <button class=\"address__edit-btn\" data-open=\"edit-address\"></button>\n                      <button class=\"address__delete-btn\" data-open=\"delete-address\"></button>\n                    </td>\n                  </tr> \n\n                  <tr class=\"address__item\">\n                    <td class=\"address__cell\">Москва, Котельники, ул. Сложеницина, д.25, кв. 15</td>\n                    <td class=\"address__cell address__cell--right\">\n                      <button class=\"address__edit-btn\" data-open=\"edit-address\"></button>\n                      <button class=\"address__delete-btn\" data-open=\"delete-address\"></button>\n                    </td>\n                  </tr>\n                </table>\n              </section>\n            </section>\n          </div>\n        </div>\n      </main>\n      <footer class=\"footer\">\n        <div class=\"footer__container container\">\n          <div class=\"footer__col\" data-spoilers=\"800\">\n            <h4 class=\"footer__title\" data-spoiler>Организация</h4>\n            <div class=\"footer__list\">\n              <a class=\"footer__link\" href=\"#\">О компании</a>\n              <a class=\"footer__link\" href=\"#\">Услуги</a>\n              <a class=\"footer__link\" href=\"#\">Новости</a>\n              <a class=\"footer__link\" href=\"#\">Статьи</a>\n            </div>\n          </div>\n\n          <div class=\"footer__col\" data-spoilers=\"800\">\n            <h4 class=\"footer__title\" data-spoiler>Как купить</h4>\n            <div class=\"footer__list\">\n              <a class=\"footer__link\" href=\"#\">Оплата</a>\n              <a class=\"footer__link\" href=\"#\">Доставка</a>\n              <a class=\"footer__link\" href=\"#\">Оптовый заказ</a>\n              <a class=\"footer__link\" href=\"#\">Контакты</a>\n            </div>\n          </div>\n\n          <div class=\"footer__col\" data-spoilers=\"800\">\n            <h4 class=\"footer__title\" data-spoiler>Наш адрес</h4>\n            <div class=\"footer__list\">\n              <a class=\"footer__link\" href=\"#\">О компании</a>\n              <a class=\"footer__link\" href=\"#\">Услуги</a>\n              <a class=\"footer__link\" href=\"#\">Новости</a>\n              <a class=\"footer__link\" href=\"#\">Статьи</a>\n            </div>\n          </div>\n\n          <div class=\"footer__col\">\n            <h4 class=\"footer__title\">Мы на связи</h4>\n            <div class=\"footer__list\">\n              <a class=\"footer__link\" href=\"#\">О компании</a>\n              <a class=\"footer__link\" href=\"#\">Услуги</a>\n              <a class=\"footer__link\" href=\"#\">Новости</a>\n              <a class=\"footer__link\" href=\"#\">Статьи</a>\n            </div>\n          </div>\n        </div>\n      </footer>\n    </div>\n\n    <section class=\"modal\" data-popup=\"add-address\">\n      <div class=\"modal__backdrop\" data-close></div>\n      <div class=\"modal__body\">\n        <button class=\"modal__close\" data-close></button>\n        <h3 class=\"modal__title\">Добавить адрес</h3>\n        <input class=\"modal__input\" type=\"text\">\n        <button class=\"modal__save-btn\">Сохранить</button>\n      </div>\n    </section>\n\n    <section class=\"modal\" data-popup=\"edit-address\">\n      <div class=\"modal__backdrop\" data-close></div>\n      <div class=\"modal__body\">\n        <button class=\"modal__close\" data-close></button>\n        <h3 class=\"modal__title\">Редактировать адрес</h3>\n        <input class=\"modal__input\" type=\"text\" value=\"Москва, ул. Крылатская, 28-1-45\">\n        <button class=\"modal__save-btn\">Сохранить</button>\n      </div>\n    </section>\n\n    <section class=\"modal\" data-popup=\"delete-address\">\n      <div class=\"modal__backdrop\" data-close></div>\n      <div class=\"modal__body\">\n        <button class=\"modal__close\" data-close></button>\n        <h3 class=\"modal__title\">Удалить адрес?</h3>\n        <input class=\"modal__input\" type=\"text\" readonly value=\"Москва, ул. Крылатская, 28-1-45\">\n        <button class=\"modal__save-btn\">Удалить</button>\n      </div>\n    </section>\n  </body>\n</html>";
// Exports
module.exports = code;

/***/ }),

/***/ 370:
/***/ ((module) => {

"use strict";


module.exports = function (url, options) {
  if (!options) {
    // eslint-disable-next-line no-param-reassign
    options = {};
  } // eslint-disable-next-line no-underscore-dangle, no-param-reassign


  url = url && url.__esModule ? url.default : url;

  if (typeof url !== 'string') {
    return url;
  }

  if (options.hash) {
    // eslint-disable-next-line no-param-reassign
    url += options.hash;
  }

  if (options.maybeNeedQuotes && /[\t\n\f\r "'=<>`]/.test(url)) {
    return "\"".concat(url, "\"");
  }

  return url;
};

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/publicPath */
/******/ 	(() => {
/******/ 		__webpack_require__.p = "";
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/* harmony import */ var _address_html__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(248);
/* harmony import */ var _address_html__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_address_html__WEBPACK_IMPORTED_MODULE_0__);

 // импорт изображений, не используемых в html и css напрямую (если buy.js не подключен, то функция не нужна)
// function importAll(r) {
//   r.keys().forEach(r); 
// }
// importAll(require.context('@/assets/images', true, /\.(?:png|jpg|jpeg|svg)$/));
})();

/******/ })()
;