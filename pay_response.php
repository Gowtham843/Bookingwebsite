<?php
require('admin/inc/db_config.php');
require('admin/inc/essential.php');

require('commonPage/phonepay/common.php');
require('commonPage/phonepay/config.php');


date_default_timezone_set("Asia/Kolkata");

session_start();
unset($_SESSION['room']);

function regenerate_session($uid)
{
    $user_query = select("SELECT * FROM `user_credit` WHERE `sr_no`=? LIMIT 1", [$uid], 'i');
    $user_fetch = mysqli_fetch_assoc($user_query);
    $_SESSION['login'] = true;
    $_SESSION['uid'] = $user_fetch['sr_no'];
    $_SESSION['uname'] = $user_fetch['name'];
    $_SESSION['upic'] = $user_fetch['pic'];
    $_SESSION['unumber'] = $user_fetch['number'];
}


if (isset($_POST['merchantId']) && isset($_POST['transactionId']) && isset($_POST['amount'])) {

    $merchantId = $_POST['merchantId'];
    $transactionId = $_POST['transactionId'];
    $amount = $_POST['amount'] * 100;

    if (API_STATUS == "LIVE") {
        $url = LIVESTATUSCHECKURL . $merchantId . "/" . $transactionId;
        $saltkey = SALTKEYLIVE;
        $saltindex = SALTINDEX;
    } else {
        $url = STATUSCHECKURL . $merchantId . "/" . $transactionId;
        $saltkey = SALTKEYUAT;
        $saltindex = SALTINDEX;
    }

    $st = "/pg/v1/status/" . $merchantId . "/" . $transactionId . $saltkey;

    $dataSha256 = hash("sha256", $st);

    $checksum = $dataSha256 . "###" . $saltindex;


    //GET API CALLING
    $headers = array(
        "Content-Type: application/json",
        "accept: application/json",
        "X-VERIFY: " . $checksum,
        "X-MERCHANT-ID:" . $merchantId
    );



    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $resp = curl_exec($curl);

    curl_close($curl);

    $responsePayment = json_decode($resp, true);


    $tran_id = $responsePayment['data']['transactionId'];
    $amount = $responsePayment['data']['amount'];
    $orderid = $responsePayment['data']['merchantTransactionId'];
    $trans_status = $responsePayment['code'];
    $trans_response_msg = $responsePayment['message'];
    $type = $responsePayment['data']['paymentInstrument']['type'];


    $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`=?";
    $stmt = mysqli_prepare($con, $slct_query);
    mysqli_stmt_bind_param($stmt, "s", $orderid);
    mysqli_stmt_execute($stmt);
    $sel_res = mysqli_stmt_get_result($stmt);


    $slect_fetch = mysqli_fetch_assoc($sel_res);
 
    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        //regenrate the session
        regenerate_session($slect_fetch['user_id']);
    }




    if ($responsePayment['success'] && $responsePayment['code'] == "PAYMENT_SUCCESS") {
        // redircting it successpage
        $upd_query = "UPDATE `booking_order` SET 
        `booking_status` = 'booked',
        `trans_id` = '" . $tran_id . "',
        `trans_amount` = '" . ($_POST['amount'] / 100) . "',
        `trans_status` = '" . $trans_status . "',
        `trans_response_msg` = '" . $trans_response_msg . "' 
        WHERE `booking_id` = '" . $slect_fetch['booking_id'] . "'";


        mysqli_query($con, $upd_query);


        header('Location:' . BASE_URL . "pay_status.php?tid=" . $tran_id . "&order=" . $orderid . "&amount=" . $amount . "&type=" . $type );
    } else {
        $upd_query = "UPDATE `booking_order` SET 
        `booking_status` = 'failed',
        `trans_id` = '" . $_POST['transactionId'] . "',
        `trans_amount` = '" . ($_POST['amount'] / 100) . "',
        `trans_status` = '" . $trans_status . "',
        `trans_response_msg` = '" . $trans_response_msg . "' 
        WHERE `booking_id` = '" . $slect_fetch['booking_id'] . "'";

        header('Location:' . BASE_URL . "pay_status.php?tid=" . $tran_id . "&order=" . $orderid . "&amount=" . $amount);
    }
}
