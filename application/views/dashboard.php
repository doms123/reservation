<?php $this->load->view('shared/header'); ?>
<?php $this->load->view('shared/nav'); ?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/dashboard.css');?>">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Dashboard</h1>
  </section>

  <!-- Main content -->
  <section class="content" data-page="dashboard">
    <div class="row">
      <div class="col-md-12 no-print">
        <div class="row">
          <!-- <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 class="bookCount">0</h3>
                <p>Book Rooms</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
              <a href="<?php echo base_url('admin/booking');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="ion ion-calendar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Book Rooms</span>
                <span class="info-box-number bookCount"></span>
                <a href="<?php echo base_url('admin/booking');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

          <!-- <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3 class="roomCount">0</h3>
                <p>Available Rooms</p>
              </div>
              <div class="icon">
                <i class="ion ion-home"></i>
              </div>
              <a href="<?php echo base_url('admin/room');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="ion ion-home"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Available Rooms</span>
                <span class="info-box-number roomCount"></span>
                <a href="<?php echo base_url('admin/room');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

          <!-- <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3 class="messageCount">0</h3>
                <p>New Messages</p>
              </div>
              <div class="icon">
                <i class="ion ion-email"></i>
              </div>
              <a href="<?php echo base_url('admin/contactMessage');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="ion ion-email"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">New Messages</span>
                <span class="info-box-number roomCount"></span>
                <a href="<?php echo base_url('admin/contactMessage');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

          <!-- <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3 class="productCount">0</h3>
                <p>Available Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-cube"></i>
              </div>
              <a href="<?php echo base_url('admin/product');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
        </div>
      </div>
      <div class="col-md-12 bookingWrap">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Booking Revenue Report</h3>
            <div class="box-tools no-print">
              <form class="searchFormBook">
                <button type="button" class="btn btn-primary btn-sm btnPrintBook no-print"><i class="fa fa-print"></i> Print Reports</button>
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" class="form-control pull-right searchTxtBook" placeholder="Search book no., room, type, price">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Booking No.</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Room no.</th>
                  <th>Booking Date</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody class="bookRevenueTbody">
              </tbody>
            </table>
          </div>
          <p class="gTotalWrap">Grand Total: Php <span class="gTotalBook"></span></p>
        </div>
      </div>
      <!-- <div class="col-md-12 orderingWrap">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Ordering Revenue Report</h3>
            <div class="box-tools no-print">
              <form class="searchFormItem">
                <button type="button" class="btn btn-primary btn-sm btnPrintOrder no-print"><i class="fa fa-print"></i> Print Reports</button>
                <div class="input-group input-group-sm" style="width: 180px;">
                  <input type="text" class="form-control pull-right searchTxtItem" placeholder="Search item name, price">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Item No.</th>
                  <th>Item name</th>
                  <th>Quantity</th>
                  <th>Order Date</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody class="orderRevenueTbody">

              </tbody>
            </table>
          </div>
          <p class="gTotalWrap">Grand Total: Php <span class="gTotalOrder"></span></p>
        </div>
      </div> -->
    </div>
  </section>
</div>

<?php $this->load->view('shared/footer'); ?>
<script src="<?php echo base_url('assets/js/dashboard.js'); ?>"></script>
