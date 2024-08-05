import * as module from "../modules/helper.js";

let imageContainer = document.querySelector('.img-container');
let container = document.querySelector('.right-side');
let baseUrl = document.querySelector('.base-url').value;
let id = document.querySelector('.product-id').value;

/* Get the product we want */
$(document).ready(() => {
  $.get(`${baseUrl}product/product/getProduct/${id}`, (data, status) => {
    module.hideSpinner();
    data = JSON.parse(data);

    // Create product elements 
    createElements(data);

    /* Add to cart event listener */
    let addToCartEl  = document.querySelector('.add-to-cart-btn');
    addToCartEl.addEventListener('click', addToCart);


    // Get available colors and sizes and update each time the user change the color
    setColors(data);

    /* update the sizes and quantity when changing the color or the size */
    updateVariants(data);
  })
})

/* Create product DOM elements  */
function createElements(data){
  let imgEl = document.createElement('img');
  let nameEl = document.createElement('h1');
  let descriptionEl = document.createElement('p');
  let selects = document.createElement('div');
  let color = document.createElement('select');
  let size = document.createElement('select');
  let quantityContainer = document.createElement('div');
  let availableQuantity = document.createElement('p');
  let userQuantity = document.createElement('div');
  let label = document.createElement('label');
  let quantity = document.createElement('input');
  let price = document.createElement('h3');
  let addToCart = document.createElement('button');

  // add classes and data 
  imgEl.src = data[0].img;
  nameEl.innerHTML = data[0].name;
  descriptionEl.innerHTML = data[0].description;
  selects.classList.add('selects');
  color.classList.add('color');
  color.innerHTML = `<option>${data[0].color}</option>`;
  size.classList.add('size');
  size.innerHTML = `<option>${data[0].size}</option>`;

  // quantity elements
  quantityContainer.classList.add('quantity-container');
  availableQuantity.classList.add('available-quantity');
  availableQuantity.innerHTML = `Available Quantity: <strong>${data[0].quantity}</strong`;
  userQuantity.classList.add('user-quantity');
  quantity.classList.add('quantity');
  quantity.setAttribute('id', 'quantity');
  quantity.setAttribute('placeholder', 'Enter Quantity');
  quantity.setAttribute('value', 1);
  quantity.setAttribute('type', 'number');
  label.setAttribute('id', 'quantity');
  label.innerHTML = `Quantity`;

  price.classList.add('price');
  price.innerHTML = `$${data[0].price}`;
  addToCart.classList.add('add-to-cart-btn');
  addToCart.innerHTML = `Add To Cart`;

  // empty the containers and add the elements to them
  imageContainer.innerHTML = ``;
  container.innerHTML = ``;
  imageContainer.appendChild(imgEl);
  container.appendChild(nameEl);
  container.appendChild(descriptionEl);
  container.appendChild(selects);
  container.appendChild(quantityContainer);
  container.appendChild(price);
  container.appendChild(addToCart);
  quantityContainer.appendChild(availableQuantity);
  quantityContainer.appendChild(userQuantity);
  selects.appendChild(color);
  selects.appendChild(size);
  userQuantity.appendChild(label);
  userQuantity.appendChild(quantity);

}

/* Get available colors and sizes and return an array */
function getAvailable(data){
  let colors = [];
  let available = [];
  let total = [];
  data.forEach(variant => {
    if(available[variant.color]){
      available[variant.color].push(variant.size);
    }
    else{
      available[variant.color] = [variant.size];
      colors.push(variant.color);
    }
  });
  total.push(colors);
  total.push(available);
  return total;
}

/* get the available colors, sizes and set the default values */
function setColors(data){
  let available = getAvailable(data);
    let colorSelect = document.querySelector('.color');
    let sizeSelect = document.querySelector('.size');
    colorSelect.innerHTML = ``;
    sizeSelect.innerHTML = ``;
    
    available[0].forEach((color, i) => {
      let colorOption = document.createElement('option');
      colorOption.setAttribute('value', color);
      colorOption.innerHTML = color;
      colorSelect.appendChild(colorOption);
    })

    let sizes = available[1][available[0][0]];
    sizes.forEach(size => {
      let sizeOption = document.createElement('option');
      sizeOption.setAttribute('value', size);
      sizeOption.innerHTML = size;
      sizeSelect.appendChild(sizeOption);
    })
}

/* Update the sizes and quantity each time color changes */
function updateVariants(data){
  let colorSelect = document.querySelector('.color');
  let sizeSelect = document.querySelector('.size');
  let quantity = document.querySelector('.available-quantity');

  // change the quantity and sizes when changing the color
  colorSelect.addEventListener('change', ()=>{
    let available = getAvailable(data);
    let sizes = available[1][colorSelect.value];

    sizeSelect.innerHTML = ``;
    sizes.forEach(size => {
      let sizeOption = document.createElement('option');
      sizeOption.setAttribute('value', size);
      sizeOption.innerHTML = size;
      sizeSelect.appendChild(sizeOption);
    })
    quantity.innerHTML = `Available Quantity: <strong>${data[colorSelect.selectedIndex].quantity}</strong>`;
  })

  // change the quantity when changing the size
  sizeSelect.addEventListener('change', ()=>{
    data.forEach(variant => {
      if(variant.color == colorSelect.value && variant.size == sizeSelect.value){
        quantity.innerHTML = `Available Quantity: <strong>${variant.quantity}</strong>`;
      }
    })
  })
}

/* Add product to the local storage (cart) */
function addToCart(){
  let data = JSON.parse(localStorage.getItem('cart')) || [];
  // data += {
  //   id,
  //   img: 
  // }

  // localStorage.setItem('cart', data);
}


/* ------------------------------ */

/* Get more clothes */
async function getClothes(printData, category, limit){
  let res = await fetch(`${baseUrl}home/getClothes/${category}/${limit}`);
  let data = await res.json();
  printData(data);
  module.hideSpinner();
}

/* Print the returned data */
function printProducts(data){
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