let baseUrl = document.getElementById('base-url').value;

$(document).ready(function () {

  $.get(`${baseUrl}orders`, (data, status) => {
    if (data.status === "error") {
      Swal.fire({
        title: "Error",
        text: data.error,
        icon: "error",
        showConfirmButton: true
      })
    }
    else {
      data = JSON.parse(data);
      let currentOrder = -1;

      $('.container').html('');

      data.forEach(product => {

        /* Check if the order is already in the UI or not */
        if(currentOrder != product.order_id){
          // adds a new order to the UI
          $('.container').append(`
              <div class="order">
                <div class="top">
                  <div class="items items${product.order_id}">
                    <div class="item" data-id="${product.product_id}">
                      <div class="quantity"><span>${product.quantity}</span></div>
                      <img class="product-img" src="${product.img}" alt="">
                      <p class="product-name">${product.name}</p>
                      <p>$<span>${product.price}</span></p>
                    </div>
                  </div>
                  <div class="total">$<span>${product.total}</span></div>
                </div>
                <div class="bottom">
                  <div class="row px-3">
                    <div class="col">
                      <ul id="progressbar" class="pb${product.order_id}">
                        <li class="step0 active " id="step1">PENDING</li>
                        <li class="step0 text-center" id="step2">SHIPPED</li>
                        <li class="step0 text-muted text-right" id="step3">DELIVERED</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            `);
            currentOrder = product.order_id;
            switch (product.status) {
              case 'delivered':
                $(`.pb${product.order_id} #step2`).addClass("active");
                $(`.pb${product.order_id} #step3`).addClass("active");
              break;
              case 'shipped':
                $(`.pb${product.order_id} #step2`).addClass("active");
              break;
            }
        }
        else{
          // adds a new item to the order
          $(`.items${product.order_id}`).append(`
            <div class="item" data-id="${product.product_id}">
              <div class="quantity"><span>${product.quantity}</span></div>
              <img class="product-img" src="${product.img}" alt="">
              <p class="product-name">${product.name}</p>
              <p>$<span>${product.price}</span></p>
            </div>
          `);
        }
      });

      /* Shows Product details page When clicking on each product */
      $('.item').click(function (e) {
        window.location.href = `${baseUrl}product/${e.currentTarget.dataset.id}`
      })
    }
  })
})










