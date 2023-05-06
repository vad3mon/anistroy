/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};

;// CONCATENATED MODULE: ./js/add-to-cart.js
const cards = document.querySelectorAll('.card');
const cartCounter = document.querySelector('.user-nav__counter--cart');
if (cards.length > 0) {
  cards.forEach(card => {
    const minusBtn = card.querySelector('.card__minus-btn');
    const inputCounter = card.querySelector('.card__input');
    const plusBtn = card.querySelector('.card__plus-btn');
    const favBtn = card.querySelector('.card__fav-btn');
    const cartBtn = card.querySelector('.card__cart-btn');
    const cardInStock = card.dataset.stock;
    let newValue;
    plusBtn.addEventListener('click', () => {
      minusBtn.disabled = false;
      let currentValue = +inputCounter.value;
      if (currentValue + 1 >= cardInStock) {
        newValue = cardInStock;
        plusBtn.disabled = true;
      } else {
        newValue = currentValue + 1;
      }
      inputCounter.value = newValue;
    });
    minusBtn.addEventListener('click', () => {
      plusBtn.disabled = false;
      let currentValue = +inputCounter.value;
      if (currentValue - 1 <= 1) {
        newValue = 1;
        minusBtn.disabled = true;
      } else {
        newValue = currentValue - 1;
      }
      inputCounter.value = newValue;
    });
    inputCounter.addEventListener('input', () => {
      minusBtn.disabled = false;
      plusBtn.disabled = false;
      if (+inputCounter.value >= cardInStock) {
        newValue = cardInStock;
        plusBtn.disabled = true;
      } else if (+inputCounter.value - 1 <= 1) {
        newValue = 1;
        minusBtn.disabled = true;
      } else {
        newValue = inputCounter.value;
      }
      inputCounter.value = newValue;
    });
    cartBtn.addEventListener('click', () => {
      if (!cartBtn.classList.contains('active')) {
        // анимация добавления в корзину
        animateProductImage(card);
        cartBtn.classList.add('active');
        cartBtn.textContent = 'В корзине';
      } else {
        cartBtn.classList.remove('active');
        cartBtn.textContent = 'В корзину';
      }
    });
    favBtn.addEventListener('click', () => {
      if (!favBtn.classList.contains('active')) {
        favBtn.classList.add('active');
        favBtn.setAttribute('title', 'Удалить из избранного');
      } else {
        favBtn.classList.remove('active');
        favBtn.setAttribute('title', 'Добавить в избранное');
      }
    });
  });
}
function animateProductImage(element) {
  const cardImage = element.querySelector('img');
  const cardImageFly = cardImage.cloneNode(true);
  const cardImageFlyWidth = cardImage.offsetWidth;
  const cardImageFlyHeight = cardImage.offsetHeight;
  const cardImageFlyTop = cardImage.getBoundingClientRect().top;
  const cardImageFlyLeft = cardImage.getBoundingClientRect().left;
  cardImageFly.classList.add('image-fly');
  cardImageFly.style.cssText = `
    left: ${cardImageFlyLeft}px;
    top: ${cardImageFlyTop}px;
    width: ${cardImageFlyWidth}px;
    height: ${cardImageFlyHeight}px
  `;
  document.body.append(cardImageFly);
  const cartFlyTop = cartCounter.getBoundingClientRect().top;
  const cartFlyLeft = cartCounter.getBoundingClientRect().left;
  cardImageFly.style.cssText = `
    left: ${cartFlyLeft}px;
    top: ${cartFlyTop}px;
    width: 0px;
    height: 0px;
    opacity: 0;
  `;
  cardImageFly.addEventListener('transitionend', () => {
    cardImageFly.remove();
  });
}
;// CONCATENATED MODULE: ./js/product-item.js

const card = document.querySelector('.product');
const product_item_cartCounter = document.querySelector('.user-nav__counter--cart');
if (card) {
  const minusBtn = card.querySelector('.product__minus-btn');
  const inputCounter = card.querySelector('.product__input');
  const plusBtn = card.querySelector('.product__plus-btn');
  const favBtn = card.querySelector('.product__fav-btn');
  const cartBtn = card.querySelector('.product__cart-btn');
  const productInStock = card.dataset.stock;
  let newValue;
  plusBtn.addEventListener('click', evt => {
    minusBtn.disabled = false;
    let currentValue = +inputCounter.value;
    if (currentValue + 1 >= productInStock) {
      newValue = productInStock;
      plusBtn.disabled = true;
    } else {
      newValue = currentValue + 1;
    }
    inputCounter.value = newValue;
  });
  minusBtn.addEventListener('click', evt => {
    plusBtn.disabled = false;
    let currentValue = +inputCounter.value;
    if (currentValue - 1 <= 1) {
      newValue = 1;
      minusBtn.disabled = true;
    } else {
      newValue = currentValue - 1;
    }
    inputCounter.value = newValue;
  });
  inputCounter.addEventListener('input', () => {
    minusBtn.disabled = false;
    plusBtn.disabled = false;
    if (+inputCounter.value >= productInStock) {
      newValue = productInStock;
      plusBtn.disabled = true;
    } else if (+inputCounter.value - 1 <= 1) {
      newValue = 1;
      minusBtn.disabled = true;
    } else {
      newValue = inputCounter.value;
    }
    inputCounter.value = newValue;
  });
  cartBtn.addEventListener('click', evt => {
    if (!cartBtn.classList.contains('active')) {
      // анимация добавления в корзину
      animateProductImage(card);
      cartBtn.classList.add('active');
      cartBtn.textContent = 'В корзине';
    } else {
      cartBtn.classList.remove('active');
      cartBtn.textContent = 'В корзину';
    }
  });
  favBtn.addEventListener('click', evt => {
    if (!favBtn.classList.contains('active')) {
      favBtn.classList.add('active');
      favBtn.setAttribute('title', 'Удалить из избранного');
      favBtn.textContent = 'В избранном';
    } else {
      favBtn.classList.remove('active');
      favBtn.setAttribute('title', 'Добавить в избранное');
      favBtn.textContent = 'В избранное';
    }
  });
}
/******/ })()
;