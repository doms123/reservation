<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function sanitize($str) {
  return filter_var($str, FILTER_SANITIZE_STRING);
}

function genJson($data){
	header("access-control-allow-origin: *");
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Content-type: application/json');
	echo json_encode($data);
}

function today(){
	date_default_timezone_set('Asia/Manila');
	return date("Y-m-d G:i:s");
}

function isValidEmail($email){ 
  if(filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
    return 1;
  }else {
    return 0;
  }
}

function auth($isLogin) {
  if (!$isLogin) {
    header("location: ".base_url());
  }
}

function randHash($len = 6) {
	return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
}

function convertSlashDateToDash($date) {
  if ($date) {
    $dateArr = explode('/', $date);
    return $dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1];
  } else {
    return '';
  }
}
