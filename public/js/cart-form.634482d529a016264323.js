/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
const orderForm = document.querySelector('.cart__form .form');
const cartForm = document.querySelector('.cart');
const agreementCheckbox = document.querySelector('.form__checkbox');

if (orderForm) {
  const userData = JSON.parse(localStorage.getItem('userData')) || {};
  const formItems = document.querySelectorAll('.form__item');
  formItems.forEach(item => {
    const input = item.querySelector('.form__input');
    const errorField = item.querySelector('.form__error-text');
    let phoneMask;

    if (Object.keys(userData).length > 0 && userData[input.name]) {
      input.value = userData[input.name].value;
      input.dataset.valid = userData[input.name].valid;
      isValidFields(orderForm);
    }

    if (input.name === 'phone') {
      phoneMask = IMask(input, {
        mask: '+{7}(000)000-00-00',
        lazy: false
      });
    }

    input.addEventListener('input', () => {
      if (input.name === 'username') validateUserName(input, errorField);
      if (input.name === 'email') validateEmail(input, errorField);
      if (input.name === 'phone') validatePhone(phoneMask, input, errorField);
      if (input.name === 'address') validateAddress(input, errorField);
      isValidFields(orderForm);
    });
    input.addEventListener('blur', () => {
      const isValid = input.getAttribute('data-valid');

      if (isValid === 'true') {
        userData[input.name] = {
          valid: true,
          value: input.value
        };
        localStorage.setItem('userData', JSON.stringify(userData));
      }
    });
  });
  agreementCheckbox.addEventListener('click', () => {
    isValidFields(orderForm);
  });
}

function validateUserName(input, errorField) {
  if (!input.value.trim() == '') {
    input.dataset.valid = true;
    errorField.textContent = '';
  } else {
    input.dataset.valid = false;
    errorField.textContent = 'Поле не должно быть пустым';
  }
}

function validateEmail(input, errorField) {
  const mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

  if (input.value.match(mailformat)) {
    input.dataset.valid = true;
    errorField.textContent = '';
  } else {
    input.dataset.valid = '';
  } // else if (input.value.trim() == '') {
  //   input.dataset.valid = false;
  //   errorField.textContent = 'Поле не должно быть пустым';
  // } else {
  //   input.dataset.valid = false;
  //   errorField.textContent = 'Некорректный email';
  // }

}

function validatePhone(phoneMask, input, errorField) {
  if (phoneMask.unmaskedValue.length == 11) {
    input.dataset.valid = true;
    errorField.textContent = '';
  } else {
    input.dataset.valid = false;
    errorField.textContent = 'Введите корректный номер телефона';
  }
}

function validateAddress(input, errorField) {
  if (!input.value.trim() == '') {
    input.dataset.valid = true;
    errorField.textContent = '';
  } else {
    input.dataset.valid = '';
  }
}

function isValidFields(formName) {
  const requiredFields = formName.querySelectorAll('[data-required]');
  const validFields = formName.querySelectorAll('[data-valid=true][data-required]');
  const formBtn = formName.querySelector('.form__buy-btn');

  if (validFields.length === requiredFields.length && agreementCheckbox.checked) {
    formBtn.disabled = false;
  } else {
    formBtn.disabled = true;
  }
}
/******/ })()
;