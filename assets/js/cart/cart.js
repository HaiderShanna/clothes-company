import * as module from "../modules/helper.js";

let baseUrl = document.querySelector('.base-url').value;
let productsContainer = document.querySelector('.products-container');
const subtotal = document.querySelector('.subtotal span');
const shipping = document.querySelector('.shipping span');
const taxes = document.querySelector('.taxes span');
const total = document.querySelector('.total span');

/* Getting cart data from the local storage */
let cartData = JSON.parse(localStorage.getItem('cart')) || [];

/* Calculate the prices */
const shippingPrice = 5.00;
const taxesPrice = 0.00;
let subtotalPrice = 0; 
let totalPrice; 

/* Print All cart data */
productsContainer.innerHTML = ``;
cartData.forEach((product) => {
  subtotalPrice += product.price;
  productsContainer.innerHTML += `
    <div class="product">
      <img class="product-img" data-id="${product.id}" src="${baseUrl}assets/imgs/products/${product.img}" alt="product image">
      <h3>${product.name} 
        <small>Color: ${product.color}</small>
        <small>Available: ${product.available}</small>
      </h3>
      <label for="quantity">
        Quantity
        <input type="number" value=${product.quantity} id="quantity">
      </label>
      <p class="price">$${product['price'].toFixed(2)}</p>
      <button class="remove-btn" data-id="${product.id}"><i class="fa-solid fa-trash"></i></button>
    </div>
  `;
})
totalPrice = subtotalPrice + shippingPrice + taxesPrice;


/* Print the prices */
subtotal.innerHTML = `$${subtotalPrice.toFixed(2)}`;
shipping.innerHTML = `$${shippingPrice.toFixed(2)}`;
taxes.innerHTML = `$${taxesPrice.toFixed(2)}`;
total.innerHTML = `$${totalPrice.toFixed(2)}`;


/* Shows Product details page When clicking on each product */
let products = document.querySelectorAll('.product-img');
products.forEach(product => {
  product.addEventListener('click', (e) => {
    window.location.href = `${baseUrl}product/${e.currentTarget.dataset.id}`
  })
})