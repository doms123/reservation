<?php $this->load->view('client/shared/header'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/client-booking.css');?>">

  <div class="content overlay">
    <h1 class="agile-head text-center">Reservation</h1>
    <div class="container">
      <div class="inner white">
        <div class="text-left">
          <button class="reserveCalendar"><i class="fa fa-calendar"></i> View Reservation Calendar</button>
        </div>
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
            <h4 class="modal-title"><span class="modalTitle">Room Reservation</span></h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="reservationDetails">
                <h4>Reservation Details</h4>
                <p><strong>Room Name:</strong> <span class="roomName"></span></p>
                <p><strong>Room Number:</strong> <span class="roomNo"></span></p>
                <p><strong>Number of Guest:</strong> <span class="guestCount"></span></p>
                <p><strong>Check-in:</strong> <span class="roomCheckIn"></span> from 14:00</p>
                <p><strong>Check-out:</strong> <span class="roomCheckOut"></span> until 11:00</p>
                <p><strong>Description: </strong><br><span class="roomDesc"></span></p>
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
                <p><span class="roomPrice"></span> for <span class="nightCount"></span> night(s)</p>
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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Reservation success!</h4>
        </div>
        <div class="modal-body">
          <p>Your booking number is</p>
          <p class="bookingNo"></p>
          <p>Thank you for booking! Please wait for the email about the instructions of your booking request</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
          <button type="button" data-dismiss="modal" class="btn btn-primary deleteBookBtn btn-sm">Ok</button>
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
          <button type="button" data-dismiss="modal" class="btn btn-primary deleteBookBtn btn-sm">Ok</button>
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