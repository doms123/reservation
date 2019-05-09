<?php 
class Model extends CI_Model {
	public function getLogin($username, $pass) {
		$sql 	= "SELECT * FROM tbl_user WHERE username = ? AND pass = ?";
		$data 	= array($username, md5($pass));
		$query 	= $this->db->query($sql, $data);
		return count($query->row());
  }
  
  public function getAddRoom($images, $name, $desc, $price, $roomCount, $guestCount, $type) {
    $sql 	= "INSERT INTO tbl_room(`img`, `name`, `type`, `description`, `price`, `roomCount`, `guestCount`, `active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $data = array($images, $name, $type, $desc, $price, $roomCount, $guestCount, 1);
    $query 	= $this->db->query($sql, $data);
    return $this->db->insert_id();
  }

  public function getEditRoom($images, $name, $desc, $price, $roomCount, $guestCount , $editId, $type) {
    $sql = "UPDATE tbl_room SET `img` = ?, `name` = ?, `description` = ?, `price` = ?, `roomCount` = ?, `guestCount` = ?, `active` = ?, `type` = ? WHERE `roomId` = ?";
    $data = array($images, $name, $desc, $price, $roomCount, $guestCount, 1, $type, $editId);
    $query 	= $this->db->query($sql, $data);
    return $query;
  }

  public function getAllRooms() {
    $sql = "SELECT * FROM tbl_room WHERE active = ? ORDER BY dateAdded DESC";
    $data = array(1);
    return $this->db->query($sql, $data)->result();
  }

  public function getSingleRoom($roomId) {
    $sql = "SELECT * FROM tbl_room WHERE active = ? AND roomId = ?";
    $data = array(1, $roomId);
    $query 	= $this->db->query($sql, $data);
    return $query->result();
  }

  public function getDeleteRoom($deleteId) {
    $sql = "UPDATE tbl_room SET active = ? WHERE roomId = ?";
    $data = array(0, $deleteId);
    return $this->db->query($sql, $data);
  }

  public function getRoomType() {
    $sql = "SELECT * FROM tbl_room WHERE active = ?";
    $data = array(1);
    return $this->db->query($sql, $data);
  }

  public function getRoomNo($roomId) {
    $sql = "SELECT roomCount FROM tbl_room WHERE active = ? AND roomId = ?";
    $data = array(1, $roomId);
    return $this->db->query($sql, $data);
  }

  public function getAddBook($bookNo, $guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status) {
    $sql = "INSERT INTO tbl_booking (`bookNo`, `guestName`, `guestContact`, `guestEmail`, `checkIn`, `checkOut`, `roomId`, `roomNo`, `status`, `active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $data = array($bookNo, $guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status, 1);
    $this->db->query($sql, $data);
    return $this->db->insert_id();
  }

  public function getBookList() {
    $sql = "SELECT b.bookNo, b.bookId, b.guestName, b.guestContact, b.guestEmail, b.checkIn, b.checkOut, r.name, b.roomNo, b.status, r.type FROM tbl_booking b INNER JOIN tbl_room r ON r.roomId = b.roomId WHERE b.active = ? ORDER BY b.dateAdded DESC";
    return $this->db->query($sql, 1);
  }

  public function getSingleBook($editId) {
    $sql = "SELECT b.roomId, b.bookId, b.guestName, b.guestContact, b.guestEmail, b.checkIn, b.checkOut, r.name, b.roomNo, b.status, b.active FROM tbl_booking b INNER JOIN tbl_room r ON r.roomId = b.roomId WHERE b.bookId = ? AND b.active = ?";
    $data = array($editId, 1);
    return $this->db->query($sql, $data);
  }

  public function getEditBook($guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status, $editId) {
    $sql = "UPDATE tbl_booking SET `guestName` = ?, `guestContact` = ?, `guestEmail` = ?, `checkIn` = ?, `checkOut` = ?, `roomId` = ?, `roomNo` = ?, `status` = ? WHERE `bookId` = ?";
    $data = array($guestName, $guestContact, $guestEmail, $checkIn, $checkOut, $roomType, $roomNo, $status, $editId);
    $this->db->query($sql, $data);
    return $this->db->insert_id();
  }

  public function getDeleteBook($id) {
    $sql = "UPDATE tbl_booking set `active` = ? WHERE bookId = ?";
    $data = array(0, $id);
    return $this->db->query($sql, $data);
  }

  public function getAvailableRoom($checkIn, $checkOut) {
    $sql = "SELECT * FROM tbl_booking b 
            INNER JOIN tbl_room r ON r.roomId = b.roomId WHERE 
            (DATE(b.checkIn) <= ? AND DATE(b.checkOut) >= ?) 
            OR (DATE(b.checkIn) <= ? AND DATE(b.checkOut) >= ?)";
    $data = array($checkIn, $checkIn, $checkOut, $checkOut);
    return $this->db->query($sql, $data)->result();
  }

  public function getItems() {
    $sql = "SELECT * FROM tbl_product WHERE visible = ? ORDER BY dateAdded DESC";
    $data = array(1);
    return $this->db->query($sql, $data)->result();
  }

  public function getAddEditProd($name, $desc, $price, $status, $editId) {
    if ($editId) {
      $sql = "UPDATE tbl_product SET `title` = ?, `description` = ?, `price` = ?, `status` = ? WHERE `productId` = ?";
      $data = array($name, $desc, $price, $status, $editId);
    } else {
      $sql = "INSERT INTO tbl_product (`title`, `description`, `price`, `status`, `visible`) VALUES (?, ?, ?, ?, ?)";
      $data = array($name, $desc, $price, $status, 1);
    }

    return $this->db->query($sql, $data);
  }

