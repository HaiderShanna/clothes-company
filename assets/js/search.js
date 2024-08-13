const input = document.querySelector('.search-input');
const searchBtn = document.querySelector('.search-btn');
const resultsEl = document.querySelector('.search-results');
let spinner = document.getElementById('search-loader');


async function search(term) {
  console.log(term);


  let res = await fetch(`${baseUrl}search`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({'term': term})
  });
  let data = await res.json();
  resultsEl.innerHTML = `<span class="loader" id="search-loader"></span>`;
  spinner = document.getElementById('search-loader');

  spinner.style.display = 'none';
  if (data.error) {
    resultsEl.innerHTML += `<h2>${data.error}</h2>`;
  }
  else {
    data.forEach(product => {
      resultsEl.innerHTML += `
        <div class="search-product" data-id="${product.id}">
          <img src="${product.img}" alt="product-img">
          <h4 class="product-name">${product.name}</h4>
        </div>
      `;
    });

    /* Shows Product details page When clicking on each product */
    let products = document.querySelectorAll('.search-product');
    products.forEach(product => {
      product.addEventListener('click', (e) => {
        window.location.href = `${baseUrl}product/${e.currentTarget.dataset.id}`
      })
    })
  }
}

input.addEventListener('input', () => {  
  if (input.value !== '') {
    resultsEl.style.opacity = 1;
    spinner.style.display = 'inline-block';
    search(input.value);
  }
  else {
    resultsEl.style.opacity = 0;
    resultsEl.innerHTML = `<span class="loader" id="search-loader"></span>`;
  }
})