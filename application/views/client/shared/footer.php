  <div class="modal fade" id="modal-order-addEdit">
    <div class="modal-dialog">
      <form action="<?php echo base_url('Main/addEditRoom'); ?>" class="fileupload" enctype="multipart/form-data" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><span class="formType"></span> Order</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div style="text-align: right;">
                <button class="btn btn-primary btn-sm btnOrderHistory">Check Order History</button>
              </div>
              <div class="form-group">
                <label for="roomPrice">Booking no.</label>
                <input type="text" class="form-control bookNo" placeholder="Enter Booking no." required>
              </div>

              <div class="form-group">
                <label class="itemLabel">Choose Item</label>
                <select class="items form-control" required>
                  <option>Loading data...</option>
                </select>
              </div>

              <div class="form-group">
                <label for="roomPrice">Quantity</label>
                <input type="number" min="1" class="form-control quantity" placeholder="Enter quantity" required>
              </div>

              <button type="button" class="btn btn-primary btn-sm addCartBtn"><i class="fa fa-shopping-cart"></i> &nbsp;Add to cart</button>
              
              <div class="cartWrap">
                <div class="box-header">
                  <h4 class="box-title">Items Cart</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                  <table class="orderTbl table table-hover">
                    <thead>
                      <tr>
                        <th>Item no.</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="cartTbody">
                      <tr><td style="text-align: left;">No items yet.</td></tr>
                    </tbody>
                  </table>
                  <p class="gtWrap">Grand Total: Php <span class="grandTotal"></span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary saveOrderBtn" id="submit-all">Order</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modal-order-history">
    <div class="modal-dialog">
      <form class="historyForm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><span class="formType"></span> Order History</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="roomPrice">Enter your booking no. to view your order history</label>
                <input type="text" class="form-control bookNoHistory" placeholder="Enter Booking no." required>
              </div>
              <button class="btn btn-primary btn-sm">Submit</button>
              <div class="cartWrap">
                <div class="box-header">
                  <h4 class="box-title">Order List</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                  <table class="orderTbl table table-hover">
                    <thead>
                      <tr>
                        <th>Item no.</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody class="cartTbody">
                      <tr><td style="text-align: left;">No items yet.</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

<footer class="spmb40">
  © 2019 HACIENDA GALEA RESORT AND EVENTS PLACE. All rights reserved.
  <div class="cta-mobile"><a href="tel:09173179720"><i class="fa fa-mobile" aria-hidden="true"></i> Call now!</a></div>
</footer>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/fastclick.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dropzone.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/toast.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/moment.js');?>"></script>
    <script src="<?php echo base_url('assets/js/fullcalendar.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/quill.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/slick.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/lightgallery.js');?>"></script>
    <script src="<?php echo base_url('assets/js/lg-fullscreen.js');?>"></script>
    <script src="<?php echo base_url('assets/js/lg-thumbnail.js');?>"></script>
    <script src="<?php echo base_url('assets/js/lg-zoom.js');?>"></script>
    <script src="<?php echo base_url('assets/js/lg-autoplay.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.mousewheel.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.justifiedGallery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/common.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.full.min.js');?>"></script>
    <script>
      $(function() {

        $('.btnOrderHistory').click(function(e) {
          e.preventDefault();
          $('#modal-order-addEdit').modal('hide');
          $('#modal-order-history').modal('show');
          $('.bookNoHistory').val('');
          $('.cartTbody').html('<tr><td style="text-align: left;">No items yet.</td></tr>');
        });

        $('.orderBtn').click(function(e) {
          e.preventDefault();
          $('.bookNoHistory, .bookNo, .quantity').val('');
          $('#modal-order-addEdit').modal('show');
          $('.cartTbody').html('<tr><td style="text-align: left;">No items yet.</td></tr>');
          $('.gtWrap').hide();
        });

        const baseUrl = $('body').attr('data-url');
        let editId;
        let bookNoGlobal;
        let cartCount;
        let isbookNoValid;
        
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
                  html += `<tr><td style="text-align: left;">No items yet.</td></tr>`;
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

        $('.historyForm').submit(function(e) {
          e.preventDefault();
          let bookNo = $('.bookNoHistory').val();
          bookNoGlobal = bookNo;
          valiidateBookNoHistory(bookNo);
        });

        function valiidateBookNoHistory(bookNo) {
          $.ajax({
            type: 'POST',
            url: `${baseUrl}/validateBookNo`,
            data: {
              bookNo,
            },
            success: function ({ success }) {
              if (!success) {
                $('.cartTbody').html('<tr><td style="text-align: left;">No items yet.</td></tr>');
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
                loadCartHistory(bookNo);
              }
            }
          });
        }

        function loadCartHistory(bookNo) {
          $.ajax({
            type: 'POST',
            url: `${baseUrl}/loadCartHistory`,
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
                    let status;
                    if (result[x].orderStatus == 2) {
                      status = 'Pending';
                    } else if (result[x].orderStatus == 3) { 
                      status = 'Received';
                    } else if (result[x].orderStatus == 1) { 
                      status = 'In Cart';
                    } else { 
                      status = 'Cancelled';
                    }
                    let total = Number(result[x]['quantity']) * Number(result[x]['price']);
                    html += '<tr>';
                      html += `<td>${x + 1}</td>`;
                      html += `<td>${result[x]['title']}</td>`;
                      html += `<td>${result[x]['quantity']}</td>`;
                      html += `<td>${numberWithCommas(result[x]['price'])}</td>`;
                      html += `<td>${numberWithCommas(total)}</td>`;
                      html += `<td>${status}</td>`;
                    html += '<tr>';

                    grandTotal += total;
                  }

                } else {
                  html += `<tr><td style="text-align: left;">No items yet.</td></tr>`;
                }
                $('.cartTbody').html(html);
              }
            }
          });
        }

        function valiidateBookNo(bookNo) {
          $.ajax({
            type: 'POST',
            url: `${baseUrl}/validateBookNo`,
            data: {
              bookNo,
            },
            success: function ({ success }) {
              if (!success) {
                $('.cartTbody').html('<tr><td style="text-align: left;">No items yet.</td></tr>');
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
                  $('.cartTbody').html('<tr><td style="text-align: left;">No items yet.</td></tr>');
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

        function convertDate(mySQLDate) {
          const newDate = Date(Date.parse(mySQLDate.replace('-','/','g')));
          return moment(newDate).format('MMMM DD, YYYY');
        }

        function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
      });

      // Prevent right click
      document.addEventListener('contextmenu', event => event.preventDefault());

      $(document).keydown(function (event) {
          if (event.keyCode == 123) { // Prevent F12
              return false;
          } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
              return false;
          }
      });
    </script>
</body>
</html>