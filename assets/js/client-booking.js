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
      data: { checkIn, checkOut },
      success: function({ success, result }) {
        html = '';
        const maxLoop = result.length;
        $(".row-title").text('Results');
        if (maxLoop) {
          for(let x = 0; x < maxLoop; x++) {
            html += `<div class="two-col clear">`;
              html += `<div class="item-col no-bg no-pd float-lt">`;
                html += `<div class="slider">`;

                for (let y = 0; y < result[x].img.length; y++) {
                  html += `<div><img src="/reservation/uploads/${result[x].img[y]}" alt=""></div>`;
                }
                  
                html += `</div>`;
              html += `</div>`;
              html += `<div class="item-col float-rt">`;
                html += `<p class="type-of-room">${result[x].name}</p>`;
                html += `<p class="light-color">${result[x].description}</p>`;
                html += `<p class="red">Maximum of ${result[x].guestCount}pax per room</p>`;
                html += `<div class="clear mt30">`;
                  html += `<div class="float-lt">`;
                    html += `<p>PRICE<br><span class="room-charges-price bold">${formatMoney(result[x].price)}</span><br>per night</p>`;
                  html += `</div>`;
                  html += `<div class="float-rt">`;
                    html += `<div class="agileits-room-type">`;
                      html += `<label>Available Room</label>`;
                      html += `<select class="selectRoom" required="">`;
                        for (let z = 0; z < result[x].room.length; z++) {
                          html += `<option value="${result[x].room[z]}">Room ${result[x].room[z]}</option>`;
                        }
                      html += `</select>`;
                    html += `</div>`;
                  html += `</div>`;
                html += `</div>`;
                html += `<button type="button" data-id="${result[x].roomId}" data-room="${result[x].room[0]}" class="bookNow" disabled>Book Now</button>`;
              html += `</div>`;
            html += `</div>`;
          }
        } else {
          html += '<p>No result found!</p>';
        }
        
        
        $('.search-results .row').html(html);
        roomAvailable = result;
        console.log('checkInDate', checkInDate);
        console.log('checkOutDate', checkOutDate);
        if (checkInDate != checkOutDate) {
          console.log('defaultDate', defaultDate);
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

  $('.search-results').delegate('.bookNow', 'click', function() {
    const roomId = $(this).attr('data-id');
    const roomNo = $(this).attr('data-room');
    reserveRoomId = roomId;
    reserveRoomNo = roomNo;

    $('#modal-book-addEdit').modal('show');

    let cInDate = moment(checkInDate).format('dddd, MMMM DD YYYY');
    let cOutDate = moment(checkOutDate).format('dddd, MMMM DD YYYY');
    
    $('.roomCheckIn').text(cInDate);
    $('.roomCheckOut').text(cOutDate);

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/singleRoom`,
      data: { roomId },
      success: function({ data }) {
        if (data) {
          $('.roomName').html(data.name);
          $('.roomNo').html(roomNo);
          $('.guestCount').html(data.guestCount);
          $('.roomDesc').html(data.description);
          $('.roomPrice').html(formatMoney(Number(data.price) * Number(totalDay)));
          $('.nightCount').html(totalDay);
        }
      }
    });
  });

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
        checkIn: checkInDate,
        checkOut: checkOutDate,
        roomType: reserveRoomId,
        roomNo: reserveRoomNo,
      },
      success: function({ success, bookNo }) {
        $('.btnLabel').removeAttr('disabled');
        $('#modal-notes').modal('show');
        $('.bookingNo').text(bookNo);
        $('#modal-book-addEdit').modal('hide');
        $('.guestPaymentDetails input').val('');
        getRoomAvailable(checkInDate, checkOutDate);
      }
    });
  });
});