  public function getSingleProduct($editId) {
    $sql = "SELECT * FROM tbl_product WHERE productId = ? AND visible = ?";
    $data = array($editId, 1);
    return $this->db->query($sql, $data)->row();
  }

  public function getDeleteItem($deleteId) {
    $sql = "UPDATE tbl_product SET visible = ? WHERE productId = ?";
    $data = array(0, $deleteId);
    return $this->db->query($sql, $data);
  }

  public function getAddCart($bookNo, $item, $quantity) {
    $sql = "INSERT INTO tbl_order(`bookNo`, `productId`, `quantity`, `status`) VALUES (?, ?, ?, ?)";
    $data = array($bookNo, $item, $quantity, 1);
    return $this->db->query($sql, $data);
  }

  public function getLoadCart($bookNo) {
    $sql = "SELECT o.*, p.title, p.price FROM tbl_order o INNER JOIN tbl_product p ON p.productId = o.productId WHERE o.status = ? ORDER BY o.dateAdded DESC";
    $data = array(1);
    return $this->db->query($sql, $data)->result();
  }

  public function getLoadCartHistory($bookNo) {
    $sql = "SELECT o.*, p.title, p.price, o.status as orderStatus FROM tbl_order o INNER JOIN tbl_product p ON p.productId = o.productId WHERE o.bookNo = ? ORDER BY o.dateAdded DESC";
    $data = array($bookNo);
    return $this->db->query($sql, $data)->result();
  }

  public function getDeleteItemCart($deleteId) {
    $sql = "UPDATE tbl_order SET `status` = ? WHERE orderId = ?";
    $data = array(0, $deleteId);
    return $this->db->query($sql, $data);
  }

  public function getValidateBookNo($bookNo) {
    $sql = "SELECT bookId FROM tbl_booking WHERE bookNo = ? AND `status` != ? LIMIT 1";
    $data = array($bookNo, 0);
    return $this->db->query($sql, $data)->result();
  }

  public function getSaveOrder($bookNo) {
    $sql = "UPDATE tbl_order SET `status` = ? WHERE bookNo = ? AND `status` = ?";
    $data = array(2, $bookNo, 1);
    return $this->db->query($sql, $data);
  }

  public function getLoadOrder() {
    $sql = "SELECT *, o.dateAdded as orderDate FROM tbl_order o 
            INNER JOIN tbl_product p 
            ON p.productId = o.productId 
            INNER JOIN tbl_booking b 
            ON b.bookNo = o.bookNo
            WHERE b.active != 0
            GROUP BY o.bookNo
            ORDER BY o.dateAdded DESC";
    return $this->db->query($sql)->result();
  }

  public function getTotalPendingOrder($bookNo) {
    $sql = "SELECT orderId FROM tbl_order WHERE `bookNo` = ? AND `status` = ?";
    $data = array($bookNo, 2);
    return count($this->db->query($sql, $data)->result());
  }

  public function getBookNoByOrderId($orderId) {
    $sql = "SELECT bookNo FROM tbl_order WHERE orderId = ?  LIMIT 1";
    $data = array($orderId);
    return $this->db->query($sql, $data)->row()->bookNo;
  }

  public function getOrderListByBookNo($bookNo) {
    $sql = "SELECT *, o.dateAdded as orderDate FROM tbl_order o 
            INNER JOIN tbl_product p 
            ON p.productId = o.productId 
            WHERE o.bookNo = ? 
            AND o.status = ?
            ORDER BY o.dateAdded DESC";
    $data = array($bookNo, 2);
    return $this->db->query($sql, $data)->result();
  }

  public function getOrderComplete($orderId) {
    $sql = "UPDATE tbl_order SET `status` = ? WHERE orderId = ?";
    $data = array(3, $orderId);
    return $this->db->query($sql, $data);
  }

  public function getOrderDelete($orderId) {
    $sql = "UPDATE tbl_order SET `status` = ? WHERE orderId = ?";
    $data = array(0, $orderId);
    return $this->db->query($sql, $data);
  }
  
  public function getOrderCount() {
    $sql = "SELECT orderId FROM tbl_order WHERE `status` = ?";
    $data = array(2);
    return count($this->db->query($sql, $data)->result());
  }

  public function getBookRevenue() {
    $sql = "SELECT b.bookNo, b.bookId, b.guestName, b.guestContact, b.guestEmail, b.checkIn, b.checkOut, r.name, b.roomNo, b.status, b.dateAdded, r.price, r.name as roomName, r.type
            FROM tbl_booking b INNER JOIN tbl_room r ON r.roomId = b.roomId WHERE b.status = 1 AND b.active = 1";
    return $this->db->query($sql)->result();
  }

  public function getOrderRevenue() {
    $sql = "SELECT *, o.dateAdded as orderDate FROM tbl_order o 
          INNER JOIN tbl_product p 
          ON p.productId = o.productId 
          WHERE o.status = ?
          ORDER BY o.dateAdded DESC";
    $data = array(3);
    return $this->db->query($sql, $data)->result();
  }

  public function getAddContact($firstName, $lastName, $email, $contact, $message) {
    $sql = "INSERT INTO tbl_contact(`firstName`,`lastName`,`email`,`contact`,`message`,`visible`) VALUES (?, ?, ?, ?, ?, ?)";
    $data = array($firstName, $lastName, $email, $contact, $message, 1);
    return $this->db->query($sql, $data);
  }

  public function getAllContacts() {
    $sql = "SELECT * FROM tbl_contact WHERE visible = 1 ORDER BY dateAdded DESC";
    return $this->db->query($sql)->result();
  }

  public function getDeleteContact($deleteId) {
    $sql = "UPDATE tbl_contact SET `visible` = ? WHERE contactId = ?";
    $data = array(0, $deleteId);
    return $this->db->query($sql, $data);
  }
}