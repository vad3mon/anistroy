/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};

;// CONCATENATED MODULE: ./js/add-to-cart.js
const cartCounter = document.querySelector('.user-nav__counter--cart');
const favCounter = document.querySelector('.user-nav__counter--fav');
const cards = document.querySelectorAll('.card');
const inCart = JSON.parse(localStorage.getItem('inCart')) || {};
const inFavs = JSON.parse(localStorage.getItem('inFavs')) || {};
let itemsInCart;
let itemsInFavs;

if (cartCounter) {
  itemsInCart = Object.keys(inCart).length || 0;
  cartCounter.innerHTML = itemsInCart;
}

if (favCounter) {
  itemsInFavs = Object.keys(inFavs).length || 0;
  favCounter.innerHTML = itemsInFavs;
}

if (cards.length > 0) {
  calcTotalPrice();
  cards.forEach(card => {
    const minusBtn = card.querySelector('.card__minus-btn');
    const inputCounter = card.querySelector('.card__input');
    const plusBtn = card.querySelector('.card__plus-btn');
    const favBtn = card.querySelector('.card__fav-btn');
    const cartBtn = card.querySelector('.card__cart-btn');
    const cardId = card.dataset.pid;
    const cardInStock = card.dataset.stock;
    const cardImage = card.dataset.img;
    const cardPrice = card.dataset.price;
    const cardTitle = card.dataset.title; // если товар добавлен в корзину/избранное, то при перезагрузке страницы
    // добавятся активные состояния кнопок и значение в инпут

    const cardView = {
      cardId,
      inputCounter,
      cartBtn,
      favBtn,
      minusBtn,
      plusBtn
    };
    setCardViewFromStorage(cardView);
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

      if (cartBtn.classList.contains('active')) {
        inCart[cardId].amount = +newValue;
        inCart[cardId].cost = +newValue * inCart[cardId].price;
        localStorage.setItem('inCart', JSON.stringify(inCart));
        calcTotalPrice();
      }
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

      if (cartBtn.classList.contains('active')) {
        inCart[cardId].amount = +newValue;
        inCart[cardId].cost = +newValue * inCart[cardId].price;
        localStorage.setItem('inCart', JSON.stringify(inCart));
        calcTotalPrice();
      }
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

      if (cartBtn.classList.contains('active')) {
        inCart[cardId].amount = +newValue;
        inCart[cardId].cost = +newValue * inCart[cardId].price;
        localStorage.setItem('inCart', JSON.stringify(inCart));
        calcTotalPrice();
      }
    });
    inputCounter.addEventListener('blur', () => {
      if (cartBtn.classList.contains('active')) {
        inCart[cardId].amount = +newValue;
        inCart[cardId].cost = +newValue * inCart[cardId].price;
        localStorage.setItem('inCart', JSON.stringify(inCart));
        calcTotalPrice();
      }
    });
    cartBtn.addEventListener('click', () => {
      if (!cartBtn.classList.contains('active')) {
        inCart[cardId] = {
          pid: cardId,
          image: cardImage,
          price: cardPrice,
          title: cardTitle,
          amount: +inputCounter.value,
          cost: +inputCounter.value * cardPrice,
          stock: cardInStock,
          clickedBtn: true
        }; // анимация добавления в корзину

        animatecardImage(card);
        cartBtn.classList.add('active');
        cartBtn.textContent = 'В корзине';
        localStorage.setItem('inCart', JSON.stringify(inCart));
        itemsInCart = Object.keys(inCart).length;
        cartCounter.innerHTML = itemsInCart;
        calcTotalPrice();
      } else {
        cartBtn.classList.remove('active');
        cartBtn.textContent = 'В корзину';
        delete inCart[cardId];
        localStorage.setItem('inCart', JSON.stringify(inCart));
        itemsInCart = Object.keys(inCart).length;
        cartCounter.innerHTML = itemsInCart;
        calcTotalPrice();
      }
    });
    favBtn.addEventListener('click', () => {
      if (!favBtn.classList.contains('active')) {
        favBtn.classList.add('active');
        favBtn.setAttribute('title', 'Удалить из избранного');
        inFavs[`${cardId}`] = {
          pid: cardId,
          image: cardImage,
          price: cardPrice,
          title: cardTitle,
          stock: cardInStock,
          clickedBtn: true
        };
        localStorage.setItem('inFavs', JSON.stringify(inFavs));
      } else {
        favBtn.classList.remove('active');
        favBtn.setAttribute('title', 'Добавить в избранное');
        delete inFavs[`${cardId}`];
        localStorage.setItem('inFavs', JSON.stringify(inFavs));
      }

      itemsInFavs = Object.keys(inFavs).length;
      favCounter.innerHTML = itemsInFavs;
    });
  });
}

