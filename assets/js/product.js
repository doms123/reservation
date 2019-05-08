$(function() {
  const baseUrl = $('body').attr('data-url');
  let editId;
  let allProducts;
  $('.productTree').show();
  items();
  function items() {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}/items`,
      data: {},
      success: function ({ result, success }) {
        allProducts = result;
        if (success) {
          let html = '';
          if (result.length) {
            const maxLoop = result.length;
            for (let x = 0; x < maxLoop; x++) {
              let status;
              let statClass;

              if (result[x]['status'] == '1') {
                status = 'In stock';
                statClass = 'inStock';
              } else {
                statClass = 'outStock';
                status = 'Out of stock';
              }

              html += '<tr>';
                html += `<td>${result[x]['title']}</td>`;
                html += `<td>${result[x]['description']}</td>`;
                html += `<td>${numberWithCommas(result[x]['price'])}</td>`;
                html += `<td class="${statClass}">${status}</td>`;
                html += `<td>${convertDate(result[x]['dateAdded'])}</td>`;
                html += `<td class="room-action-btn">`;
                  html += `<button type="button" class="btn btn-info btn-sm editBtn" data-toggle="modal" data-id="${result[x].productId}"><i class="fa fa-edit"></i> Edit</button>`;
                  html += `<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${result[x].productId}"><i class="fa fa-trash"></i> Delete</button>`;
                html += `</td>`;
              html += '<tr>';
            }
          } else {
            html += '<tr><td style="text-align: left;">No item yet.</td></tr>';
          }

          $('.prodTbody').html(html);
        }
      }
    });
  }

  $('.searchForm').submit(function(e) {
    e.preventDefault();
    const searchTxt = $('.searchTxt').val();
    const newSearch = searchTxt.toLowerCase();

    const newResult = allProducts.filter(function (el) {
      const title = el.title.toLowerCase();
      const description = el.description.toLowerCase();
      const price = el.price.toLowerCase();
      return title.includes(newSearch) || 
              description.includes(newSearch) || 
              price.includes(newSearch);
    });

    if (newSearch) {
      let html = '';
      if (newResult.length) {
        const maxLoop = newResult.length;
        for (let x = 0; x < maxLoop; x++) {
          let status;
          let statClass;

          if (newResult[x]['status'] == '1') {
            status = 'In stock';
            statClass = 'inStock';
          } else {
            statClass = 'outStock';
            status = 'Out of stock';
          }

          html += '<tr>';
            html += `<td>${newResult[x]['title']}</td>`;
            html += `<td>${newResult[x]['description']}</td>`;
            html += `<td>${numberWithCommas(newResult[x]['price'])}</td>`;
            html += `<td class="${statClass}">${status}</td>`;
            html += `<td>${convertDate(newResult[x]['dateAdded'])}</td>`;
            html += `<td class="room-action-btn">`;
              html += `<button type="button" class="btn btn-info btn-sm editBtn" data-toggle="modal" data-id="${newResult[x].productId}"><i class="fa fa-edit"></i> Edit</button>`;
              html += `<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${newResult[x].productId}"><i class="fa fa-trash"></i> Delete</button>`;
            html += `</td>`;
          html += '<tr>';
        }
      } else {
        html += '<tr><td style="text-align: left;">No item yet.</td></tr>';
      }

      $('.prodTbody').html(html);
    } else {
      items();
    }
  });

  $('.prodTbody').delegate('.deleteBtn', 'click', function() {
    deleteId = $(this).attr('data-id');
    $('#modal-prod-delete').modal('show');
    $('.deleteItemBtn').attr('data-delete', deleteId);
  });

  $('.deleteItemBtn').click(function() {
    deleteId = $(this).attr('data-delete');

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/deleteItem`,
      data: {
        deleteId
      },
      success: function({ success }) {
        if (success) {
          $('#modal-prod-delete').modal('hide');
          items();
          $.toast({
            heading: 'Success',
            text: 'Item was deleted',
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
        }
      }
    });
  });


  $('.prodTbody').delegate('.editBtn', 'click', function() {
    editId = $(this).attr('data-id');
    $('#product-room-addEdit').modal('show');
    $('.formType').text('Edit');
    $('.status option').removeAttr('selected');

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/singleProduct`,
      data: {
        editId
      },
      success: function({ success, result: { title, description, price, status } }) {
        if (success) {
          $('.name').val(title);
          $('.desc').val(description);
          $('.price').val(price);
          $('.status').val(status);
        }
      }
    });
  });

  $(".addRoom").click(function () {
    editId = '';
    $('.formType').text('Save');
    $('#product-room-addEdit').modal('show');
  });

  $('.addEditForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/addEditProd`,
      data: {
        name: $('.name').val(),
        desc: $('.desc').val(),
        price: $('.price').val(),
        status: $('.status').val(),
        editId: editId
      },
      success: function({ success }) {
        items();
        $('#product-room-addEdit').modal('hide');
        $('.name').val('');
        $('.desc').val('');
        $('.price').val('');
        $('.status').val('');
        if (success) {
          $.toast({
            heading: 'Success',
            text: editId ? 'Item was updated' : 'Item was added',
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
        }
      }
    });
  });

  function convertDate(mySQLDate) {
    const newDate = Date(Date.parse(mySQLDate.replace('-','/','g')));
    return moment(newDate).format('MMMM DD, YYYY');
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
});