<?php $this->load->view('client/shared/header'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/client-booking.css');?>">

  <div class="content overlay">
    <h1 class="agile-head text-center">Reservation</h1>
    <div class="container">
      <div class="inner white">
        <div class="text-right btnWrap01">
          <button class="bookNowBtn" disabled><i class="fa fa-calendar"></i> Book now <span class="bookCountWrap">(<span class="bookCount">0</span>) <span class="roomTxt"></span></span></button>
        </div>
        <div class="text-left btnWrap02">
          <button class="reserveCalendar"><i class="fa fa-calendar"></i> View Reservation Calendar</button>
        </div>
        <div class="text-left btnWrap02">
          <button class="reserveHistory"><i class="fa fa-calendar"></i> Reservation History</button>
        </div>
        <div class="clearing"></div>
        <form action="#" method="post" class="agile_form">
          <div class="checkin agileits-left">
            <label>Check in</label>
            <input placeholder="dd/mm/yyyy" class="date checkIn" id="datepicker1" type="text" />
          </div>
          <div class="checkin agileits-right">
            <label>Check out</label>
            <input placeholder="dd/mm/yyyy" class="date checkOut" id="datepicker2" type="text" />
          </div>
          <div class="clear"></div>
          <div class="search-results">
            <p class="row-title">Select a date for reservation</p>
            <div class="row">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-book-addEdit">
    <div class="modal-dialog">
      <form class="addEditBookForm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><span class="modalTitle">Rooms Booking</span></h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="reservationDetails row">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Room Name</th>
                        <th>Room No.</th>
                        <th>Number of Guest</th>
                        <th>Check In (from 14:00)</th>
                        <th>Check Out (until 11:00)</th>
                        <th>Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="bookList">
                    </tbody>
                  </table>
                  <p class="gTotalWrap">Grand Total: Php <span class="gTotalBook"></span></p>
                </div>
              </div>
              <div class="guestPaymentDetails">
                <h4>Guest and Payment Details</h4>
                <div class="form-group">
                  <label for="guestName">Guest Name</label>
                  <input type="text" class="form-control guestName" placeholder="Input guest name" required>
                </div>
                <div class="form-group">
                  <label for="guestContact">Guest Contact Number</label>
                  <input type="text" class="form-control guestContact" id="numbersOnly" maxlength="11" placeholder="09XXXXXXXXX" required>
                </div>
                <div class="form-group">
                  <label for="guestContact">Guest Email Address</label>
                  <input type="email" class="form-control guestEmail" placeholder="Input guest's Email address" required>
                </div>
              </div>
              <div class="guestPaymentDetails">
                <h4>Room charges</h4>
                <strong>Php <span class="roomPrice"></span></strong>
              </div>
              <div class="bookingPolicy">
                <h4>Booking Policies</h4>
                <p><strong>Cancellation:</strong> If cancelled, modified or no show, the full booking item amount will be charged.</p>
                <p><strong>Payment:</strong> Full booking item amount will be charged.</p>
                <p><strong>Meal included:</strong> Breakfast included</p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="bookNow btnLabel">Book</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modal-notes">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btnRefresh" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Reservation success!</h4>
        </div>
        <div class="modal-body">
          <p>Thank you for booking! Please wait for the email about the instructions of your booking request</p>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm btnRefresh">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-calendar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Reservation Calendar</h4>
        </div>
        <div class="modal-body">
          <div id="calendar"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
          <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-book-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Delete Room</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary deleteBookBtn">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-reserve-history">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btnRefresh" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Reservation History</h4>
        </div>
        <div class="modal-body">
          <p class="reserveNotes">Email Address</p>
          <form class="viewHistoryForm">
            <div class="form-group">
              <input type="text" class="form-control input sm historyEmail" placeholder="Enter email" required>
            </div>
            <button class="btn btn-primary btn-sm btnView"><i class="fa fa-eye"></i> View</button>
          </form>
          <div class="reservationHistory">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>Room Name</th>
                    <th>Room No.</th>
                    <th>Number of Guest</th>
                    <th>Check In (from 14:00)</th>
                    <th>Check Out (until 11:00)</th>
                    <th>Price</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody class="bookList">
                  <tr>
                    <td colspan="7">Please enter your email address to view your reservation history</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Ok</button>
        </div>
      </div>
    </div>
  </div>

<?php $this->load->view('client/shared/footer'); ?>
<script src="<?php echo base_url('assets/js/client-booking.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/calendar.js'); ?>"></script>
<script>
  $(function() {
    $('.menu .reservation').find('a').addClass('active');

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
</script>