function calcTotalPrice() {
  let getTotalFromStorage = JSON.parse(localStorage.getItem('inCart')) || {};
  let getTotal = [];
  Object.values(getTotalFromStorage).forEach(item => {
    getTotal.push(item.cost);
    return getTotal;
  });
  let totalOrder = getTotal.reduce((accumulator, currentValue) => accumulator + currentValue, 0);
  localStorage.setItem('totalOrder', JSON.stringify(totalOrder));
  cartCounter.setAttribute('title', `Сумма заказа: ${totalOrder} рублей`);
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
function setCardViewFromStorage(cardView) {
  let {
    cardId,
    inputCounter,
    cartBtn,
    favBtn,
    minusBtn,
    plusBtn
  } = cardView;

  for (let key in inCart[cardId]) {
    if (key === 'amount') {
      inputCounter.value = inCart[cardId][key];
      if (+inCart[cardId][key] >= inCart[cardId]['stock']) plusBtn.disabled = true;
      if (+inCart[cardId][key] <= 1) minusBtn.disabled = true;
    }

    if (key === 'clickedBtn') {
      cartBtn.classList.add('active');
      cartBtn.textContent = 'В корзине';
    }
  }

  for (let key in inFavs[cardId]) {
    if (key === 'clickedBtn') {
      favBtn.classList.add('active');
    }
  }
}
;// CONCATENATED MODULE: ./js/product-item.js



const card = document.querySelector('.product');
const product_item_cartCounter = document.querySelector('.user-nav__counter--cart');
const product_item_favCounter = document.querySelector('.user-nav__counter--fav');
const product_item_inCart = JSON.parse(localStorage.getItem('inCart')) || {};
const product_item_inFavs = JSON.parse(localStorage.getItem('inFavs')) || {};
let product_item_itemsInCart;
let product_item_itemsInFavs;

if (product_item_cartCounter) {
  product_item_itemsInCart = Object.keys(product_item_inCart).length || 0;
  product_item_cartCounter.innerHTML = product_item_itemsInCart;
}

if (product_item_favCounter) {
  product_item_itemsInFavs = Object.keys(product_item_inFavs).length || 0;
  product_item_favCounter.innerHTML = product_item_itemsInFavs;
}

if (card) {
  const minusBtn = card.querySelector('.product__minus-btn');
  const inputCounter = card.querySelector('.product__input');
  const plusBtn = card.querySelector('.product__plus-btn');
  const favBtn = card.querySelector('.product__fav-btn');
  const cartBtn = card.querySelector('.product__cart-btn');
  const productId = card.dataset.pid;
  const productInStock = card.dataset.stock;
  const productImage = card.dataset.img;
  const productPrice = card.dataset.price;
  const productTitle = card.dataset.title; // если товар добавлен в корзину/избранное, то при перезагрузке страницы
  // добавятся активные состояния кнопок и значение в инпут

  const cardView = {
    productId,
    inputCounter,
    cartBtn,
    favBtn,
    minusBtn,
    plusBtn
  };
  setCardViewFromStorage(cardView);
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

    if (cartBtn.classList.contains('active')) {
      product_item_inCart[productId].amount = +newValue;
      localStorage.setItem('inCart', JSON.stringify(product_item_inCart));
    }
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

    if (cartBtn.classList.contains('active')) {
      product_item_inCart[productId].amount = +newValue;
      localStorage.setItem('inCart', JSON.stringify(product_item_inCart));
    }
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

    if (cartBtn.classList.contains('active')) {
      product_item_inCart[productId].amount = +newValue;
      localStorage.setItem('inCart', JSON.stringify(product_item_inCart));
    }
  });
  inputCounter.addEventListener('blur', () => {
    if (cartBtn.classList.contains('active')) {
      product_item_inCart[productId].amount = +newValue;
      localStorage.setItem('inCart', JSON.stringify(product_item_inCart));
    }
  });
  cartBtn.addEventListener('click', evt => {
    if (!cartBtn.classList.contains('active')) {
      product_item_inCart[productId] = {
        pid: productId,
        image: productImage,
        price: productPrice,
        title: productTitle,
        amount: +inputCounter.value,
        cost: +inputCounter.value * productPrice,
        stock: productInStock,
        clickedBtn: true
      }; // анимация добавления в корзину

      animateProductImage(card);
      cartBtn.classList.add('active');
      cartBtn.textContent = 'В корзине';
      localStorage.setItem('inCart', JSON.stringify(product_item_inCart));
      product_item_itemsInCart = Object.keys(product_item_inCart).length;
      product_item_cartCounter.innerHTML = product_item_itemsInCart;
      calcTotalPrice();
    } else {
      cartBtn.classList.remove('active');
      cartBtn.textContent = 'В корзину';
      delete product_item_inCart[productId];
      localStorage.setItem('inCart', JSON.stringify(product_item_inCart));
      product_item_itemsInCart = Object.keys(product_item_inCart).length;
      product_item_cartCounter.innerHTML = product_item_itemsInCart;
      calcTotalPrice();
    }
  });
  favBtn.addEventListener('click', evt => {
    if (!favBtn.classList.contains('active')) {
      favBtn.classList.add('active');
      favBtn.setAttribute('title', 'Удалить из избранного');
      favBtn.textContent = 'В избранном';
      product_item_inFavs[`${productId}`] = {
        pid: productId,
        image: productImage,
        price: productPrice,
        title: productTitle,
        clickedBtn: true
      };
      localStorage.setItem('inFavs', JSON.stringify(product_item_inFavs));
    } else {
      favBtn.classList.remove('active');
      favBtn.setAttribute('title', 'Добавить в избранное');
      favBtn.textContent = 'В избранное';
      delete product_item_inFavs[`${productId}`];
      localStorage.setItem('inFavs', JSON.stringify(product_item_inFavs));
    }

    product_item_itemsInFavs = Object.keys(product_item_inFavs).length;
    product_item_favCounter.innerHTML = product_item_itemsInFavs;
  });
}
/******/ })()
;