<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {
	public function index() {
    if ($this->session->userdata('isLogin')) {
      header('location: '.base_url('admin/dashboard'));
    }
		$this->load->view('login');
  }
  
  public function login() {
    $username   = sanitize($this->input->post('username'));
    $pass       = sanitize($this->input->post('pass'));
    $getLogin	  = $this->model->getLogin($username, $pass);

    if ($getLogin) {
      $this->session->set_userdata(array('isLogin' => true));
    }

    $data = array(
      'success' => $getLogin,
    );
    genJson($data);
  }

  public function dashboard() {
    auth($this->session->userdata('isLogin'));
    $this->load->view('dashboard');
  }

  public function contactMessage() {
    auth($this->session->userdata('isLogin'));
    $this->load->view('contact-message');
  }

  public function calendar() {
    auth($this->session->userdata('isLogin'));
    $this->load->view('calendar');
  }

  public function booking() {
    auth($this->session->userdata('isLogin'));
    $this->load->view('booking');
  }

  public function room() {
    auth($this->session->userdata('isLogin'));
    $this->load->view('room');
  }

  public function order() {
    auth($this->session->userdata('isLogin'));
    $this->load->view('order');
  }

  public function product() {
    auth($this->session->userdata('isLogin'));
    $this->load->view('product');
  }

  public function logout() {
    $this->session->sess_destroy();
    $this->load->view('login');
  }

	public function addEditRoom() {
    $name       = sanitize($this->input->post('name'));
    $type       = sanitize($this->input->post('type'));
    $desc       = $this->input->post('desc');
    $price      = sanitize($this->input->post('price'));
    $roomCount  = sanitize($this->input->post('roomCount'));
    $guestCount = sanitize($this->input->post('guestCount'));
    $editId     = sanitize($this->input->post('editId'));
    $imgArr     = [];
    $editImgArr = [];

    if (isset($_FILES['file']) && $_FILES['file']['name']) {
      $editImgArr = json_decode($_POST['editImgArr']);
    } else {
      $editImgArr = $_POST['editImgArr'];
    }

    if (count($editImgArr)) {
      foreach($editImgArr as $img) {
        if (isset($_FILES['file'])) {
          array_push($imgArr, $img->name);
        } else {
          array_push($imgArr, $img['name']);
        }
      }
    }

		if($_POST['uploadImg']) {
      $total = count($_FILES['file']['name']);

      for( $i = 0 ; $i < $total ; $i++ ) {
        $tmpFilePath = $_FILES['file']['tmp_name'][$i];

        if ($tmpFilePath != '') {
          $newFilePath = './uploads/' . $_FILES['file']['name'][$i];

          if(move_uploaded_file($tmpFilePath, $newFilePath)) {
           
          }
        }
      }

      $images = serialize($_FILES['file']['name']);

      if ($editId) {
        $allImages = array_merge($_FILES['file']['name'] , $imgArr);
        $getEditRoom	= $this->model->getEditRoom(serialize($allImages), $name, $desc, $price, $roomCount, $guestCount, $editId, $type);
      } else {
        $getAddRoom	= $this->model->getAddRoom($images, $name, $desc, $price, $roomCount, $guestCount, $type);
      }
     
      $data = array(
        'success' => 1,
      );
    } else {

      if ($editId) {
        $getEditRoom	= $this->model->getEditRoom(serialize($imgArr), $name, $desc, $price, $roomCount, $guestCount, $editId, $type);
      }

      $data = array(
        'success' => $getEditRoom,
      );
    }
    
    genJson($data);
  }
  
  public function allRooms() {
    $getAllRooms	= $this->model->getAllRooms();

    $imgArr = [];
    foreach($getAllRooms as $row) {
      $img = unserialize($row->img);
      array_push($imgArr, $img[0]);
    }

    $data = array(
      'success' => 1,
      'result' => $getAllRooms,
      'imgArr' => $imgArr 
    );

    genJson($data);
  }

  public function singleRoom() {
    $roomId       = sanitize($this->input->post('roomId'));
    $getSingleRoom	= $this->model->getSingleRoom($roomId);
    $targetDir    = './uploads/';
    $fileList     = [];
    $dir          = $targetDir;

    $imgArr = [];
    foreach($getSingleRoom as $row) {
      $img = unserialize($row->img);
      array_push($imgArr, $img);
    }

    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          if ($file != '' && $file != '.' && $file != '..') {
            $filePath = $targetDir.$file;
            if (!is_dir($filePath)) {
              $size = filesize($filePath);
              if (in_array($file, $imgArr[0])) {
                $fileList[] = array(
                  'name' => $file,
                  'size' => $size,
                  'path' => $filePath
                );
              }
            }
          }
        }
        closedir($dh);
      }
    }

    $data = array(
      'fileList' => $fileList,
      'data' => $getSingleRoom[0]
    );

    genJson($data);
  }

  public function deleteRoom() {
    $deleteId = sanitize($this->input->post('deleteId'));

    $getDeleteRoom	= $this->model->getDeleteRoom($deleteId);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function roomType() {
    $getRoomType	= $this->model->getRoomType();

    $data = array(
      'success' => 1,
      'result' => $getRoomType->result()
    );

    genJson($data);
  }

  public function roomNo() {
    $roomId = sanitize($this->input->post('roomId'));

    $getRoomNo	= $this->model->getRoomNo($roomId)->row()->roomCount;

    $data = array(
      'success' => 1,
      'result' => $getRoomNo
    );

    genJson($data);
  }

  public function addEditBook() {
    $bookNo       = randHash();
    $guestName    = sanitize($this->input->post('guestName'));
    $guestContact = sanitize($this->input->post('guestContact'));
    $guestEmail   = sanitize($this->input->post('guestEmail'));
    $checkIn      = sanitize(date("Y-m-d", strtotime($this->input->post('checkIn'))));
    $checkOut     = sanitize(date("Y-m-d", strtotime($this->input->post('checkOut'))));
    $roomType     = sanitize($this->input->post('roomType'));
    $roomNo       = sanitize($this->input->post('roomNo'));
    $status       = sanitize($this->input->post('status'));
    $editId       = sanitize($this->input->post('editId'));

    if ($status == 1) {
      $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'hhacienda8@gmail.com',
        'smtp_pass' => 'Pass123!',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
      );

      $this->load->library('email', $config);
      $this->email->from('hhacienda8@gmail.com', 'admin');
      $this->email->to('dominicksanchez30@gmail.com');
      $this->email->subject('Email test');


      $this->email->message('Test message');
      $this->email->set_newline("\r\n");

      $result = $this->email->send();
      $this->email->print_debugger();
    }
    
    if ($editId) {
      $getEditBook	= $this->model->getEditBook($guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status, $editId);
    } else {
      $getAddBook	= $this->model->getAddBook($bookNo, $guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status);
    }

    $data = array(
      'success' => 1,
      'mail' => $result,
      'debug' => $this->email->print_debugger()
    );

    genJson($data);
  }

  public function bookList() {
    $getBookList	= $this->model->getBookList();

    $data = array(
      'success' => 1,
      'result' => $getBookList->result()
    );

    genJson($data);
  }

  public function singleBook() {
    $editId = sanitize($this->input->post('editId'));
    $getBookList	= $this->model->getSingleBook($editId);

    $data = array(
      'success' => 1,
      'result' => $getBookList->result()
    );

    genJson($data);
  }

  public function deleteBook() {
    $id = sanitize($this->input->post('id'));
    $getDeleteBook	= $this->model->getDeleteBook($id);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function deleteBooks() {
    $ids = $this->input->post('ids');

    for($x = 0; $x < count($ids); $x++) {
      $getDeleteBook	= $this->model->getDeleteBook($ids[$x]);
    }

    $data = array(
      'success' => 1,
      '$ids' => $ids
    );

    genJson($data);
  }

  public function calendarList() {
    $getCalendarList	= $this->model->getBookList();

    $data = array(
      'success' => 1,
      'result' => $getCalendarList->result()
    );

    genJson($data);
  }

  public function availableRoom() {
    $checkIn = convertSlashDateToDash(sanitize($this->input->post('checkIn')));
    $checkOut = convertSlashDateToDash(sanitize($this->input->post('checkOut')));

    $getAvRoom	= $this->model->getAvailableRoom($checkIn, $checkOut);
    $getAllRooms = $this->model->getAllRooms();

    // GET the list of rooms with room no.
    $roomsArr = [];
    foreach($getAllRooms as $row) {
      $dataArr = [];
      for($x = 1; $x <= $row->roomCount; $x++) {
        $object = new stdClass();
        $object->name = $row->name;
        $object->roomId = $row->roomId;
        $object->roomNo = $x;
        $object->img = $row->img;
        $object->description = $row->description;
        $object->price = $row->price;
        $object->guestCount = $row->guestCount;
        $dataArr[] = $object;
      }

      array_push($roomsArr, $dataArr);
    }

    foreach($getAvRoom as $room) {
      for ($a = 0; $a < count($roomsArr); $a++) {
        for ($b = 0; $b < count($roomsArr[$a]); $b++) {
          $roomName = $room->name;
          $roomNo = $room->roomNo;
          if (isset($roomsArr[$a][$b])) {
            $reserveName = $roomsArr[$a][$b]->name;
            $reserveRoomNo = $roomsArr[$a][$b]->roomNo;

            if ($roomName == $reserveName && $roomNo == $reserveRoomNo) {
              $data = new stdClass();
              $data->name = '';
              $data->roomNo = 0;
              $roomsArr[$a][$b] = $data;
            }
          }
        }
      }
    }

    $newRoomArr = [];
    for ($d = 0; $d < count($roomsArr); $d++) {
      $object = new stdClass();
      $roomNoArr = [];
      for ($e = 0; $e < count($roomsArr[$d]); $e++) {
        if ($roomsArr[$d][$e]->name !== '') {
          $object->name = $roomsArr[$d][$e]->name;
          $object->img = unserialize($roomsArr[$d][$e]->img);
          $object->description = $roomsArr[$d][$e]->description;
          $object->price = $roomsArr[$d][$e]->price;
          $object->roomId = $roomsArr[$d][$e]->roomId;
          $object->guestCount = $roomsArr[$d][$e]->guestCount;
          array_push($roomNoArr, $roomsArr[$d][$e]->roomNo);
        }
      }

      if (count($roomNoArr)) {
        $object->room = $roomNoArr;
      }
     
      if (!empty((array) $object)) {
        array_push($newRoomArr, $object);
      }
    }


    $data = array(
      'success' => 1,
      'result' => $newRoomArr
    );

    genJson($data);
  }

  public function clientBook() {
    $bookNo       = randHash();
    $guestName    = sanitize($this->input->post('guestName'));
    $guestContact = sanitize($this->input->post('guestContact'));
    $guestEmail   = sanitize($this->input->post('guestEmail'));
    $checkIn      = sanitize(date("Y-m-d", strtotime($this->input->post('checkIn'))));
    $checkOut     = sanitize(date("Y-m-d", strtotime($this->input->post('checkOut'))));
    $roomType     = sanitize($this->input->post('roomType'));
    $roomNo       = sanitize($this->input->post('roomNo'));

    $insertId = $this->model->getAddBook($bookNo, $guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, 2);

    $getSingleBook = $this->model->getSingleBook($insertId);


    $data = array(
      'success' => 1,
      'bookNo' => $bookNo,
      'response' => $getSingleBook,
    );

    genJson($data);
  }

  public function items() {
    $getItems = $this->model->getItems();

    $data = array(
      'success' => 1,
      'result' => $getItems
    );

    genJson($data);
  }

  public function addEditProd() {
    $name    = sanitize($this->input->post('name'));
    $desc    = sanitize($this->input->post('desc'));
    $price   = sanitize($this->input->post('price'));
    $status  = sanitize($this->input->post('status'));
    $editId  = sanitize($this->input->post('editId'));


    $getAddEditProd = $this->model->getAddEditProd($name, $desc, $price, $status, $editId);

    $data = array(
      'success' => 1
    );

    genJson($data);
  }

  public function singleProduct() {
    $editId  = sanitize($this->input->post('editId'));


    $getSingleProduct = $this->model->getSingleProduct($editId);
    
    $data = array(
      'success' => 1,
      'result' => $getSingleProduct
    );

    genJson($data);
  }

  public function deleteItem() {
    $deleteId  = sanitize($this->input->post('deleteId'));


    $getDeleteItem = $this->model->getDeleteItem($deleteId);
    
    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function addCart() {
    $bookNo = sanitize($this->input->post('bookNo'));
    $item   = sanitize($this->input->post('item'));
    $quantity   = sanitize($this->input->post('quantity'));

    $getAddCart = $this->model->getAddCart($bookNo, $item, $quantity);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function loadCart() {
    $bookNo = sanitize($this->input->post('bookNo'));

    $getLoadCart = $this->model->getLoadCart($bookNo);

    $data = array(
      'success' => 1,
      'result' => $getLoadCart
    );

    genJson($data);
  }

  public function loadCartHistory() {
    $bookNo = sanitize($this->input->post('bookNo'));

    $getLoadCartHistory = $this->model->getLoadCartHistory($bookNo);

    $data = array(
      'success' => 1,
      'result' => $getLoadCartHistory
    );

    genJson($data);
  }

  public function deleteItemCart() {
    $deleteId = sanitize($this->input->post('deleteId'));

    $getDeleteItemCart = $this->model->getDeleteItemCart($deleteId);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function validateBookNo() {
    $bookNo = sanitize($this->input->post('bookNo'));

    $getValidateBookNo = $this->model->getValidateBookNo($bookNo);

    $data = array(
      'success' => count($getValidateBookNo),
    );

    genJson($data);
  }

  public function saveOrder() {
    $bookNo = sanitize($this->input->post('bookNo'));

    $getSaveOrder = $this->model->getSaveOrder($bookNo);

    $data = array(
      'success' => 1
    );

    genJson($data);
  }

  public function loadOrder() {
    $getLoadOrder = $this->model->getLoadOrder();

    $newOrder = [];

    foreach($getLoadOrder as $order) {
      $getTotalPendingOrder = $this->model->getTotalPendingOrder($order->bookNo);
      $order->totalPendingOrder = $getTotalPendingOrder;
      array_push($newOrder, $order);
    }

    $data = array(
      'success' => 1,
      'result' => $newOrder,
    );

    genJson($data);
  }

  public function orderList() {
    $orderId = sanitize($this->input->post('orderId'));

    $getBookNoByOrderId = $this->model->getBookNoByOrderId($orderId);

    $getOrderList = $this->model->getOrderListByBookNo($getBookNoByOrderId);


    $data = array(
      'success' => 1,
      'result' => $getOrderList,
      '$getBookNoByOrderId' => $getBookNoByOrderId
    );

    genJson($data);
  }

  public function orderComplete() {
    $orderId = sanitize($this->input->post('orderId'));

    $getOrderComplete = $this->model->getOrderComplete($orderId);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function orderDelete() {
    $orderId = sanitize($this->input->post('orderId'));

    $getOrderDelete = $this->model->getOrderDelete($orderId);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }
  
  public function orderCount() {
    $getOrderCount = $this->model->getOrderCount();

    $data = array(
      'success' => 1,
      'count' => $getOrderCount
    );

    genJson($data);
  }

  public function bookRevenue() {
    $getBookRevenue = $this->model->getBookRevenue();

    $data = array(
      'success' => 1,
      'result' => $getBookRevenue
    );

    genJson($data);
  }
  
  public function orderRevenue() {
    $getOrderRevenue = $this->model->getOrderRevenue();

    $data = array(
      'success' => 1,
      'result' => $getOrderRevenue
    );

    genJson($data);
  }

  public function addContact() {
    $firstName = sanitize($this->input->post('firstName'));
    $lastName = sanitize($this->input->post('lastName'));
    $email = sanitize($this->input->post('email'));
    $contact = sanitize($this->input->post('contact'));
    $message = sanitize($this->input->post('message'));
    
    $getAddContact = $this->model->getAddContact($firstName, $lastName, $email, $contact, $message);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function allContacts() {
    $getAllContacts = $this->model->getAllContacts();

    $data = array(
      'success' => 1,
      'result' => $getAllContacts
    );

    genJson($data);
  }

  public function deleteContact() {
    $deleteId = sanitize($this->input->post('deleteId'));

    $getDeleteContact = $this->model->getDeleteContact($deleteId);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }
}
