import * as module from "../modules/helper.js";

let container = document.querySelector('.container');
let bestSelling = document.querySelector('.best-selling .products-grid');
let men = document.querySelector('.men-clothes .products-grid');
let women = document.querySelector('.women-clothes .products-grid');
let children = document.querySelector('.children-clothes .products-grid');
let baseUrl = document.getElementById('base-url').value;
let categorySelect = document.querySelector('.category');

let defaultContainer = container.innerHTML;


/* 
Get data for specific category, limit and run a callback function with the returned data  
*/
async function getClothes(printData, category, limit){
  let res = await fetch(`${baseUrl}home/getClothes/${category}/${limit}`);
  let data = await res.json();
  printData(data, category);
  module.hideSpinner();

}
/* print products categories to the UI */
function printClothesCategories(data, categoryName){

  let category = '';
  switch (categoryName) {
    case 'men':
        category = document.querySelector(`.men-clothes .products-grid`);
      break;
    case 'women':
      category = document.querySelector(`.women-clothes .products-grid`);
      break;
    case 'children':
      category = document.querySelector(`.children-clothes .products-grid`);
      break;
    default:
      category = document.querySelector(`.best-selling .products-grid`);
      break;
    }


  data.forEach(product => {
    category.innerHTML += `
      <div class="product" data-id="${product.id}">
        <img src="${product.img}" alt="img">
        <h4 class="product-name">${product.name}</h4>
        <p class="price">$${product.price}</p>
        <button class="add-to-cart-btn">Show Details</button>
      </div>
    `;
  });

}


/* Get all products for specific category from the database */
async function getAllClothes(callback, category){
  let res = await fetch(`http://localhost/clothes_company/home/allclothes/${category}`);
  let data = await res.json();
  callback(data, category);  
}

/* prints the recieved data from (getAllClothes) function */
function printAllClothes(data, category){
  let head = document.createElement('h1');
  let back = document.createElement('button');
  let allProducts = document.createElement('div');
  back.classList.add('back-btn');
  head.classList.add('all-products-head');
  allProducts.classList.add('all-products-container');
  head.appendChild(back);
  head.innerHTML = `All ${category} Clothes:`;
  back.innerHTML = `Back`
  container.innerHTML = ``;

  container.appendChild(back);
  container.appendChild(head);
  container.appendChild(allProducts);
  data.forEach(product => {
    allProducts.innerHTML += `
    <div class="product all" data-id="${product.id}">
      <img src="${product.img}" alt="img">
      <h4 class="product-name">${product.name}</h4>
      <p class="price">$${product.price}</p>
      <button class="add-to-cart-btn">Show Details</button>
    </div>
    `;
  })
  module.hideSpinner();

  /* Shows Product details page When clicking on each product */
  let products = document.querySelectorAll('.product');
  products.forEach(product => {
    product.addEventListener('click', (e) => {
      window.location.href = `${baseUrl}product/${e.currentTarget.dataset.id}`
    })
  })

  
  /* Back button on click */
  let backBtn = document.querySelector('.back-btn');
  backBtn.addEventListener('click', ()=>{
  container.innerHTML = defaultContainer;
    printData();
    categorySelect.selectedIndex = 0;
  })
}

async function printData() {
  // Get and print best selling products
  await getClothes(printClothesCategories, 'best-selling', 8);
  await getClothes(printClothesCategories, 'men', 8);
  await getClothes(printClothesCategories, 'women', 8);
  await getClothes(printClothesCategories, 'children', 8);

  /* Shows Product details page When clicking on each product */
  let products = document.querySelectorAll('.product');
  products.forEach(product => {
    product.addEventListener('click', (e) => {
      window.location.href = `${baseUrl}product/${e.currentTarget.dataset.id}`
    })
  })


  /* Show all button on click */
  let showAll = document.querySelectorAll('.show-all-btn');
  showAll.forEach(btn => {
    btn.addEventListener('click', (e) => {
      module.showSpinner();
      let button = e.target;
      let category = button.getAttribute('data-category');
      getAllClothes(printAllClothes, category);
    })
  })

  /* Show all button on click */
  categorySelect.addEventListener('change', (e) => {
    module.showSpinner();
    let category = categorySelect.value;
    getAllClothes(printAllClothes, category);
  })
}


printData();