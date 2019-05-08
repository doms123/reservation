<?php $this->load->view('shared/header'); ?>
<?php $this->load->view('shared/nav'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/calendar.css');?>">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Calendar</h1>
  </section>

  <!-- Main content -->
  <section class="content" data-page="calendar">
    <div class="row">
      <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('shared/footer'); ?>
<script src="<?php echo base_url('assets/js/calendar.js'); ?>"></script>
