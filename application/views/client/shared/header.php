<!DOCTYPE html>
<html>
  <head>
    <title>Hacienda Galea</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dropzone.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/toast.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fullcalendar.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/quill.snow.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/quill.bubble.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/slick.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/justifiedGallery.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lightgallery.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/default.css'); ?>" />
  </head>
<body class="agileinfo" id="reservation-page" data-url="<?php echo base_url('Admin'); ?>">
  <header class="header sticky-header">
    <div class="top-bar">
      <div class="container">
        <a href="tel:09173179720"><i class="fa fa-phone" aria-hidden="true"></i> 09173179720</a>
        <a href="tel:09338121437"><i class="fa fa-phone" aria-hidden="true"></i> 09338121437</a>
      </div>
    </div>
    <div class="container clear">
      <a href="<?php echo base_url();?>" class="logo"><img src="<?php echo base_url('assets/images/logo.png');?>" alt=""></a>
      <input class="menu-btn" type="checkbox" id="menu-btn" />
      <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
      <ul class="menu">
        <li class="home"><a href="<?php echo base_url();?>">Home</a></li>
        <li class="reservation"><a href="<?php echo base_url('Main/booking');?>">Reservation</a></li>
        <li class="gallery"><a href="<?php echo base_url('Main/gallery');?>">Gallery</a></li>
        <li><a href="#" class="orderBtn">Order Here</a></li>
        <li class="contact"><a href="<?php echo base_url('Main/contact');?>">Contact Us</a></li>
      </ul>
    </div>
  </header>