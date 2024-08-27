$(document).ready(() => {
  let containerContent = $('.box').html();
  let baseUrl = $('.base-url').val();

  $('.products-div').on('click', showProductsTable);
  $('.statistics-div').on('click', showStatistics);

  /* Create and Print the table of the products and all of its functionality */
  function showProductsTable() {
    $('.back-btn').off('click').click(showMain);

    let tableEl = `
      <button id="add-product-btn" class="add-btn btn btn-primary">
        <i class="fa fa-plus" aria-hidden="true"></i>
        Add a new Product
      </button>
      <table id="productsTable" class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>ID</th>
            <th>Img</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Description</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <div class="action-btns" style="display: none;">
        <button id="details-btn" class="btn btn-primary">View Details</button>
        <button id="edit-btn" class="btn btn-secondary">Edit</button>
        <button id="delete-btn" class="btn btn-danger">Delete</button>
      </div>
    `;
    $('.box').html(tableEl);
    $('#productsTable').css('min-width', '1100px');

    let table = $('#productsTable').DataTable({
      ajax: `${baseUrl}admin/getproducts`,
      responsive: true,
      info: false,
      columns: [
        { "data": "id" },
        {
          "data": "img",
          "render": (data, type, row) => {
            return `<img src="${data}" alt="${row.name}" width="80px" height="80px"/>`
          }
        },
        { "data": "name" },
        {
          "data": "price",
          "render": (data, type, row) => {
            return `$${data}`;
          }
        },
        { "data": "category" },
        { "data": "description" },
        { "data": "created_at" },
      ],
      createdRow: (row, data, dataIndex) => {
        $(row).find('td:eq(0)').css('width', '10px'); // ID column
        $(row).find('td:eq(1)').css('width', '120px'); // Image column
        $(row).find('td:eq(2)').css('width', '200px'); // Product Name column
        $(row).find('td:eq(3)').css('width', '90px'); // Price column
        $(row).find('td:eq(4)').css('width', '50px'); // Category column
        $(row).find('td:eq(5)').css('width', '350px'); // Description column
        $(row).find('td:eq(6)').css('width', '250px'); // Created At column
      }
    });

    $('.back-btn').show();

    $(`#productsTable tbody`).on('click', 'tr', function () {
      if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        $('.action-btns').hide();
      }
      else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');

        /* Get row data and enable the Action buttons */
        let data = table.row(this).data();
        let position = $(this).position();

        // Show buttons and position them above the clicked row
        $('.action-btns').show().css({
          top: position.top + 165 + 'px',
          left: '50%',
          transform: 'translateX(-50%)'
        });

        /* Add action buttons Event listeners */
        $('#details-btn').off('click').on('click', () => {
          viewDetails(data);
          $('.action-btns').hide();
          table.$('tr.selected').removeClass('selected');
        })
        $('#edit-btn').off('click').on('click', () => {
          editProduct(data);
          $('.action-btns').hide();
          table.$('tr.selected').removeClass('selected');
        })
        $('#delete-btn').off('click').on('click', () => {
          deleteProduct(data);
          $('.action-btns').hide();
          table.$('tr.selected').removeClass('selected');
        })
      }
    });

    $('#add-product-btn').on('click', () => {
      addProduct();
    })
  }

  /* Create and Print the table of the project statistics */
  function showStatistics() {
    $.get(`${baseUrl}admin/getproducts`, (data, status) => {
    })
  }

  /* Go back to the main home page */
  function showMain() {
    $(".back-btn").hide();
    $(".box").html(containerContent);

    $('.products-div').on('click', showProductsTable);
    $('.statistics-div').on('click', showStatistics);
  }

  /* View Product variants table when clicking view details button */
  function viewDetails(row) {
    let tableEl = `
      <table id="productsTable" class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>ID</th>
            <th>Color</th>
            <th>Size</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <div class="action-btns" style="display: none;">
        <button id="edit-btn" class="btn btn-secondary">Edit</button>
        <button id="delete-btn" class="btn btn-danger">Delete</button>
      </div>
  `;
    $('.box').html(tableEl);
    $('#productsTable').css('min-width', '');

    let table = $('#productsTable').DataTable({
      ajax: `${baseUrl}admin/getproductvariants/${row.id}`,
      responsive: true,
      info: false,
      columns: [
        { "data": "id" },
        { "data": "color" },
        { "data": "size" },
        { "data": "quantity" }
      ]
    });

    $(`#productsTable tbody`).on('click', 'tr', function () {
      if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        $('.action-btns').hide();
      }
      else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');

        /* Get row data and enable the Action buttons */
        let data = table.row(this).data();
        let position = $(this).position();

        // Show buttons and position them above the clicked row
        $('.action-btns').show().css({
          top: position.top + 110 + 'px',
          left: '50%',
          transform: 'translateX(-50%)'
        });

        /* Add action buttons Event listeners */
        $('#details-btn').off('click').on('click', () => {
          viewDetails(data);
          $('.action-btns').hide();
          table.$('tr.selected').removeClass('selected');
        })
        $('#edit-btn').off('click').on('click', () => {
          editProduct(data);
          $('.action-btns').hide();
          table.$('tr.selected').removeClass('selected');
        })
        $('#delete-btn').off('click').on('click', () => {
          deleteProduct(data);
          $('.action-btns').hide();
          table.$('tr.selected').removeClass('selected');
        })
      }
    });

    /* Add Back button on click */
    $('.back-btn').off('click').on('click', showProductsTable);
  }

  /* Create Edit Modal */
  function editProduct(row) {
    // Create edit modal container
    let editModal = `
      <div class="edit-modal" style="display: none;">
        <div class="modal-container form-group">
          <h3>Edit Product :</h3>
          <input type="text" class="name-input form-control" placeholder="Enter Product Name" value="${row.name}">
          <input type="number" class="price-input form-control" placeholder="Enter a Price" value="${row.price}">
          <input type="text" class="description-input form-control" placeholder="Enter a Description" value="${row.description}">
          <select class="category-select form-control">
            <option value="1">Men</option>
            <option value="2">Women</option>
            <option value="3">Children</option>
          </select>
          <div class="edit-action-btns">
            <button class="confirm-edit-btn btn-primary">Edit</button>
            <button class="cancel-edit-btn btn-secondary">Cancel</button>
          </div>
        </div>
      </div>
    `;
    $('.box').prepend(editModal);

    // create an overlay 
    $('body').append('<div class="edit-overlay"></div>');
    $('body').css('overflow', 'hidden');
    $('.edit-modal').show();

    // add event listeners to the Edit and cancel buttons
    $('.confirm-edit-btn').click(() => {
      let data = {
        id: row.id,
        name: $('.name-input').val(),
        price: $('.price-input').val(),
        description: $('.description-input').val(),
        categoryId: $('.category-select').val()
      }
      confirmEdit(data);

      $('.edit-modal').remove();
      $('.edit-overlay').remove();
      $('body').css('overflow', 'auto');
    });
    $('.cancel-edit-btn').click(() => {
      $('.edit-modal').remove();
      $('.edit-overlay').remove();
      $('body').css('overflow', 'auto');
    });
  }

  /* Send Update request to the update API */
  function confirmEdit(productData) {
    $.post(`${baseUrl}admin/editproduct`, productData,
      function (data, textStatus, jqXHR) {
        data = JSON.parse(data);

        if (data.error) {
          Swal.fire({
            icon: "error",
            title: data.error,
            showConfirmButton: true,
          });
        }
        else {
          Swal.fire({
            icon: "success",
            title: "Updated Successfully",
            showConfirmButton: false,
            timer: 1000
          });
          // Update the row in the table
          let table = $('#productsTable').DataTable();

          let row = table.row((idx, rowData) => {
            return rowData.id == data.row.id;
          })
          row.data(data.row).draw(false);
        }
      }
    );
  }



  /* Create Add product modal */
  function addProduct() {
    let editModal = `
    <div class="edit-modal" style="display: none;">
      <div class="modal-container form-group">
        <h3>Add a New Product :</h3>
        <input type="text" class="name-input form-control" placeholder="Enter Product Name">
        <input type="number" class="price-input form-control" placeholder="Enter a Price">
        <input type="text" class="description-input form-control" placeholder="Enter a Description">
        <select class="category-select form-control">
          <option value="" disabled selected>Select a Category</option>
          <option value="1">Men</option>
          <option value="2">Women</option>
          <option value="3">Children</option>
        </select>
        <input type="text" class="color-input form-control" placeholder="Enter a Color">
        <select class="size-select form-control">
          <option value="" disabled selected>Select a Size</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
          <option value="XXL">XXL</option>
          <option value="3XL">3XL</option>
          <option value="4XL">4XL</option>
          <option value="5XL">5XL</option>
        </select>
        <input type="number" class="quantity-input form-control" placeholder="Enter a Quantity">
        <div class="edit-action-btns">
          <button class="confirm-edit-btn btn-primary">Add</button>
          <button class="cancel-edit-btn btn-secondary">Cancel</button>
        </div>
      </div>
    </div>
    `;
    $('.box').prepend(editModal);

    // create an overlay 
    $('body').append('<div class="edit-overlay"></div>');
    $('body').css('overflow', 'hidden');
    $('.edit-modal').show();

    // add event listeners to the Add and cancel buttons
    $('.confirm-edit-btn').click(() => {
      let data = {
        name: $('.name-input').val(),
        price: $('.price-input').val(),
        description: $('.description-input').val(),
        categoryId: $('.category-select').val(),
        color: $('.color-input').val(),
        size: $('.size-select').val(),
        quantity: $('.quantity-input').val()
      }

      if (data.name === "" || data.price == "" ||
        data.description === "" || data.color === "" ||
        data.size === "" || data.quantity == "" ||
        data.categoryId === null || data.size === null
      ) {
        Swal.fire({
          icon: "error",
          title: 'Fill in all fields',
          showConfirmButton: false,
          timer: 1000
        });
      }
      else if (data.price <= 0) {
        Swal.fire({
          icon: "error",
          title: 'Price must be more than $0',
          showConfirmButton: true,
        });
      }
      else if (data.quantity <= 0) {
        Swal.fire({
          icon: "error",
          title: 'Quantity must be more than 0',
          showConfirmButton: true,
        });
      }
      else {
        confirmAddProduct(data);

        $('.edit-modal').remove();
        $('.edit-overlay').remove();
        $('body').css('overflow', 'auto');
      }
    });
    $('.cancel-edit-btn').click(() => {
      $('.edit-modal').remove();
      $('.edit-overlay').remove();
      $('body').css('overflow', 'auto');
    });
  }

  /* Add the product to the database with a default variant */
  function confirmAddProduct(data) {
    $.post(`${baseUrl}admin/addproduct`, data,
      function (data2, textStatus, jqXHR) {
        data2 = JSON.parse(data2);
        if (data2.error) {
          Swal.fire({
            icon: "error",
            title: data2.error,
            showConfirmButton: true,
          });
        }
        else {
          Swal.fire({
            icon: "success",
            title: 'Product Added Successfully',
            showConfirmButton: false,
            timer: 1000
          });

          let category;
          switch (data2.category_id) {
            case "1":
              category = "Men"
              break;
            case "2":
              category = "Women"
              break;
            case "3":
              category = "Children"
              break;
            default:
              break;
          }

          let table = $('#productsTable').DataTable();
          let row = {
            id: data2.id,
            img: data2.img,
            name: data2.name,
            price: data2.price,
            category: category,
            description: data2.description,
            created_at: data2.created_at,
          };

          table.row.add(row).draw(false);
        }
      }
    );
  }



  /* View Product variants table when clicking view details button */
  function deleteProduct(row) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "DELETE",
          url: `${baseUrl}admin/deleteproduct`,
          data: row.id,
          success: function (response) {
            response = JSON.parse(response);

            if (response.error) {
              Swal.fire({
                icon: "error",
                title: response.error,
                showConfirmButton: true,
              });
            }
            else {
              Swal.fire({
                title: "Deleted!",
                text: "Product Deleted Successfully.",
                showConfirmButton: false,
                icon: "success",
                timer: 1000
              });

              let table = $('#productsTable').DataTable();
              let node;
              table.rows().every(function() {
                let data = this.data();
                
                if(data.id == row.id){
                  node = this.node();
                }
              })
              table.row(node).remove().draw(false);
            }
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: "error",
              title: error,
              showConfirmButton: true,
            });
          }
        });
      }
    });
  }





})
