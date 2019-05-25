<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main extends CI_Controller {
  public function index() {
    $this->load->view('client/index');
  }

  // public function order() {
  //   $this->load->view('client/order');
  // }

  public function booking() {
    $this->load->view('client/reservation');
  }

  public function gallery() {
    $this->load->view('client/gallery');
  }

  public function contact() {
    $this->load->view('client/contact');
  }
}