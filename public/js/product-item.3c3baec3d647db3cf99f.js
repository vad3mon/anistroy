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
    card.addEventListener('click', evt => {
      let currentValue = +inputCounter.value;
      let newValue; // нажатие на плюсик

      if (evt.target == plusBtn) {
        minusBtn.disabled = false;

        if (currentValue + 1 >= productInStock) {
          newValue = productInStock;
          plusBtn.disabled = true;
        } else {
          newValue = currentValue + 1;
        }

        inputCounter.value = newValue;

        if (cartBtn.classList.contains('active')) {
          inCart[productId].amount = +newValue;
          inCart[productId].cost = +newValue * inCart[productId].price;
          localStorage.setItem('inCart', JSON.stringify(inCart));
          calcTotalPrice();
        }
      } // нажатие на минус


      if (evt.target == minusBtn) {
        plusBtn.disabled = false;

        if (currentValue - 1 <= 1) {
          newValue = 1;
          minusBtn.disabled = true;
        } else {
          newValue = currentValue - 1;
        }

        inputCounter.value = newValue;

        if (cartBtn.classList.contains('active')) {
          inCart[productId].amount = +newValue;
          inCart[productId].cost = +newValue * inCart[productId].price;
          localStorage.setItem('inCart', JSON.stringify(inCart));
          calcTotalPrice();
        }
      } // ввод в инпут


      if (evt.target == inputCounter) {
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
            inCart[productId].amount = +newValue;
            inCart[productId].cost = +newValue * inCart[productId].price;
            localStorage.setItem('inCart', JSON.stringify(inCart));
            calcTotalPrice();
          }
        });
        inputCounter.addEventListener('blur', () => {
          if (cartBtn.classList.contains('active')) {
            inCart[productId].amount = +newValue;
            inCart[productId].cost = +newValue * inCart[productId].price;
            localStorage.setItem('inCart', JSON.stringify(inCart));
            calcTotalPrice();
          }
        });
      } // добавление в корзину


      if (evt.target == cartBtn) {
        if (!cartBtn.classList.contains('active')) {
          inCart[productId] = {
            pid: productId,
            image: productImage,
            price: productPrice,
            title: productTitle,
            amount: currentValue,
            cost: productPrice * currentValue,
            stock: productInStock,
            clickedBtn: true
          }; // анимация добавления в корзину

          animateProductImage(card);
          cartBtn.classList.add('active');
          cartBtn.textContent = 'В корзине';
          localStorage.setItem('inCart', JSON.stringify(inCart));
          itemsInCart = Object.keys(inCart).length;
          cartCounter.innerHTML = itemsInCart;
          calcTotalPrice();
        } else {
          cartBtn.classList.remove('active');
          cartBtn.textContent = 'В корзину';
          delete inCart[productId];
          localStorage.setItem('inCart', JSON.stringify(inCart));
          itemsInCart = Object.keys(inCart).length;
          cartCounter.innerHTML = itemsInCart;
          calcTotalPrice();
        }
      } //добавление в избранное


      if (evt.target == favBtn) {
        if (!favBtn.classList.contains('active')) {
          favBtn.classList.add('active');
          favBtn.setAttribute('title', 'Удалить из избранного');
          inFavs[`${productId}`] = {
            pid: productId,
            image: productImage,
            price: productPrice,
            title: productTitle,
            stock: productInStock,
            clickedBtn: true
          };
          localStorage.setItem('inFavs', JSON.stringify(inFavs));
        } else {
          favBtn.classList.remove('active');
          favBtn.setAttribute('title', 'Добавить в избранное');
          delete inFavs[`${productId}`];
          localStorage.setItem('inFavs', JSON.stringify(inFavs));
        }

        itemsInFavs = Object.keys(inFavs).length;
        favCounter.innerHTML = itemsInFavs;
      }
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
  const productImage = element.querySelector('img');
  const productImageFly = productImage.cloneNode(true);
  const productImageFlyWidth = productImage.offsetWidth;
  const productImageFlyHeight = productImage.offsetHeight;
  const productImageFlyTop = productImage.getBoundingClientRect().top;
  const productImageFlyLeft = productImage.getBoundingClientRect().left;
  productImageFly.classList.add('image-fly');
  productImageFly.style.cssText = `
    left: ${productImageFlyLeft}px;
    top: ${productImageFlyTop}px;
    width: ${productImageFlyWidth}px;
    height: ${productImageFlyHeight}px
  `;
  document.body.append(productImageFly);
  const cartFlyTop = cartCounter.getBoundingClientRect().top;
  const cartFlyLeft = cartCounter.getBoundingClientRect().left;
  productImageFly.style.cssText = `
    left: ${cartFlyLeft}px;
    top: ${cartFlyTop}px;
    width: 0px;
    height: 0px;
    opacity: 0;
  `;
  productImageFly.addEventListener('transitionend', () => {
    productImageFly.remove();
  });
}
function setCardViewFromStorage(cardView) {
  let {
    productId,
    inputCounter,
    cartBtn,
    favBtn,
    minusBtn,
    plusBtn
  } = cardView;

  for (let key in inCart[productId]) {
    if (key === 'amount') {
      inputCounter.value = inCart[productId][key];
      if (+inCart[productId][key] >= inCart[productId]['stock']) plusBtn.disabled = true;
      if (+inCart[productId][key] <= 1) minusBtn.disabled = true;
    }

    if (key === 'clickedBtn') {
      cartBtn.classList.add('active');
      cartBtn.textContent = 'В корзине';
    }
  }

  for (let key in inFavs[productId]) {
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
  card.addEventListener('click', evt => {
    let currentValue = +inputCounter.value;
    let newValue;

    if (evt.target == plusBtn) {
      minusBtn.disabled = false;

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
    }

    if (evt.target == minusBtn) {
      plusBtn.disabled = false;

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
    }

    if (evt.target == inputCounter) {
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
    }

    if (evt.target == cartBtn) {
      if (!cartBtn.classList.contains('active')) {
        product_item_inCart[productId] = {
          pid: productId,
          image: productImage,
          price: productPrice,
          title: productTitle,
          amount: currentValue,
          cost: productPrice * currentValue,
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
    }

    if (evt.target == favBtn) {
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
    }
  });
}
/******/ })()
;