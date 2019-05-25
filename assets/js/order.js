$(function() {
  const baseUrl = $('body').attr('data-url');
  let editId;
  let bookNoGlobal;
  let cartCount;
  let isbookNoValid;
  let allOrders;
  
  $('.addOrder').click(function() {
    editId = '';
    $('.formType').text('Submit');
    $('#modal-order-addEdit').modal('show');
  });

  $(window).resize(function () {
    $(".items").select2();
  });

  items();
  function items() {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/items`,
      success: function ({ success, result }) {
      html = '';
        if (success) {
          if (result.length) {
            var maxLoop = result.length;
            for (var x = 0; x < maxLoop; x++) {
              html += `<option value="${result[x].productId}">${result[x].title}</option>`;
            }
          }
        }
        $(".items").html(html);

        setTimeout(function() {
          $(".items").select2();
        }, 400);
      }
    });
  }

  $('.addCartBtn').click(function() {
    let bookNo    = $('.bookNo').val();
    let item      = $('.items').val();
    let quantity  = $('.quantity').val();

    if (bookNo && item && quantity) {
      if (isbookNoValid) {
        $.ajax({
          type: 'POST',
          url: `${baseUrl}/addCart`,
          data: {
            bookNo,
            item,
            quantity
          },
          success: function ({ success }) {
            if (success) {
              $.toast({
                heading: 'Success',
                text: 'Item was added to your cart!',
                icon: 'success',
                loader: false,
                position: 'bottom-center'
              });

              loadCart(bookNo);
            }
          }
        });
      } else {
        $.toast({
          heading: 'Error',
          text: 'Invalid book no.',
          icon: 'error',
          loader: false,
          position: 'bottom-center'
        });
      }
    } else {
      $.toast({
        heading: 'Error',
        text: 'All fields are required',
        icon: 'error',
        loader: false,
        position: 'bottom-center'
      });
    }
  });

  function loadCart(bookNo) {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/loadCart`,
      data: {
        bookNo,
      },
      success: function ({ success, result }) {
        let html = '';
        let grandTotal = 0;
        if (success) {
          if (result.length) {
            const maxLoop = result.length;
            cartCount = maxLoop;
            for (let x = 0; x < maxLoop; x++) {
              let total = Number(result[x]['quantity']) * Number(result[x]['price']);
              html += '<tr>';
                html += `<td>${x + 1}</td>`;
                html += `<td>${result[x]['title']}</td>`;
                html += `<td>${result[x]['quantity']}</td>`;
                html += `<td>${numberWithCommas(result[x]['price'])}</td>`;
                html += `<td>${numberWithCommas(total)}</td>`;
                html += `<td class="cart-action-btn">`;
                  html += `<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${result[x].orderId}"><i class="fa fa-trash"></i> Delete</button>`;
                html += `</td>`;
              html += '<tr>';

              grandTotal += total;
            }

            $('.gtWrap').show();
          } else {
            html += `<tr><td>No items yet.</td></tr>`;
            $('.gtWrap').hide();
          }
          $('.grandTotal').text(numberWithCommas(grandTotal));
          $('.cartTbody').html(html);
        }
      }
    });
  }

  $('.cartTbody').delegate('.deleteBtn', 'click', function() {
    const deleteId = $(this).attr('data-id');
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/deleteItemCart`,
      data: {
        deleteId,
      },
      success: function ({ success }) {
        if (success) {
          $.toast({
            heading: 'Success',
            text: 'Item was deleted',
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
          loadCart(bookNoGlobal);
        }
      }
    });
  });

  $('.bookNo').blur(function() {
    let bookNo = $(this).val();
    bookNoGlobal = bookNo;
    valiidateBookNo(bookNo);
  });

  function valiidateBookNo(bookNo) {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/validateBookNo`,
      data: {
        bookNo,
      },
      success: function ({ success }) {
        if (!success) {
          $('.cartTbody').html('<tr><td>No items yet.</td></tr>');
          cartCount = 0;
          $('.gtWrap').hide();
          $.toast({
            heading: 'Error',
            text: 'Invalid booking no.',
            icon: 'error',
            loader: false,
            position: 'bottom-center'
          });
          isbookNoValid = false;
        } else {
          isbookNoValid = true;
          loadCart(bookNo);
        }
      }
    });
  }

  $('.saveOrderBtn').click(function() {
    if (cartCount) {
      $.ajax({
        type: 'POST',
        url: `${baseUrl}/saveOrder`,
        data: {
          bookNo: bookNoGlobal,
        },
        success: function ({ success }) {
          if (success) {
            $('.bookNo').val('');
            $('.items').val('');
            $('.quantity').val('');
            $('#modal-order-addEdit').modal('hide');
            $('.cartTbody').html('<tr><td>No items yet.</td></tr>');
            cartCount = 0;
            $('.gtWrap').hide();
            bookNoGlobal = 0;
            $.toast({
              heading: 'Success',
              text: 'Order was added',
              icon: 'success',
              loader: false,
              position: 'bottom-center'
            });
            loadOrder();
          }
        }
      });
    } else {
      $.toast({
        heading: 'Error',
        text: 'No items in your cart',
        icon: 'error',
        loader: false,
        position: 'bottom-center'
      });
    }
  });

  $('.searchForm').submit(function(e) {
    e.preventDefault();
    const searchTxt = $('.searchTxt').val();
    const newSearch = searchTxt.toLowerCase();
    const newResult = allOrders.filter(function (el) {
      const guestName = el.guestName.toLowerCase();
      const bookNo = el.bookNo.toLowerCase();
      return guestName.includes(newSearch) || 
            bookNo.includes(newSearch);
    });

    if (newSearch) {
      let html = '';
      if (newResult.length) {
        const maxLoop = newResult.length;
        for (let x = 0; x < maxLoop; x++) {
          if (newResult[x]['totalPendingOrder'] > 0) {
            html += '<tr>';
              html += `<td>${newResult[x]['guestName']}</td>`;
              html += `<td>${newResult[x]['bookNo']}</td>`;
              html += `<td>${convertDate(newResult[x]['orderDate'])}</td>`;
              html += `<td><span class="orderCount">${newResult[x]['totalPendingOrder']}</span> Pending order</td>`;
              html += `<td class="cart-action-btn">`;
                html += `<button type="button" class="btn btn-primary btn-sm orderBtn" data-id="${newResult[x].orderId}" data-customer="${newResult[x].guestName}" data-bookno="${newResult[x].bookNo}"><i class="fa fa-shopping-cart"></i> &nbsp;Manage Order</button>`;
              html += `</td>`;
            html += '<tr>';
          }
        }
      } else {
        html += `<tr><td style="text-align: left;">No orders yet.</td></tr>`;
      }

      $('.orderTbody').html(html);
    } else {
      loadOrder();
    }
  });

  loadOrder();
  function loadOrder() {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/loadOrder`,
      success: function ({ success, result }) {
        allOrders = result;
        let html = '';
        let hasRecord = false;
        if (success) {
          if (result.length) {
            const maxLoop = result.length;
            for (let x = 0; x < maxLoop; x++) {
              if (result[x]['totalPendingOrder'] > 0) {
                html += '<tr>';
                  html += `<td>${result[x]['guestName']}</td>`;
                  html += `<td>${result[x]['bookNo']}</td>`;
                  html += `<td>${convertDate(result[x]['orderDate'])}</td>`;
                  html += `<td><span class="orderCount">${result[x]['totalPendingOrder']}</span> Pending order</td>`;
                  html += `<td class="cart-action-btn">`;
                    html += `<button type="button" class="btn btn-primary btn-sm orderBtn" data-id="${result[x].orderId}" data-customer="${result[x].guestName}" data-bookno="${result[x].bookNo}"><i class="fa fa-shopping-cart"></i> &nbsp;Manage Order</button>`;
                  html += `</td>`;
                html += '<tr>';

                hasRecord = true;
              }
            }
          }

          if (!hasRecord) {
            html += `<tr><td style="text-align: left;">No orders yet.</td></tr>`;
          }
          $('.orderTbody').html(html);
        }
      }
    });
  }

  $('.orderTbody').delegate('.orderBtn', 'click', function() {
    $('#modal-order').modal('show');
    const orderId = $(this).attr('data-id');
    const customer = $(this).attr('data-customer');
    const bookno = $(this).attr('data-bookno');

    $('.customerName').text(customer);
    $('.bookingNo').text(bookno);
    orderList(orderId);
  });

  function orderList(orderId) {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/orderList`,
      data: {
        orderId,
      },
      success: function ({ success, result }) {
        let html = '';
        let grandTotal = 0;
        if (success) {
          if (result.length) {
            const maxLoop = result.length;
            cartCount = maxLoop;
            for (let x = 0; x < maxLoop; x++) {
              let total = Number(result[x]['quantity']) * Number(result[x]['price']);
              html += '<tr>';
                html += `<td>${x + 1}</td>`;
                html += `<td>${result[x]['title']}</td>`;
                html += `<td>${result[x]['quantity']}</td>`;
                html += `<td>${numberWithCommas(result[x]['price'])}</td>`;
                html += `<td>${numberWithCommas(total)}</td>`;
                html += `<td class="cart-action-btn">`;
                  html += `<button title="Click to complete" type="button" class="btn btn-success btn-sm btnComplete" data-id="${result[x].orderId}"><i class="fa fa-check"></i></button>`;
                  html += `<button title="Click to delete type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${result[x].orderId}"><i class="fa fa-trash"></i></button>`;
                html += `</td>`;
              html += '<tr>';

              grandTotal += total;
            }

            $('.gtWrap').show();
          } else {
            html += `<tr><td style="text-align: left;">No items yet.</td></tr>`;
            $('.gtWrap').hide();
          }
          $('.grandTotal').text(numberWithCommas(grandTotal));
          $('.orderListTbody').html(html);
        }
      }
    });
  }

  $('.orderListTbody').delegate('.btnComplete', 'click', function() {
    const orderId = $(this).attr('data-id');
    const isComplete = confirm('Are you sure you want to complete?');
    if (isComplete) {
      $.ajax({
        type: 'POST',
        url: `${baseUrl}/orderComplete`,
        data: {
          orderId,
        },
        success: function ({ success, result }) {
          if (success) {
            $.toast({
              heading: 'Success',
              text: 'Order was completed',
              icon: 'success',
              loader: false,
              position: 'bottom-center'
            });
            loadOrder();
            orderList(orderId);
          }
        }
      });
    }
  });

  $('.orderListTbody').delegate('.deleteBtn', 'click', function() {
    const orderId = $(this).attr('data-id');
    const isComplete = confirm('Are you sure you want to delete?');
    if (isComplete) {
      $.ajax({
        type: 'POST',
        url: `${baseUrl}/orderDelete`,
        data: {
          orderId,
        },
        success: function ({ success, result }) {
          if (success) {
            $.toast({
              heading: 'Success',
              text: 'Order was deleted',
              icon: 'success',
              loader: false,
              position: 'bottom-center'
            });
            loadOrder();
            orderList(orderId);
          }
        }
      });
    }
  });
  
  function convertDate(mySQLDate) {
    const newDate = Date(Date.parse(mySQLDate.replace('-','/','g')));
    return moment(newDate).format('MMMM DD, YYYY');
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
});
