import * as module from "../modules/helper.js";
module.updateCartNumber();

let imageContainer = document.querySelector('.img-container');
let container = document.querySelector('.right-side');
let baseUrl = document.querySelector('.base-url').value;
let id = document.querySelector('.product-id').value;
let loggedIn = document.getElementById('logged-in-session');
let dialog = document.querySelector('dialog');

/* Get the product we want */
$(document).ready(() => {
  $.get(`${baseUrl}product/product/getVariants/${id}`, (data, status) => {
    module.hideSpinner();
    data = JSON.parse(data);

    // Create product elements 
    createElements(data);

    /* Add to cart event listener */
    let addToCartEl = document.querySelector('.add-to-cart-btn');
    addToCartEl.addEventListener('click', ()=>{
      if(loggedIn.value){
        addToCart();
      }
      else{
        dialog.showModal();
      }
    });


    // Get available colors and sizes and update each time the user change the color
    setColors(data);
  })
})

/* Create product DOM elements  */
function createElements(data) {
  let quantity = data[0].quantity.split(',');
  imageContainer.innerHTML = `<img src="${data[0].img}" alt="product_img">`;
  container.innerHTML = `
    <h1 class="product-name">${data[0].name}</h1>
    <div class="description">
      <h3>Description :</h3>
      <p>${data[0].description}</p>
    </div>
    <div class="selects">
      <select id="color" class="color">

      </select>
      <select id="size" class="size">

      </select>
    </div>
    <div class="quantity-container">
      <p class="available-quantity">available quantity: <strong>${quantity[0]}</strong></p>
      <div class="user-quantity">
        <label for="quantity">Quantity</label>
        <input type="number" placeholder="Enter Quantity" value=1 id="quantity" class="quantity">
      </div>
    </div>
    <h3 class="price">$<span>${data[0].price}</span></h3>
    <button class="add-to-cart-btn">Add To Cart</button>
  `;
}

/* get the available colors, sizes and set the default values */
function setColors(data) {
  let colorSelect = document.querySelector('.color');
  let sizeSelect = document.querySelector('.size');
  colorSelect.innerHTML = ``;
  sizeSelect.innerHTML = ``;

  data.forEach(variant => {
    // add color options
    let colorOption = document.createElement('option');
    colorOption.setAttribute('value', variant.color);
    colorOption.innerHTML = variant.color;
    colorSelect.appendChild(colorOption);

    // add size options
    if(colorSelect.value === variant.color){
      let sizes = (variant.sizes).split(',');
      sizes.forEach(size => {
        let sizeOption = document.createElement('option');
        sizeOption.setAttribute('value', size);
        sizeOption.innerHTML = size;
        sizeSelect.appendChild(sizeOption);
      })
    }
  })
  /* update the sizes and quantity when changing the color or the size */
  colorChange(data);
}

/* Update the sizes and UI each time color or size changes */
function colorChange(data) {
  let colorSelect = document.querySelector('.color');
  let sizeSelect = document.querySelector('.size');

  // change the quantity and sizes when changing the color
  colorSelect.addEventListener('change', () => {
    data.forEach(variant => {
      if(colorSelect.value === variant.color){
        sizeSelect.innerHTML = ``;
        let sizes = (variant.sizes).split(',');
        sizes.forEach(size => {
          let sizeOption = document.createElement('option');
          sizeOption.setAttribute('value', size);
          sizeOption.innerHTML = size;
          sizeSelect.appendChild(sizeOption);
        })
        updateUI(variant);
      }
    });
  })

  /* update UI each time size changes */
  sizeSelect.addEventListener('change', () => {
    data.forEach(variant => {
      if(variant.color === colorSelect.value){
        updateUI(variant);
      }
    });
  });
}

  /* update available quantity, img and price */
  function updateUI(selectedVariant){
    let sizeSelect = document.querySelector('.size');

    // available quantity
    let quantity = document.querySelector('.available-quantity strong');
    let available = (selectedVariant.quantity).split(',')
    quantity.innerHTML = available[sizeSelect.selectedIndex];
  }

/* Add product to the local storage (cart) */
function addToCart() {
  let img = imageContainer.childNodes[0].src;
  let name = document.querySelector('.product-name').innerHTML;
  let color = document.querySelector('.color').value;
  let size = document.querySelector('.size').value;
  let quantity = document.querySelector('.quantity').value;
  let available = document.querySelector('.available-quantity strong').innerHTML;
  let price = document.querySelector('.price span').innerHTML;
  let data = JSON.parse(localStorage.getItem('cart')) || [];

  // console.log(available);
  if(quantity > parseInt(available)){
    Swal.fire({
      title: "No Available Quantity",
      icon: "error",
    });
  }
  else{
    data.push({
      id,
      img,
      name,
      color,
      size,
      quantity,
      available,
      price
    }) 
    localStorage.setItem('cart', JSON.stringify(data));

    Swal.fire({
      title: "Added To Cart",
      icon: "success",
      showConfirmButton: false,
      timer: 1000
    });

    module.updateCartNumber();
  }
}


/* ------------------------------ */

/* Get more clothes */
async function getClothes(printData, category, limit) {
  let res = await fetch(`${baseUrl}home/getClothes/${category}/${limit}`);
  let data = await res.json();
  printData(data);
  module.hideSpinner();
}

/* Print the returned data */
function printProducts(data) {
  let productsGrid = document.querySelector('.products-grid');
  data.forEach(product => {
    productsGrid.innerHTML += `
      <div class="product" data-id="${product.id}">
        <img src="${product.img}" alt="img">
        <h4 class="product-name">${product.name}</h4>
        <p class="price">$${product.price}</p>
        <button class="add-to-cart-btn">Show Details</button>
      </div>
    `;
  });

  /* Shows Product details page When clicking on each product */
  let products = document.querySelectorAll('.product');
  products.forEach(product => {
    product.addEventListener('click', (e) => {
      window.location.href = `${baseUrl}product/${e.currentTarget.dataset.id}`
    })
  })
}
getClothes(printProducts, 'best-selling', 8);