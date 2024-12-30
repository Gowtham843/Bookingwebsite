<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essential.php');

date_default_timezone_set("Asia/Kolkata");
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('rooms.php');
  }


if (isset($_POST['reviewform'])) {
    $frm_data = Filteration($_POST);

    $query = "UPDATE `booking_order`SET `read_review`=? WHERE `booking_id`=? AND `user_id`=?";
    $values = [1, $frm_data['booking_id'],$_SESSION['uid']];
    $res = update($query, $values, 'iii');


    $q1="INSERT INTO `raing_review`(`booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?,?,?,?,?)";
    $q2v=[$frm_data['booking_id'],$frm_data['room_id'],$_SESSION['uid'],$frm_data['rating'],$frm_data['review']];
    $res2=insert($q1,$q2v,'iiiis');


    if ($res & $res2) {
        echo 1;
    } else {
        echo 0;
    }
}









?>