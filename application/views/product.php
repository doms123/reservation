<?php $this->load->view('shared/header'); ?>
<?php $this->load->view('shared/nav'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/product.css');?>">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Products</h1>
  </section>

  <!-- Main content -->
  <section class="content" data-page="product">
    <div class="row mb20">
      <div class="col-xs-12">
        <button type="button" class="btn btn-primary btn-sm addRoom" data-toggle="modal"><i class="fa fa-plus"></i> Add New Item</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive no-padding">
            <div class="box-header">
              <h3 class="box-title">Item details</h3>
                <div class="box-tools">
                  <form class="searchForm">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" class="form-control pull-right searchTxt" placeholder="Search item, description, price">
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
            <table class="prodTbl table table-hover">
              <thead>
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Date Added</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody class="prodTbody">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="product-room-addEdit">
      <div class="modal-dialog">
        <form class="addEditForm" enctype="multipart/form-data" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title"><span class="formType"></span> Item</h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="roomType">Name</label>
                  <input type="text" class="form-control name" placeholder="Enter Item Name" required>
                </div>
                <div class="form-group">
                  <label for="roomType">Description</label>
                  <textarea class="form-control desc" cols="30" rows="10" placeholder="Enter Item Description" required></textarea>
                </div>
                <div class="form-group">
                  <label for="roomPrice">Price</label>
                  <input type="number" min="1" class="form-control price" placeholder="Enter Item Price" required>
                </div>
                <div class="form-group">
                  <label for="totalNumberOfRoom">Status</label>
                  <select class="status form-control input-sm">
                    <option value="1">In Stock</option>
                    <option value="2">Out of Stock</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left closeBtn" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary addProdBtn" id="submit-all"><span class="formType"></span></button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="modal-prod-delete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Delete Item</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary deleteItemBtn">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('shared/footer'); ?>
<script src="<?php echo base_url('assets/js/product.js'); ?>"></script>
