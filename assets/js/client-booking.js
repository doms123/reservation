$(document).ready(function() {
  const baseUrl = $('body').attr('data-url');
  const dateToday = new Date();
  const defaultDate = (dateToday.getMonth() + 1) + '/' + dateToday.getDate() + '/' +  dateToday.getFullYear();
  let checkInDate = defaultDate;
  let checkOutDate = defaultDate;
  let totalDay = 1;
  let reserveRoomId;
  let reserveRoomNo;

  $("#datepicker1").datepicker({
    autoclose: true,
    minDate: 0,
    startDate: dateToday,
  }).on('change', function() {
    $('#datepicker2').datepicker('destroy');
    const tomorrow = new Date($('#datepicker1').val());
    tomorrow.setDate(tomorrow.getDate() + 1);
    $('#datepicker2').datepicker({
      autoclose: true,
      minDate: 0,
      startDate: tomorrow
    });
    $('#datepicker2').removeAttr('disabled');
  });

  $('.checkIn, .checkOut').change(function() {
    const checkIn = $('.checkIn').val();
    const checkOut = $('.checkOut').val();
    $('.roomNo').html('').attr('disabled', true);
    getRoomAvailable(checkIn, checkOut);

    checkInDate = checkIn;
    checkOutDate = checkOut;

    dateDiff(checkIn, checkOut);
  });


  getRoomAvailable(defaultDate, defaultDate);

  function getRoomAvailable(checkIn, checkOut) {
    $('.search-results .row').html('<p>Loading records, please wait...</p>');
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/availableRoom`,
      data: { checkIn, checkOut, isClient: true },
      success: function({ success, result, allRooms }) {
        let firstRes = result;

        for (let b = 0; b < allRooms.length; b++) {
          let index = firstRes.findIndex(x => x.name == allRooms[b].name);
          if (index === -1) {
            firstRes.push(allRooms[b]);
          }
        }
        html = '';
        const maxLoop = firstRes.length;
        $(".row-title").text('Results');
        if (maxLoop) {
          for(let x = 0; x < maxLoop; x++) {
            html += `<div class="two-col clear">`;
              html += `<div class="item-col no-bg no-pd float-lt">`;
                html += `<div class="slider">`;
                for (let y = 0; y < firstRes[x].img.length; y++) {
                  html += `<div><img src="/reservation/uploads/${firstRes[x].img[y]}" alt=""></div>`;
                }
                html += `</div>`;
              html += `</div>`;
              html += `<div class="item-col float-rt">`;
                html += `<p class="type-of-room">${firstRes[x].name}</p>`;
                html += `<p class="light-color">${firstRes[x].description}</p>`;
                html += `<p class="red">Maximum of ${firstRes[x].guestCount}pax per room</p>`;
                html += `<div class="clear mt30">`;
                  html += `<div class="float-lt">`;
                    html += `<p>PRICE<br><span class="room-charges-price bold">${formatMoney(firstRes[x].price)}</span><br>per night</p>`;
                  html += `</div>`;
                  html += `<div class="float-rt">`;
                    html += `<div class="agileits-room-type">`;
                    

                      if (firstRes[x].room) {
                        html += `<label>Available Room</label>`;
                        html += `<select class="selectRoom" required="">`;
                          for (let z = 0; z < firstRes[x].room.length; z++) {
                            html += `<option value="${firstRes[x].room[z]}">Room ${firstRes[x].room[z]}</option>`;
                          }
                        html += `</select>`;
                      } else {
                        html += `<label style="color: red;">No Available Room</label>`;
                      }



                    html += `</div>`;
                  html += `</div>`;
                html += `</div>`;
                if (firstRes[x].room) {
                  html += `<button type="button" data-id="${firstRes[x].roomId}" data-room="${firstRes[x].room[0]}" class="bookNow addBtn" disabled>Add</button>`;
                }
              html += `</div>`;
            html += `</div>`;
          }
        } else {
          html += '<p>No result found!</p>';
        }
        
        
        $('.search-results .row').html(html);
        roomAvailable = result;

        if (checkInDate != checkOutDate) {
          if (checkOutDate) {
            $('.bookNow').removeAttr('disabled');
          }
        }

        setTimeout(function() {
          $('.search-results .slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true
          });
        }, 400);
      }
    });
  }

  $('.search-results').delegate('.selectRoom', 'change', function() {
    const roomId = $(this).val();
    $(this).parents('.item-col').find('.bookNow').attr('data-room', roomId);
  });

  $('.search-results').delegate('.addBtn', 'click', function() {
    const roomId = $(this).attr('data-id');
    const roomNo = $(this).attr('data-room');
    $(this).attr('disabled', true).text('Adding...');

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/clientBook`,
      data: {
        guestName: '',
        guestContact: '',
        guestEmail: '',
        checkIn: checkInDate,
        checkOut: checkOutDate,
        roomType: roomId,
        roomNo: roomNo,
        isCart: true
      },
      success: function(data) {
        $.toast({
          heading: 'Success',
          text: 'Room has been added',
          icon: 'success',
          loader: false,
          position: 'bottom-center'
        });
        $(this).removeAttr('disabled').text('Add');
        getRoomAvailable(checkInDate, checkOutDate);
        reservationCart();
      }
    });
  });

  $('.bookNowBtn').click(function() {
    $('#modal-book-addEdit').modal('show');
    bookCart();
  });

  function bookCart() {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/bookCart`,
      success: function({ success, result }) {
        if (success) {
          let maxLoop = result.length;
          let html = '';

          if (maxLoop) {
            let gtotal = 0;
            for (let x = 0; x < maxLoop; x++) {
              html += `<tr>`;
                html += `<td>${result[x].name}</td>`;
                html += `<td>Room ${result[x].roomNo}</td>`;
                html += `<td>${result[x].guestCount}</td>`;
                html += `<td>${moment(result[x].checkIn).format('dddd, MMMM DD YYYY')}</td>`;
                html += `<td>${moment(result[x].checkOut).format('dddd, MMMM DD YYYY')}</td>`;
                html += `<td>${formatMoney(result[x].price)}</td>`;
                html += `<td><button type="button" data-id="${result[x].bookId}" class="btn btn-danger btn-sm btnDeleteRoom"><i class="fa fa-trash"></i> Delete</button></td>`;
              html += `</tr>`;

              gtotal += Number(result[x].price);
            }

            totalRoomCharge = formatMoney(gtotal);
            $('.gTotalBook').text(totalRoomCharge);
            $('.roomPrice').text(totalRoomCharge);
          } else {
            $('#modal-book-addEdit').modal('hide');
            reservationCart();
            getRoomAvailable(checkInDate, checkOutDate);
          }

          $('.reservationDetails .bookList').html(html);
        }
      }
    });
  }

  $('.reservationDetails').delegate('.btnDeleteRoom', 'click', function() {
    const bookId = $(this).attr('data-id');
    $('#modal-book-delete').attr('data-id', bookId).modal('show');
  });

  $('.deleteBookBtn').click(function() {
    const bookId = $('#modal-book-delete').attr('data-id');

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/deleteBookCart`,
      data: { bookId },
      success: function({ success }) {
        if (success) {
          bookCart();
          reservationCart();
          $('#modal-book-delete').modal('hide');
          $.toast({
            heading: 'Success',
            text: 'Room has been deleted',
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
        }
      }
    });
  });

  reservationCart();
  function reservationCart() {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/reservationCart`,
      data: {},
      success: function({ count }) {
        $('.bookCount').text(count);

        if (count) {
          $('.bookNowBtn').removeAttr('disabled');
          $('.bookCountWrap').show();
        } else {
          $('.bookNowBtn').attr('disabled', true);
          $('.bookCountWrap').hide();
        }

        if (count > 1) {
          $('.roomTxt').text('rooms');
        } else {
          $('.roomTxt').text('room');
        }
      }
    });
  }

  function formatMoney(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
      d = d == undefined ? "." : d,
      t = t == undefined ? "," : t,
      s = n < 0 ? "-" : "",
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
      j = (j = i.length) > 3 ? j % 3 : 0;
  
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
  };

  function dateDiff(day1, day2) {
    const date1 = new Date(day1);
    const date2 = new Date(day2);
    const diffTime = Math.abs(date2.getTime() - date1.getTime());
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    totalDay = diffDays;
  }

  $('.addEditBookForm').submit(function(e) {
    e.preventDefault();

    $.toast({
      heading: 'Information',
      text: 'Processing your request, please wait...',
      icon: 'info',
      loader: false,
      position: 'bottom-center',
    });

    $('.btnLabel').attr('disabled', true);

    const guestName     = $('.guestName').val();
    const guestContact  = $('.guestContact').val();
    const guestEmail    = $('.guestEmail').val();  

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/clientBook`,
      data: {
        guestName,
        guestContact,
        guestEmail,
        isCart: ''
      },
      success: function({ success, bookNo }) {
        $('.btnLabel').removeAttr('disabled');
        $('#modal-notes').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#modal-book-addEdit').modal('hide');
        $('.guestPaymentDetails input').val('');
        getRoomAvailable(checkInDate, checkOutDate);
        reservationCart();
      }
    });
  });

  $('.btnRefresh').click(function() {
    location.reload();
  });

  $('.reserveCalendar').click(function() {
    $('#modal-calendar').modal('show');
  });

  $('.reserveHistory').click(function() {
    $('#modal-reserve-history').modal('show');
  });

  $('.viewHistoryForm').submit(function(e) {
    e.preventDefault();
    reserveHistory();
  });

  function reserveHistory() {
    const email = $('.historyEmail').val();
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/reserveHistory`,
      data: { email },
      success: function({ success, result }) {
        if (success) {
          let maxLoop = result.length;
          let html = '';

          if (maxLoop) {
            for (let x = 0; x < maxLoop; x++) {
              let status;
              if (result[x].status == 1) {
                status = 'Confirmed';
              } else if (result[x].status == 2) {
                status = 'Pending';
              } else if (result[x].status == 3) {
                status = 'Cancelled';
              }
              html += `<tr>`;
                html += `<td>${result[x].name}</td>`;
                html += `<td>Room ${result[x].roomNo}</td>`;
                html += `<td>${result[x].guestCount}</td>`;
                html += `<td>${moment(result[x].checkIn).format('dddd, MMMM DD YYYY')}</td>`;
                html += `<td>${moment(result[x].checkOut).format('dddd, MMMM DD YYYY')}</td>`;
                html += `<td>${formatMoney(result[x].price)}</td>`;
                html += `<td>${status}</td>`;
              html += `</tr>`;
            }
          } else {
            html += '<tr><td colspan="7">No reservation history yet.</td></tr>';
          }

          $('.reservationHistory .bookList').html(html);
        }
      }
    });
  }
});