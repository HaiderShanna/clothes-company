import * as module from "../modules/helper.js";
module.updateCartNumber();

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
let totalPrice = 0;

/* Print All cart data */
if (cartData.length > 0) {
  productsContainer.innerHTML = ``;
}
cartData.forEach((product) => {
  productsContainer.innerHTML += `
    <div class="product" data-variant-id="${product.variantId}">
      <img class="product-img" data-id="${product.id}" src="${product.img}" alt="product image">
      <h3>${product.name} 
        <small>Color: ${product.color}</small>
        <small data-available="${product.available}">Available: ${product.available}</small>
      </h3>
      <label for="quantity">
        Quantity
        <input type="number" value=${product.quantity} id="quantity">
      </label>
      <p class="price">$${parseFloat(product.price).toFixed(2)}</p>
      <button class="remove-btn" data-id="${product.variantId}"><i class="fa-solid fa-trash"></i></button>
    </div>
  `;
})

updateNumbers();


/* Shows Product details page When clicking on each product */
let products = document.querySelectorAll('.product-img');
products.forEach(product => {
  product.addEventListener('click', (e) => {
    window.location.href = `${baseUrl}product/${e.currentTarget.dataset.id}`
  })
})

/* Removes the item from the UI and localStorage when clicking remove btn */
function removeItem(product, id) {
  let cart = JSON.parse(localStorage.getItem('cart'));
  if(cart.length === 1){
    removeAllProducts();
  }
  else{
    cart.forEach((item, i) => {
      if (item['variantId'].includes(id)) {
        cart.splice(i, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        product.remove();
        module.updateCartNumber();
        updateNumbers();
      }
    })
  }
}

function removeAllProducts() {
  productsContainer.innerHTML = `
    <h1>Your Cart is Empty</h1>
      <a href="${baseUrl}track">
        Track Your Orders
      </a>
  `;
  localStorage.removeItem('cart');
  updateNumbers();
  module.updateCartNumber();
}

/* update the prices numbers */
function updateNumbers() {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  let quantityInputs = document.querySelectorAll('#quantity');
  subtotalPrice = 0;
  cart.forEach((item, i) => {
    subtotalPrice += parseFloat(item.price) * quantityInputs[i].value;
  });
  totalPrice = subtotalPrice + shippingPrice + taxesPrice;
  /* Print the prices */
  subtotal.innerHTML = `$${subtotalPrice.toFixed(2)}`;
  shipping.innerHTML = `$${shippingPrice.toFixed(2)}`;
  taxes.innerHTML = `$${taxesPrice.toFixed(2)}`;
  total.innerHTML = `$${totalPrice.toFixed(2)}`;
}

/* remove btns eventlistener */
let removeBtns = document.querySelectorAll('.remove-btn');
removeBtns.forEach(btn => {
  btn.addEventListener('click', (e) => {
    let product = e.currentTarget.parentNode;
    let id = e.currentTarget.dataset.id;
    Swal.fire({
      title: "Remove Item ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "grey",
      confirmButtonText: "Remove"
    }).then((result) => {
      if (result.isConfirmed) {
        removeItem(product, id);
        Swal.fire({
          title: "Deleted!",
          icon: "success",
          showConfirmButton: false,
          timer: 1000
        });
      }
    });
  });
});


/* quantity inputs eventlistener */
let quantityInputs = document.querySelectorAll('#quantity');

quantityInputs.forEach(input => {
  input.addEventListener('input', (e) => {
    updateNumbers(e.target.value)
  });
})

/* -------------------- */

/* checkout */
function checkout() {
  let products = document.querySelectorAll('.product');

  let data = [];
  let exit = false;
  products.forEach(product => {
    let id = parseInt(product.dataset.variantId);
    let quantity = parseInt(product.children[2].children[0].value);
    let available = product.children[1].children[1].dataset.available;


    if (quantity < 1) {
      Swal.fire({
        title: `quantity must be more than 0`,
        icon: "info",
      });
      exit = true;
    }
    else if (quantity > parseInt(available)) {
      Swal.fire({
        title: `no available quantity`,
        icon: "info",
      });
      exit = true;
    }
    else {
      data.push({ id, quantity });
    }
  })

  if (exit) {
    return;
  }
  else if (data.length < 1) {
    Swal.fire({
      title: "Cart is Empty",
      icon: "info",
    });
    return;
  }
  else {
    let total = document.querySelector('.total span').innerHTML;
    Swal.fire({
      title: "Confirm The Order",
      text: `The total will be : ${total}`,
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "green",
      cancelButtonColor: "grey",
      confirmButtonText: "Confirm"
    }).then((result) => {
      if (result.isConfirmed) {
        newOrder(data);

      }
    });
  }
}

/* send the order to the controller and check if there are any errors */
function newOrder(data) {
  fetch(`${baseUrl}neworder`, {
    method: 'POST',
    headers: {
      'Content-Type': 'app;ication/json'
    },
    body: JSON.stringify(data),

  })
    .then(res => res.json())
    .then(data => {
      if (data.status === "success") {
        Swal.fire({
          title: "New Order Added!",
          text: `The total is :$${data.total.toFixed(2)}`,
          icon: "success",
          showCancelButton: true,
          cancelButtonColor: "grey",
          confirmButtonColor: "blue",
          confirmButtonText: "Track Your Order"
        }).then((result) => {
          if(result.isConfirmed){
            window.location.href = `${baseUrl}track`;
          }
        });
        localStorage.removeItem('cart');
      }
      else {
        Swal.fire({
          title: "Error",
          text: data.error,
          icon: "error",
          showConfirmButton: true
        })
      }
    })
}

let checkoutBtn = document.querySelector('.checkout-btn');
checkoutBtn.addEventListener('click', checkout);