<?php $this->load->view('shared/header'); ?>
<?php $this->load->view('shared/nav'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/order.css');?>">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Order List</h1>
  </section>

  <!-- Main content -->
  <section class="content" data-page="order">
    <div class="row mb20">
      <div class="col-xs-12">
        <button type="button" class="btn btn-primary btn-sm addOrder" data-toggle="modal"><i class="fa fa-plus"></i> Add New Order</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive no-padding">
            <div class="box-header">
              <h3 class="box-title">Order Details</h3>
              <div class="box-tools">
                <form class="searchForm">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" class="form-control pull-right searchTxt" placeholder="Search customer, booking no">
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <table class="orderTbl table table-hover tableOrder">
              <thead>
              <tr>
                <th>Customer</th>
                <th>Booking no.</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody class="orderTbody">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

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
                        <tr><td>No items yet.</td></tr>
                      </tbody>
                    </table>
                    <p class="gtWrap">Grand Total: Php <span class="grandTotal"></span></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary saveOrderBtn" id="submit-all"><span class="formType"></span></button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="modal-order">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Order</h4>
          </div>
          <div class="modal-body">
            <div>
              <label>Customer</label>
              <p class="customerName">Loading...</p>
            </div>
            <div>
              <label>Booking No.</label>
              <p class="bookingNo">Loading...</p>
            </div>
            <div>
                <div class="orderCartWrap">
                  <div class="box-header">
                    <h4 class="box-title">Orders</h4>
                  </div>
                  <div class="box-body table-responsive no-padding">
                    <table class="orderListTbl table table-hover">
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
                      <tbody class="orderListTbody">
                        <tr><td>No items yet.</td></tr>
                      </tbody>
                    </table>
                    <p class="gtWrap">Grand Total: Php <span class="grandTotal"></span></p>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('shared/footer'); ?>
<script src="<?php echo base_url('assets/js/order.js'); ?>"></script>
