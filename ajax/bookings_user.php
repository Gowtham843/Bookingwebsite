<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essential.php');

date_default_timezone_set("Asia/Kolkata");
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('rooms.php');
  }


if (isset($_POST['cancel_booking_by_user'])) {
    $frm_data = Filteration($_POST);

    $query = "UPDATE `booking_order`SET `booking_status`=?, `refund`=? WHERE `booking_id`=? AND `user_id`=?";
    $values = ['cancelled', 0, $frm_data['id'],$_SESSION['uid']];
    $res = update($query, $values, 'siii');
    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}









?>