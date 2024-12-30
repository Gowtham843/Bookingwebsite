<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essential.php');

date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['check_avalable'])) {
    $data = Filteration($_POST);
    $status = "";
    $result = "";

    // checking in and out date 

    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($data['check_in']);
    $checkout_date = new DateTime($data['check_out']);


    if ($checkin_date == $checkout_date) {
        $status = "matching";
        $result = json_encode(["status" => $status]);
    } else if ($checkin_date > $checkout_date) {
        $status = "earlier";
        $result = json_encode(["status" => $status]);
    } else if ($checkin_date <= $today_date) {
        $status = "checkin_today";
        $result = json_encode(["status" => $status]);
    }


    // check booking available if status is blank else return error 

    if ($status != "") {
        echo $result;
    } else {
        session_start();
        $_SESSION['room'];
        // run quert to check room is available or not 
        $available_rq = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
            WHERE booking_status=? AND room_id=? AND check_out > ? AND check_in < ?";

        $values = ['booked', $_SESSION['room']['sr_no'], $data['check_in'], $data['check_out']];

        $available_rr = select($available_rq, $values, 'siss');
        $available_rf=mysqli_fetch_assoc($available_rr);

        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `sr_no`=?", [$_SESSION['room']['sr_no']], 'i');
        $rq_fetch=mysqli_fetch_assoc($rq_result);
        
        if (($rq_fetch['quantity'] - $available_rf['total_bookings']) <= 0) {
            $status = "unavailable";
            $result = json_encode(["status" => $status]);
            echo $result;
            exit;
        }else{

        $count_days = date_diff($checkin_date, $checkout_date)->days;
        $payment = $_SESSION['room']['price'] * $count_days;
        // Calculate price and store in payment index
        $_SESSION['room']['payment'] = $payment;
        //available is index shows that room is available
        $_SESSION['room']['available'] = true;

        $result = json_encode(["status" => 'available', "days" => $count_days, "payment" => $payment]);
        echo $result;
       
        }
    }
}
