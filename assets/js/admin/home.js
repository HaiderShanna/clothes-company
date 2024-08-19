$(document).ready(() => {
  let containerContent = $('.box').html();
  let baseUrl = $('.base-url').val();

  $('.products-div').on('click', showProductsTable);
  $('.statistics-div').on('click', showStatistics);
  $('.back-btn').click(showMain);

  function showProductsTable() {
    let tableEl = `
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
    `;
    $('.box').html(tableEl);
    let table = $('#productsTable').DataTable({
      ajax: `${baseUrl}admin/getproducts`,
      responsive: true,
      pagingType: 'simple_numbers',
      language: {
        paginate: {
          previous: "<i class='bi bi-arrow-left'></i>",
          next: "<i class='bi bi-arrow-right'></i>"
        }
      },
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
      ]
    });

    $('.back-btn').show();

    $(`#productsTable tbody`).on('click', 'tr', function () {
      if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
      }
      else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    });
  }

  function showStatistics() {
    $.get(`${baseUrl}admin/getproducts`, (data, status) => {
      console.log(data);
    })
  }

  function showMain() {
    console.log('test');
    $(".back-btn").hide();
    $(".box").html(containerContent);

    $('.products-div').on('click', showProductsTable);
    $('.statistics-div').on('click', showStatistics);
  }






})
