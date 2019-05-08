$(function() {
    let allContactArr;
    $('.menu .contact').find('a').addClass('active');
    const baseUrl = $('body').attr('data-url');

    $('.contactForm').submit(function(e) {
        e.preventDefault();
        const firstName = $('.firstName').val();
        const lastName = $('.lastName').val();
        const email = $('.email').val();
        const contact = $('#numbersOnly').val();
        const message = $('.message').val();

        $.ajax({
            type: 'POST',
            url: `${baseUrl}/addContact`,
            data: {
                firstName,
                lastName,
                email,
                contact,
                message
            },
            success: function ({ success }) {
                if (success) {
                    $.toast({
                        heading: 'Success',
                        text: 'Message sent',
                        icon: 'success',
                        loader: false,
                        position: 'bottom-center'
                    });

                    $('.contactForm input, .contactForm textarea').val('');
                }
            }
        });
    });


    $('.searchForm').submit(function(e) {
        e.preventDefault();
        const searchTxt = $('.searchTxt').val();
        const newSearch = searchTxt.toLowerCase();
        const newResult = allContactArr.filter(function (el) {
          const firstName = el.firstName.toLowerCase();
          const lastName = el.lastName.toLowerCase();
          const email = el.email.toLowerCase();
          const contact = el.contact.toLowerCase();
    
          return firstName.includes(newSearch) || 
                lastName.includes(newSearch) || 
                email.includes(newSearch) || 
                contact.includes(newSearch);
        });

        let html;
        if (newSearch) {
          if (newResult.length) {
            const maxLoop = newResult.length;
            for (let x = 0; x < maxLoop; x++) {
                html += `<tr>`;
                    html += `<td>${newResult[x].firstName}</td>`;
                    html += `<td>${newResult[x].lastName}</td>`;
                    html += `<td>${newResult[x].email}</td>`;
                    html += `<td>${newResult[x].contact}</td>`;
                    html += `<td>${newResult[x].message}</td>`;
                    html += `<td>${convertDate(newResult[x].dateAdded)}</td>`;
                    html += `<td><button class="btn btn-danger btn-sm btnDelete" data-id="${newResult[x].contactId}"><i class="fa fa-trash"></i> Delete</button></td>`;
                html += `</tr>`;
            }
          } else {
            html += `<tr><td style="text-align: left;">No contact message yet.</td></tr>`;
          }

          $('.contactTbody').html(html);
        } else {
            allContacts();
        }
    });

    allContacts();
    function allContacts() {
        $.ajax({
            type: 'POST',
            url: `${baseUrl}/allContacts`,
            success: function ({ success, result }) {
                allContactArr = result;
                if (success) {
                    let html = '';
                    if (result.length) {
                        const maxLoop = result.length;
                        for (let x = 0; x < maxLoop; x++) {
                            html += `<tr>`;
                                html += `<td>${result[x].firstName}</td>`;
                                html += `<td>${result[x].lastName}</td>`;
                                html += `<td>${result[x].email}</td>`;
                                html += `<td>${result[x].contact}</td>`;
                                html += `<td>${result[x].message}</td>`;
                                html += `<td>${convertDate(result[x].dateAdded)}</td>`;
                                html += `<td><button class="btn btn-danger btn-sm btnDelete" data-id="${result[x].contactId}"><i class="fa fa-trash"></i> Delete</button></td>`;
                            html += `</tr>`;
                        }
                    } else {
                        html += `<tr><td style="text-align: left;">No contact message yet.</td></tr>`;
                    }
                    
                    $('.contactTbody').html(html);
                }
            }
        });
    }

    $('.contactTbody').delegate('.btnDelete', 'click', function() {
        const deleteId = $(this).attr('data-id');
        $('#modal-contact-delete').modal('show').attr('data-id', deleteId);
    });

    $('.deleteBookBtn').click(function() {
        const deleteId = $('#modal-contact-delete').attr('data-id');
        $.ajax({
            type: 'POST',
            url: `${baseUrl}/deleteContact`,
            data: {
                deleteId
            },
            success: function ({ success }) {
                allContacts();
                $.toast({
                    heading: 'Success',
                    text: 'Contact message was deleted',
                    icon: 'success',
                    loader: false,
                    position: 'bottom-center'
                });

                $('#modal-contact-delete').modal('hide');
            }
        });
    });

    function convertDate(mySQLDate) {
        const newDate = Date(Date.parse(mySQLDate.replace('-','/','g')));
        return moment(newDate).format('MMMM DD, YYYY');
    }
  });