<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url('assets/images/photo.jpg'); ?>" class="img-circle" alt="Hacienda Galea">
      </div>
      <div class="pull-left info">
        <p>Admin</p>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li class="dashboard">
        <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a>
      </li>
      <li class="calendar">
        <a href="<?php echo base_url('admin/calendar'); ?>"><i class="fa fa-calendar"></i> <span>Calendar</span></a>
      </li>
      <li class="booking">
        <a href="<?php echo base_url('admin/booking'); ?>"><i class="fa fa-book"></i> <span>Booking</span></a>
      </li>
      <li class="room">
        <a href="<?php echo base_url('admin/room'); ?>"><i class="fa fa-hotel"></i> <span>Rooms</span></a>
      </li>
      <li class="order treeview">
        <a href=""><i class="fa fa-shopping-cart"></i> <span>Manage Order</span></a>
        <ul class="treeview-menu productTree">
          <li class="product"><a href="<?php echo base_url('admin/product'); ?>"><i class="fa fa-circle-o"></i>Products</a></li>
          <li class="order"><a href="<?php echo base_url('admin/order'); ?>"><i class="fa fa-circle-o"></i>Order</a></li>
        </ul>
      </li>
      <li class="contactMessage">
        <a href="<?php echo base_url('admin/contactMessage'); ?>"><i class="fa fa-envelope"></i> <span>Contact Messages</span></a>
      </li>
      <li>
        <a href="<?php echo base_url('admin/logout'); ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
      </li>
    </ul>
  </section>
</aside>