$(document).ready(function() {
  const baseUrl = $('body').attr('data-url');
  let editId = '';
  let roomAvailable;
  let allBook;

  $('.bookBtn').click(function() {
    $('.modalTitle').text('Add New Book');
    $('.btnLabel').text('Add Book');
    $('.addEditBookForm input').val('');
    $('.addEditBookForm select').val(1);
    $('#modal-book-addEdit').modal({
      backdrop: 'static',
      keyboard: false
    });
  });

  var dateToday = new Date();

  $("#datepicker-check-in").datepicker({
    autoclose: true,
    minDate: 0,
    startDate: dateToday,
  }).on('change', function() {
    $('#datepicker-check-out').datepicker('destroy');
    var tomorrow = new Date($('.checkIn').val());
    tomorrow.setDate(tomorrow.getDate() + 1);
    $('#datepicker-check-out').datepicker({
      autoclose: true,
      minDate: 0,
      startDate: tomorrow
    });
    $('#datepicker-check-out').removeAttr('disabled');
  });

  $('.addEditBookForm').submit(function() {
    const guestName     = $('.guestName').val();
    const guestContact  = $('.guestContact').val();
    const guestEmail    = $('.guestEmail').val();
    const checkIn       = $('.checkIn').val();
    const checkOut      = $('.checkOut').val();
    const roomType      = $('.roomType').val();
    const roomNo        = $('.roomNo').val();
    const status        = $('.status').val();

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/addEditBook`,
      data: {
        guestName,
        guestContact,
        guestEmail,
        checkIn,
        checkOut,
        roomType,
        roomNo,
        status,
        editId
      },
      success: function({ success }) {
        if (success) {
          const text = editId ? 'Record was saved' : 'Book was added';
          $.toast({
            heading: 'Success',
            text,
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
        }
        bookList();
        $('#modal-book-addEdit').modal('hide');
      }
    });

    
    return false;
  });

  roomType();
  function roomType() {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}/roomType`,
      data: { },
      success: function({ result, success }) {
        const maxLoop = result.length;
        let html;
        if (success) {
          html += '<option selected="selected" disabled>Select Type of Room</option>';
          for (let x = 0; x < maxLoop; x++) {
            html += `<option value="${result[x].roomId}">${result[x].name}</option>`;
          }
          $('.roomType').html(html);
        }
      }
    });
  }

  $('.roomType').change(function() {
    const selected = $('.roomType option:selected').text();

    if (roomAvailable) {
      for (let x = 0; x < roomAvailable.length; x++) {
        if (roomAvailable[x].name == selected) {
          let html = '';
          let maxLoop = roomAvailable[x]['room'].length;
          for (let y = 0; y < maxLoop; y++) {
            html += `<option value="${roomAvailable[x]['room'][y]}">Room ${roomAvailable[x]['room'][y]}</option>`;
          }
          $('.roomNo').html(html).removeAttr('disabled');
        }
      }
    }
  });

  $('.searchForm').submit(function(e) {
    e.preventDefault();
    const searchTxt = $('.searchTxt').val();
    const newSearch = searchTxt.toLowerCase();
    const newResult = allBook.filter(function (el) {
      const bookNo = el.bookNo.toLowerCase();
      const guestName = el.guestName.toLowerCase();
      const guestContact = el.guestContact.toLowerCase();
      const guestEmail = el.guestEmail.toLowerCase();
      const room = el.name.toLowerCase();
      const type = el.type.toLowerCase();

      return guestName.includes(newSearch) || 
            bookNo.includes(newSearch) || 
            guestContact.includes(newSearch) || 
            room.includes(newSearch) || 
            type.includes(newSearch) || 
            guestEmail.includes(newSearch);
    });


    let html;
    if (newSearch) {
      if (newResult.length) {
        const maxLoop = newResult.length;
        for (let x = 0; x < maxLoop; x++) {
          let status;
          if (newResult[x].status == 1) {
            status = 'Confirmed';
          } else if (newResult[x].status == 2) {
            status = 'Pending';
          } else if (newResult[x].status == 3) {
            status = 'Cancelled';
          }
          html += `<tr>`;
          html += `<td><input type="checkbox" class="checkBox" data-id="${newResult[x].bookId}"></td>`;
            html += `<td>${newResult[x].bookNo}</td>`;
            html += `<td>${newResult[x].guestName}</td>`;
            html += `<td>${newResult[x].guestContact}</td>`;
            html += `<td>${newResult[x].guestEmail}</td>`;
            html += `<td>${convertDate(newResult[x].checkIn)}</td>`;
            html += `<td>${convertDate(newResult[x].checkOut)}</td>`;
            html += `<td>${newResult[x].name}</td>`;
            html += `<td>${newResult[x].type}</td>`;
            html += `<td>Room ${newResult[x].roomNo}</td>`;
            html += `<td>${status}</td>`;
            html += `<td class="room-action-btn">`;
              html += `<button type="button" class="btn btn-info btn-sm editBtn" data-toggle="modal" data-id="${newResult[x].bookId}"><i class="fa fa-edit"></i> Edit</button>`;
              html += `<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${newResult[x].bookId}"><i class="fa fa-trash"></i> Delete</button>`;
          html += `</td>`;
          html += `</tr>`;
        }
      } else {
        html += '<tr><td style="text-align: left;">No book yet.</td></tr>';
      }
      $('.bookTbody').html(html);
    } else {
      bookList();
    }
  });

  bookList();
  function bookList() {
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/bookList`,
      data: { },
      success: function({ result, success }) {
        allBook = result;
        const maxLoop = result.length;
        let html;
        if (success) {
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
                html += `<td><input type="checkbox" class="checkBox" data-id="${result[x].bookId}"></td>`;
                html += `<td>${result[x].bookNo}</td>`;
                html += `<td>${result[x].guestName}</td>`;
                html += `<td>${result[x].guestContact}</td>`;
                html += `<td>${result[x].guestEmail}</td>`;
                html += `<td>${moment(result[x].checkIn).format('MM/DD/YYYY')}</td>`;
                html += `<td>${moment(result[x].checkOut).format('MM/DD/YYYY')}</td>`;
                html += `<td>${result[x].name}</td>`;
                html += `<td>${result[x].type}</td>`;
                html += `<td>Room ${result[x].roomNo}</td>`;
                html += `<td>${status}</td>`;
                html += `<td class="room-action-btn">`;
                  html += `<button type="button" class="btn btn-info btn-sm editBtn" data-toggle="modal" data-id="${result[x].bookId}"><i class="fa fa-edit"></i> Edit</button>`;
                  html += `<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${result[x].bookId}"><i class="fa fa-trash"></i> Delete</button>`;
              html += `</td>`;
              html += `</tr>`;
            }
          } else {
            html += '<tr><td style="text-align: left;">No book yet.</td></tr>';
          }

          $('.bookTbody').html(html);
        }
      }
    });
  }

  $('.bookTbody').delegate('.checkBox', 'click', function() {
    const checkCounter = $('.checkBox[type="checkbox"]:checked').length;
    if (checkCounter) {
      $('.checkCounter').text(checkCounter);
      $('.multipleBtns').show();
    } else {
      $('.multipleBtns').hide();
    }
  });

  $('.checkAll').click(function() {
    const isChecked = $(this).is(":checked");
    if (isChecked) {
      $('.checkBox').prop('checked', true);
      const checkCounter = $('.checkBox[type="checkbox"]:checked').length;
      $('.checkCounter').text(checkCounter);
      $('.multipleBtns').show();
    } else {
      $('.checkBox').prop('checked', false);
      $('.multipleBtns').hide();
    }
  });

  $('.btnDeleteAll').click(function() {
    $('#modal-book-delete-multiple').modal('show');
  });

  $('.btnConfirmAll').click(function() {
    $('#modal-book-confirm-multiple').modal('show');
  });

  $('.btnCancelAll').click(function() {
    $('#modal-book-cancel-multiple').modal('show');
  });

  $(".multipleBookAction").click(function() {
    const type = $(this).attr('data-type');
    let ids = [];
    $('.checkBox[type="checkbox"]:checked').each(function () {
      ids.push($(this).attr('data-id'));
    });
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/multipleBookAction`,
      data: { ids, type },
      success: function({ success }) {
        let text;
        if (type == 'confirm') {
          text = 'confirmed';
        } else if (type == 'delete') {
          text = 'deleted';
        } else if (type == 'cancel') {
          text = 'cancelled';
        }
        if (success) {
          bookList();
          $.toast({
            heading: 'Success',
            text: `Book has been ${text}`,
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
          $('#modal-book-confirm-multiple').modal('hide');
          $('#modal-book-cancel-multiple').modal('hide');
          $('#modal-book-delete-multiple').modal('hide');
          $('.multipleBtns').hide();
        }
      }
    });
  });



  $('.bookTbody').delegate('.editBtn', 'click', function() {
    const id = $(this).attr('data-id');
    editId = id;
    $('.modalTitle').text('Edit Record');
    $('.btnLabel').text('Save');
    $('#modal-book-addEdit').modal('show');
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/singleBook`,
      data: {
        editId
      },
      success: function({ result, success }) {
        const { guestName, guestContact, guestEmail, checkIn, checkOut, roomId, roomNo, status } = result[0];
        $('.guestName').val(guestName);
        $('.guestContact').val(guestContact);
        $('.guestEmail').val(guestEmail);
        $('#datepicker-check-in').val(checkIn).datepicker('update');
        $('#datepicker-check-out').val(checkOut).datepicker('update');
        $('.roomType option[value='+roomId+']').attr('selected','selected');
        $('.roomNo').html('<option value="'+roomNo+'">Room '+roomNo+'</option>');
        $('.status option[value="'+status+'"]').attr('selected','selected');
      }
    });
  });

  $('.bookTbody').delegate('.deleteBtn', 'click', function() {
    const id = $(this).attr('data-id');
    $('#modal-book-delete').attr('data-id', id).modal({
      backdrop: 'static',
      keyboard: false
    });
  });

  $(".deleteBookBtn").click(function() {
    const id = $('#modal-book-delete').attr('data-id');
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/deleteBook`,
      data: { id: id },
      success: function({ success }) {
        if (success) {
          bookList();
          $.toast({
            heading: 'Success',
            text: 'Book has been deleted',
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
          $('#modal-book-delete').modal('hide');
        }
      }
    });
  });

  $('.checkIn, .checkOut').change(function() {
    const checkIn = $('.checkIn').val();
    const checkOut = $('.checkOut').val();
    $('.roomNo').html('').attr('disabled', true);

    $.ajax({
      type: 'POST',
      url: `${baseUrl}/availableRoom`,
      data: { checkIn, checkOut },
      success: function({ success, result }) {
        html = '';
        html += '<option selected="selected" disabled>Select Type of Room</option>';
        const maxLoop = result.length;
        for(let x = 0; x < maxLoop; x++) {
          html += `<option value="${result[x].roomId}">${result[x].name}</option>`;
        }
        
        $('.roomType').html(html);
        roomAvailable = result;
      }
    });
  });

  function convertDate(mySQLDate) {
    const newDate = Date(Date.parse(mySQLDate.replace('-','/','g')));
    return moment(newDate).format('MMMM DD, YYYY');
  }

  // Restricts input for the given textbox to the given inputFilter.
  function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
    });
    });
  }

  setInputFilter(document.getElementById("numbersOnly"), function(value) {
    return /^\d*\.?\d*$/.test(value);
  });
});