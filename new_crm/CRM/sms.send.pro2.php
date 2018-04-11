<?php
include_once "include/inc.php";

$arr_send = array();
$arr_send = explode("/", $_REQUEST[send_list_serial]);

$arr_send_cnt = count($arr_send);
$byte_chk = iconv_strlen($_REQUEST[messgae]);
$send_type = $_REQUEST[m_send_type];




?>