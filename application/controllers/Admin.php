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

  // public function order() {
  //   auth($this->session->userdata('isLogin'));
  //   $this->load->view('order');
  // }

  // public function product() {
  //   auth($this->session->userdata('isLogin'));
  //   $this->load->view('product');
  // }

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

    // if ($status == 1) {
    //   $config = Array(
    //     'protocol' => 'smtp',
    //     'smtp_host' => 'ssl://smtp.googlemail.com',
    //     'smtp_port' => 465,
    //     'smtp_user' => 'hhacienda8@gmail.com',
    //     'smtp_pass' => 'Pass123!',
    //     'mailtype' => 'html',
    //     'charset' => 'iso-8859-1',
    //     'wordwrap' => TRUE
    //   );

    //   $this->load->library('email', $config);
    //   $this->email->from('hhacienda8@gmail.com', 'admin');
    //   $this->email->to('dominicksanchez30@gmail.com');
    //   $this->email->subject('Email test');


    //   $this->email->message('Test message');
    //   $this->email->set_newline("\r\n");

    //   $result = $this->email->send();
    //   $this->email->print_debugger();
    // }
    
    if ($editId) {
      $getEditBook	= $this->model->getEditBook($guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status, $editId);
    } else {
      $getAddBook	= $this->model->getAddBook($bookNo, $guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status);
    }

    $data = array(
      'success' => 1,
      // 'mail' => $result,
      // 'debug' => $this->email->print_debugger()
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
    $isNotCancellable = $this->model->checkBookCancellable($editId); 

    $data = array(
      'success' => 1,
      'result' => $getBookList->result(),
      'isNotCancellable' => count($isNotCancellable)
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

  public function multipleBookAction() {
    $ids = $this->input->post('ids');
    $type = $this->input->post('type');

    for($x = 0; $x < count($ids); $x++) {
      if ($type == 'cancel') {
        $isNotCancellable = $this->model->checkBookCancellable($ids[$x]);
        if (!count($isNotCancellable)) {
          $getDeleteBook	= $this->model->multipleBookAction($ids[$x], $type);
        }
      } else {
        $getDeleteBook	= $this->model->multipleBookAction($ids[$x], $type);
      }
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

    $getAllArr = [];
    foreach ($getAllRooms as $gRooms) {
      $object = new stdClass();
      $object->name = $gRooms->name;
      $object->img = unserialize($gRooms->img);
      $object->description = $gRooms->description;
      $object->price = $gRooms->price;
      $object->roomId = $gRooms->roomId;
      $object->guestCount = $gRooms->guestCount;
      array_push($getAllArr, $object);
    }


    $data = array(
      'success' => 1,
      'result' => $newRoomArr,
      'allRooms' => $getAllArr,
    );

    genJson($data);
  }

  public function reservationCart() {
    $customerIP   = $_SERVER['REMOTE_ADDR'];
    $getReservationCart = $this->model->getReservationCart($customerIP);

    $data = array(
      'success' => 1,
      'count' => count($getReservationCart),
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
    $customerIP   = $_SERVER['REMOTE_ADDR'];
    $isCart       = sanitize($this->input->post('isCart'));

    $getBookCart = $this->model->getBookCart($customerIP);

    if ($isCart) {
      $insertId = $this->model->getAddBook($bookNo, $guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, 2, $customerIP);
      $getSingleBook = $this->model->getSingleBook($insertId)->row();
      $result = false;
    } else {

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
      $this->email->from('hhacienda8@gmail.com', 'Admin');
      $this->email->to($guestEmail);
      $this->email->subject('HACIENDA GALEA RESERVATION');

      $message = '
  <p>Hi '.$guestName.', thank you for making a reservation!</p>
  <br>
  <p>Please see the following room reservation details</p>';
$gt = 0;
// print_r($getBookCart->result());
// die();
foreach($getBookCart->result() as $cart) {
  // print_r($cart);
  // die();
  $this->model->getUpdateBook($guestName, $guestContact, $guestEmail, $cart->bookId);

  $checkIn = new DateTime($cart->checkIn);
  $checkInDate = date_format($checkIn, 'F d, Y');

  $checkOut = new DateTime($cart->checkOut);
  $checkOutDate = date_format($checkOut, 'F d, Y');

  $totalAmount = $cart->totalDays * $cart->price;

  $message .= '
    <table style="border: 1px solid #000; border-collapse: collapse; margin-bottom: 20px;">
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Booking No.:</strong> '.$cart->bookNo.'
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Room Name:</strong> '.$cart->name.'
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Room Number:</strong> '.$cart->roomNo.'
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Number of Guest:</strong> '.$cart->guestCount.'
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Check-in:</strong> '.$checkInDate.' from 14:00
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Check-out:</strong> '.$checkOutDate.' until 11:00
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Description: </strong> '.$cart->description.'
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 5px;">
          <strong>Total Amount:</strong> Php '.number_format($totalAmount, 2).'
        </td>
      </tr>
    </table>';

    $gt = $gt + $totalAmount;
}

$message .= '
  <p>To confirm your reservation, please send to this BDO account no.: <strong>001820479151</strong> an amount of '.number_format($gt / 2, 2).' for the 50% reservation down payment </p>
  <br>
  <p><strong>Booking Policies</strong></p>
  <p>If payment has been made:</p>
  <ul>
    <li>30% deposit payment will be forfeited if cancellation is made two (2) days before the function</li>
      <li>50% deposit payment will be forfeited if cancellation is made one (1) day before the function</li>
  </ul>
  <br>
  <p>Best Regards,</p>
  <p style="margin-top: -10px;">Hacienda Galea Management</p>
  ';

      $this->email->message($message);
      $this->email->set_newline("\r\n");

      $result = $this->email->send();
}
   
    $data = array(
      'success' => 1,
      'bookNo' => $bookNo,
      'mail' => $result,
      'cart' => $getBookCart->result()
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

  public function messageCount() {
    $getMessageCount = $this->model->getMessageCount();

    $data = array(
      'success' => 1,
      'count' => $getMessageCount
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
    $this->email->from($email, 'customer');
    $this->email->to('hhacienda8@gmail.com');
    $this->email->subject($firstName.' '.$lastName.' - Customer Message');

    $this->email->message($message);
    $this->email->set_newline("\r\n");

    $result = $this->email->send();

    $data = array(
      'success' => 1,
      'mail' => $result
    );

    genJson($data);
  }

  public function replyMessage() {
    $replyMessage = sanitize($this->input->post('replyMessage'));
    $replyTitle = sanitize($this->input->post('replyTitle'));
    $email = sanitize($this->input->post('email'));

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
    $this->email->to($email);
    $this->email->subject($replyTitle);

    $this->email->message($replyMessage);
    $this->email->set_newline("\r\n");

    $result = $this->email->send();

    $data = array(
      'success' => 1,
      'mail' => $result
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

  public function bookCart() {
    $customerIP   = $_SERVER['REMOTE_ADDR'];

    $getBookCart = $this->model->getBookCart($customerIP);

    $data = array(
      'success' => 1,
      'result' => $getBookCart->result()
    );

    genJson($data);
  }

  public function deleteBookCart() {
    $bookId = sanitize($this->input->post('bookId'));

    $getDeleteBook	= $this->model->getDeleteBook($bookId);

    $data = array(
      'success' => 1,
    );

    genJson($data);
  }

  public function reserveHistory() {
    $customerIP   = $_SERVER['REMOTE_ADDR'];
    $email = sanitize($this->input->post('email'));

    $getReserveHistory = $this->model->getReserveHistory($customerIP, $email);

    $data = array(
      'success' => 1,
      'result' => $getReserveHistory->result()
    );

    genJson($data);
  }
}
