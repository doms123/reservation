<?php $this->load->view('shared/header'); ?>
<?php $this->load->view('shared/nav'); ?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/contact-message.css');?>">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Contact Messages</h1>
  </section>

  <section class="content" data-page="contactMessage">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding">
                <div class="box-header">
                  <h3 class="box-title">Room Type Details</h3>
                  <div class="box-tools">
                    <form class="searchForm">
                      <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" class="form-control pull-right searchTxt" placeholder="Search first name, last name, email, contact">
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact no.</th>
                    <th>Message</th>
                    <th>Date Added</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="contactTbody">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modal-contact-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Delete Contact Message</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary deleteBookBtn">Ok</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('shared/footer'); ?>
<script src="<?php echo base_url('assets/js/contact-message.js'); ?>"></script>
