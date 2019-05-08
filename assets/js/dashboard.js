$(document).ready(function() {
  const baseUrl = $('body').attr('data-url');
  let allBook;
  let allOrder;
  bookCount();
  function bookCount() {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/bookList`,
      data: { },
      success: function({ result, success }) {
        const bookTotalCount = result.length;
        $('.bookCount').text(bookTotalCount);
      }
    });
  }

  roomCount();
  function roomCount() {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}/allRooms`,
      data: {},
      success: function ({ result, imgArr, success }) {
        const roomTotalCount = result.length;
        $('.roomCount').text(roomTotalCount);        
      }
    })
  }

  orderCount();
  function orderCount(orderId) {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/orderCount`,
      data: {
        orderId,
      },
      success: function ({ success, count }) {
        $('.orderCount').text(count);     
      }
    });
  }

  productCount();
  function productCount() {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}/items`,
      data: {},
      success: function ({ result, success }) {
        const productCount = result.length;
        $('.productCount').text(productCount);     
      }
    });
  }


  $('.searchFormBook').submit(function(e) {
    e.preventDefault();
    const searchTxtBook = $('.searchTxtBook').val();
    const newSearch = searchTxtBook.toLowerCase();
    const newResult = allBook.filter(function (el) {
      const bookNo = el.bookNo.toLowerCase();
      const roomName = el.roomName.toLowerCase();
      const price = el.price.toLowerCase();

      return bookNo.includes(newSearch) || 
             price.includes(newSearch) ||
             roomName.includes(newSearch);
    });

    const maxLoop = newResult.length;
    let html;
    let gTotal = 0;
    if (newSearch) {
      if (maxLoop) {
        for (let x = 0; x < maxLoop; x++) {
          html += `<tr>`;
            html += `<td>${newResult[x].bookNo}</td>`;
            html += `<td>${newResult[x].roomName}</td>`;
            html += `<td>${newResult[x].roomNo}</td>`;
            html += `<td>${convertDate(newResult[x].dateAdded)}</td>`;
            html += `<td>${numberWithCommas(newResult[x].price)}</td>`;
          html += `</tr>`;

          gTotal += Number(newResult[x].price);
        }

        $('.gTotal').show();
      } else {
        $('.gTotal').hide();
        html += '<tr><td style="text-align: left;">No booking report yet.</td></tr>';
      }

      $('.gTotalBook').text(numberWithCommas(gTotal));

      $('.bookRevenueTbody').html(html);
    } else {
      bookRevenue();
    }
  });

  bookRevenue();
  function bookRevenue() {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}/bookRevenue`,
      data: {},
      success: function ({ result, success }) {
        allBook = result;
        const maxLoop = result.length;
        let html;
        let gTotal = 0;
        if (success) {
          if (maxLoop) {
            for (let x = 0; x < maxLoop; x++) {
              html += `<tr>`;
                html += `<td>${result[x].bookNo}</td>`;
                html += `<td>${result[x].roomName}</td>`;
                html += `<td>${result[x].roomNo}</td>`;
                html += `<td>${convertDate(result[x].dateAdded)}</td>`;
                html += `<td>${numberWithCommas(result[x].price)}</td>`;
              html += `</tr>`;

              gTotal += Number(result[x].price);
            }

            $('.gTotal').show();
          } else {
            $('.gTotal').hide();
            html += '<tr><td style="text-align: left;">No booking report yet.</td></tr>';
          }

          $('.gTotalBook').text(numberWithCommas(gTotal));

          $('.bookRevenueTbody').html(html);
        }
      }
    });
  }


  $('.searchFormItem').submit(function(e) {
    e.preventDefault();
    const searchTxtItem = $('.searchTxtItem').val();
    const newSearch = searchTxtItem.toLowerCase();

    const newResult = allOrder.filter(function (el) {
      const title = el.title.toLowerCase();
      const price = el.price.toLowerCase();

      return title.includes(newSearch) || 
             price.includes(newSearch);
    });

    if (newSearch) {
      const maxLoop = newResult.length;
      let html;
      let gTotal = 0;

      if (maxLoop) {
        for (let x = 0; x < maxLoop; x++) {
          html += `<tr>`;
            html += `<td>${x + 1}</td>`;
            html += `<td>${newResult[x].title}</td>`;
            html += `<td>${newResult[x].quantity}</td>`;
            html += `<td>${convertDate(newResult[x].orderDate)}</td>`;
            html += `<td>${numberWithCommas(newResult[x].price)}</td>`;
          html += `</tr>`;

          gTotal += Number(newResult[x].price);
        }

        $('.gTotal').show();
      } else {
        $('.gTotal').hide();
        html += '<tr><td style="text-align: left;">No order report yet.</td></tr>';
      }

      $('.gTotalOrder').text(numberWithCommas(gTotal));

      $('.orderRevenueTbody').html(html);
    
    } else {
      orderRevenue();
    }
  });

  orderRevenue();
  function orderRevenue() {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}/orderRevenue`,
      data: {},
      success: function ({ result, success }) {
        allOrder = result;
        const maxLoop = result.length;
        let html;
        let gTotal = 0;
        if (success) {
          if (maxLoop) {
            for (let x = 0; x < maxLoop; x++) {
              html += `<tr>`;
                html += `<td>${x + 1}</td>`;
                html += `<td>${result[x].title}</td>`;
                html += `<td>${result[x].quantity}</td>`;
                html += `<td>${convertDate(result[x].orderDate)}</td>`;
                html += `<td>${numberWithCommas(result[x].price)}</td>`;
              html += `</tr>`;

              gTotal += Number(result[x].price);
            }

            $('.gTotal').show();
          } else {
            $('.gTotal').hide();
            html += '<tr><td style="text-align: left;">No order report yet.</td></tr>';
          }

          $('.gTotalOrder').text(numberWithCommas(gTotal));

          $('.orderRevenueTbody').html(html);
        }
      }
    });
  }

  $('.btnPrint').click(function() {
    window.print();
  });
  
  function convertDate(mySQLDate) {
    const newDate = Date(Date.parse(mySQLDate.replace('-','/','g')));
    return moment(newDate).format('MMMM DD, YYYY');
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
});