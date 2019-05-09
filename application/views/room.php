<?php $this->load->view('shared/header'); ?>
<?php $this->load->view('shared/nav'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/room.css');?>">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Rooms</h1>
  </section>

  <!-- Main content -->
  <section class="content" data-page="room">
    <div class="row mb20">
      <div class="col-xs-12">
        <button type="button" class="btn btn-primary btn-sm addRoom" data-toggle="modal"><i class="fa fa-plus"></i> Add New Room</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive no-padding">
            <div class="box-header">
              <h3 class="box-title">Room Type Details</h3>
            </div>
            <table class="roomTbl table table-hover">
              <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
                <th>Price</th>
                <th>Room Count</th>
                <th>Maximum Guests</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody class="roomTbody">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-room-addEdit">
      <div class="modal-dialog">
        <form action="<?php echo base_url('Main/addEditRoom'); ?>" class="fileupload" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title"><span class="formType"></span> Room Type</h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <label for="roomTypeImage">Room Type Image</label>
                <div class="dropzone" id="myDropzone"></div>
                <div class="form-group">
                  <label for="roomType">Room Name</label>
                  <input type="text" class="form-control name" placeholder="Input room name">
                </div>
                <div class="form-group">
                  <label for="roomType">Room Type</label>
                  <select class="form-control roomType">
                    <option value="Family suite">Family suite</option>
                    <option value="Premier suite">Premier suite</option>
                    <option value="Deluxe">Deluxe</option>
                  </select>
                  <!-- <input type="text" class="form-control name" placeholder="Input type of room"> -->
                </div>
                <div class="form-group">
                  <label for="roomType">Room Type Description</label>
                  <textarea class="form-control desc" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                  <label for="roomPrice">Price</label>
                  <input type="number" class="form-control price" placeholder="Input price of the room">
                </div>
                <div class="form-group">
                  <label for="totalNumberOfRoom">Total number of room for this type</label>
                  <input type="number" class="form-control roomCount" placeholder="Input total number of the room">
                </div>
                <div class="form-group">
                  <label for="maxGuestsPerRoom">Maximum number of guests</label>
                  <input type="number" class="form-control guestCount" id="maxGuestsPerRoom" placeholder="Input maximum number of guests">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left closeBtn" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary addRoomBtn" id="submit-all"><span class="formType"></span></button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="modal-room-delete">
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
            <button type="submit" class="btn btn-primary deleteRoomBtn">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('shared/footer'); ?>
<script src="<?php echo base_url('assets/js/room.js'); ?>"></script>
