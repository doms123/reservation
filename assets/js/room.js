Dropzone.autoDiscover = false;

$(document).ready(function() {
  const baseUrl = $('body').attr('data-url');
  let imageArr = [];
  let editId = 0;
  let allRooms;
  // const roomTable = $('#roomTbl').DataTable();

  $('#myDropzone').dropzone({
    url: `${baseUrl}/addEditRoom`,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 10,
    maxFiles: 10,
    maxFilesize: 10,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    init: function() {
      dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

      // for Dropzone to process the queue (instead of default form behavior):
      document.getElementById('submit-all').addEventListener('click', function(e) {
        // Make sure that the form isn't actually being sent.
        e.preventDefault();
        e.stopPropagation();
        dzClosure.processQueue();
      });

      //send all the form data along with the files:
      this.on('sendingmultiple', function(data, xhr, formData) {
        formData.append('name', $('.name').val());
        formData.append('desc', $('.desc').val());
        formData.append('price', $('.price').val());
        formData.append('roomCount', $('.roomCount').val());
        formData.append('guestCount', $('.guestCount').val());
        formData.append('editImgArr', JSON.stringify(imageArr));
        formData.append('editId', editId);
        formData.append('uploadImg', 1);
      });

      this.on('complete', function(file) { 
        dzClosure.removeFile(file);
      });

      this.on("addedfile", function(file) {
      });

      this.on("removedfile", function({ name }) {
        imageArr = imageArr && imageArr.filter((image) => {
          return image.name !== name;
        });
      });
      

      this.on('successmultiple', function () {
        $('.dz-preview').remove();
      });

      this.on("thumbnail", function(file, dataUrl) {
        $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
      }),

      this.on('success', function(file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
          this.removeAllFiles(true); 
          $('.name, .desc, .price, .roomCount, .guestCount').val('');
          $('#modal-room-addEdit').modal('hide');
          getRooms();
          let text = editId ? 'Room was saved' : 'Room was added';
          $.toast({
            heading: 'Success',
            text,
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
        }

        $('.dz-image').css({"width":"100%", "height":"auto"});
      });
    }
  });

  $(".addRoomBtn").click(function () {
    if (!dzClosure.getAcceptedFiles().length) {
      $.ajax({
        type: 'POST',
        url: `${baseUrl}/addEditRoom`,
        data: {
          name: $('.name').val(),
          desc: $('.desc').val(),
          price: $('.price').val(),
          roomCount: $('.roomCount').val(),
          guestCount: $('.guestCount').val(),
          editImgArr: imageArr,
          uploadImg: 0,
          editId: editId
        },
        success: function(data) {
          $('.name, .desc, .price, .roomCount, .guestCount').val('');
          $('#modal-room-addEdit').modal('hide');
          getRooms();
          let text = editId ? 'Room was saved' : 'Room was added';
          $.toast({
            heading: 'Success',
            text,
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
        }
      });
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

      return guestName.includes(newSearch) || 
            bookNo.includes(newSearch) || 
            guestContact.includes(newSearch) || 
            guestEmail.includes(newSearch);
    });
  });

  getRooms();
  function getRooms() {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}/allRooms`,
      data: {},
      success: function ({ result, imgArr, success }) {
        allRooms = { result, imgArr };
        if (success) {
          const maxLoop = result.length;
          let html = '';
          if (maxLoop) {
            for (let x = 0; x < maxLoop; x++) {
              html += '<tr>';
                html += `<td><img src="../uploads/${imgArr[x]}" width="100px"></td>`;
                html += `<td>${result[x]['name']}</td>`;
                html += `<td>${result[x]['description']}</td>`;
                html += `<td>${numberWithCommas(result[x]['price'])}</td>`;
                html += `<td>${result[x]['roomCount']}</td>`;
                html += `<td>${result[x]['roomId']}</td>`;
                html += `<td class="room-action-btn">`;
                  html += `<button type="button" class="btn btn-info btn-sm editBtn" data-toggle="modal" data-id="${result[x].roomId}"><i class="fa fa-edit"></i> Edit</button>`;
                  html += `<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${result[x].roomId}"><i class="fa fa-trash"></i> Delete</button>`;
                html += `</td>`;
              html += '<tr>';
            }
          } else {
            html += '<tr><td style="text-align: left;">No room yet.</td></tr>';
          }

          $(".roomTbody").html(html);
        }
      }
    })
  }

  $('body').delegate('.deleteBtn', 'click', function() {
    const deleteId = $(this).attr('data-id');
    $('#modal-room-delete').attr('data-id', deleteId).modal({
      backdrop: 'static',
      keyboard: false
    });
  });

  $(".deleteRoomBtn").click(function() {
    const deleteId = $('#modal-room-delete').attr('data-id');
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/deleteRoom`,
      data: { deleteId },
      success: function({ success }) {
        if (success) {
          getRooms();
          $.toast({
            heading: 'Success',
            text: 'Room has been deleted',
            icon: 'success',
            loader: false,
            position: 'bottom-center'
          });
          $('#modal-room-delete').modal('hide');
        }
      }
    })
  });

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  $('.roomTbody').delegate('.editBtn', 'click', function() {
    const currentUrl = `${window.location.hostname}${window.location.pathname}`;
    const editId = $(this).attr('data-id');
    window.location = `http://${currentUrl}?edit=${editId}`;
  });

  $('.addRoom').click(function() {
    const currentUrl = `${window.location.hostname}${window.location.pathname}`;
    window.location = `http://${currentUrl}?add=true`;
  });

  $(".close, .closeBtn").click(function() {
    const currentUrl = `${window.location.hostname}${window.location.pathname}`;
    window.location = `http://${currentUrl}`;
  });

  paramsArrEdit = window.location.search.substr(1).split('edit=');
  if (paramsArrEdit.length > 1) {
    editId = paramsArrEdit[1];
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/singleRoom`,
      data: { roomId: paramsArrEdit[1] },
      success: function ({ fileList, data: { name, description, price, roomCount, guestCount } }) {
        $.each(fileList, function(key,value) {
          imageArr.push({ name: value.name });
          image = { name: value.name, size: value.size };
          dzClosure.emit("addedfile", image);
          dzClosure.emit("thumbnail", image, `../uploads/${value.name}`);
        });

        $('.name').val(name)
        $('.desc').val(description)
        $('.price').val(price)
        $('.roomCount').val(roomCount)
        $('.guestCount').val(guestCount);
      }
    });

    $('#modal-room-addEdit').modal({
      backdrop: 'static',
      keyboard: false
    });
  }

  paramsArrAdd = window.location.search.substr(1).split('add=');
  if (paramsArrAdd.length > 1) {
    $('#modal-room-addEdit').modal({
      backdrop: 'static',
      keyboard: false
    });
  }

  if (editId) {
    $('.formType').text('Edit');
  } else {
    $('.formType').text('Add');
  }

  var quillEdit = new Quill('.desc', {
    theme: 'snow'
  });
});