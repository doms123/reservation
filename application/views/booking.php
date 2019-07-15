<?php $this->load->view('shared/header'); ?>
<?php $this->load->view('shared/nav'); ?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/booking.css');?>">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Book Summary</h1>
  </section>

  <section class="content" data-page="booking">
    <div class="row">
      <div class="col-md-12">
        <div class="row mb20">
          <div class="col-xs-12">
            <button type="button" class="btn btn-primary btn-sm bookBtn" data-toggle="modal"><i class="fa fa-plus"></i> Add new book</button>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding">
                <div class="box-header">
                  <h3 class="box-title">Room Type Details</h3>
                  <div class="box-tools">
                    <form class="searchForm">
                      <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" class="form-control pull-right searchTxt" placeholder="Search booking no, customer, contact, email, room, type">
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <table class="roomTbl table table-hover">
                  <thead>
                  <tr>
                    <th><input type="checkbox" class="checkAll" title="check/uncheck all"></th>
                    <th>Booking No.</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Room</th>
                    <th>Type</th>
                    <th>Room no.</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="bookTbody">
                  </tbody>
                </table>
              </div>
            </div>
            <div class="multipleBtns">
              <button class=" btn btn-primary btn-sm btnConfirmAll"><i class="fa fa-check"></i> Confirm (<span class="checkCounter">0</span>) items</button>
              <button class=" btn btn-warning btn-sm btnCancelAll"><i class="fa fa-times"></i> Cancel</button>
              <button class=" btn btn-danger btn-sm btnDeleteAll"><i class="fa fa-trash"></i> Delete (<span class="checkCounter">0</span>) items</button>
            </div>
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
                <h4 class="modal-title"><span class="modalTitle"></span></h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group">
                    <label for="guestName">Guest Name</label>
                    <input type="text" class="form-control guestName" placeholder="Input guest name" required>
                  </div>
                  <div class="form-group">
                    <label for="guestContact">Guest Contact Number</label>
                    <input type="text" class="form-control guestContact" id="numbersOnly" maxlength="11" placeholder="09XXXXXXXX" required>
                  </div>
                  <div class="form-group">
                    <label for="guestContact">Guest Email Address</label>
                    <input type="email" class="form-control guestEmail" placeholder="Input guest's Email address" required>
                  </div>
                  <div class="form-group">
                    <label>Check In:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right checkIn" id="datepicker-check-in" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Check Out:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right checkOut" id="datepicker-check-out" disabled required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Select Type of Room</label>
                    <select class="form-control select2 mb5 roomType" required></select>
                  </div>
                  <div class="form-group">
                    <label>Select Room number</label>
                    <select class="form-control select2 roomNo" disabled required></select>
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control select2 status" required>
                      <option value="0">Select Status</option>
                      <option value="1">Confirmed</option>
                      <option value="2">Pending</option>
                      <option value="3" class="cancelOption">Cancelled</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm btnLabel">Add Book</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal fade" id="modal-book-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Delete Book</h4>
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

      <div class="modal fade" id="modal-book-delete-multiple">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Delete Book (<span class="checkCounter">0</span>)</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary multipleBookAction" data-type="delete">Ok</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-book-confirm-multiple">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Confirm Book (<span class="checkCounter">0</span>)</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to confirm?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary multipleBookAction" data-type="confirm">Ok</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-book-cancel-multiple">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Cancel Book (<span class="checkCounter">0</span>)</h4>
            </div>
            <div class="modal-body">
              <p>Cancellation process: The system can only cancel the booking if the check-in date is 2 days or more later from the current date</p>
              <p>Are you sure you want to cancel?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary multipleBookAction" data-type="cancel">Ok</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('shared/footer'); ?>
<script src="<?php echo base_url('assets/js/booking.js'); ?>"></script>
