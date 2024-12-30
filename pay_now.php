<?php
require('admin/inc/db_config.php');
require('admin/inc/essential.php');

require('commonPage/phonepay/common.php');
require('commonPage/phonepay/config.php');

date_default_timezone_set("Asia/Kolkata");

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

if (isset($_POST['pay_now'])) {

    $merchantid  = MERCHANTIDUAT;
    $saltkey = SALTKEYUAT;
    $saltindex = SALTINDEX;

    $amount = $_SESSION['room']['payment'];
    $UserId = $_SESSION['uid'];
    $orderId = "ORD_" . $_SESSION['uid'] . getTransactionID();
    $frm_data = Filteration($_POST);
    $mobile = $frm_data['pno'];

    $payLoad = array(
        'merchantId' => $merchantid,
        'merchantTransactionId' => $orderId, // test transactionID
        "merchantUserId" => $UserId,
        'amount' => $amount * 100, // phone pe works on paise
        'redirectUrl' => BASE_URL . REDIRECTURL,
        'redirectMode' => "POST",
        'callbackUrl' => CALL_BACK_URL,
        "mobileNumber" => $mobile,
        // "email" => $email,
        // "param1"=>$email,
        "paymentInstrument" => array(
            "type" => "PAY_PAGE",
        )
    );


    $jsonencode = json_encode($payLoad);

    $payloadbase64 = base64_encode($jsonencode);

    $payloaddata = $payloadbase64 . "/pg/v1/pay" . $saltkey;


    $sha256 = hash("sha256", $payloaddata);

    $checksum = $sha256 . '###' . $saltindex;



    $request = json_encode(array('request' => $payloadbase64));

    $url = '';
    if (API_STATUS == "LIVE") {
        $url = LIVEURLPAY;
    } else {
        $url = UATURLPAY;
    }

    $curl = curl_init(); // This extention should be installed

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-VERIFY: " . $checksum,
            "accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);

    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $res = json_decode($response);

        if (isset($res->success) && $res->success == '1') {
            // $paymentCode=$res->code;
            // $paymentMsg=$res->message;
            $payUrl = $res->data->instrumentResponse->redirectInfo->url;
           
        }
    }


    //   insert table

    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`) VALUES (?,?,?,?,?)";
    insert($query1, [$UserId, $_SESSION['room']['sr_no'], $frm_data['checkin'], $frm_data['checkout'], $orderId], 'issss');

    $booking_id = mysqli_insert_id($con);
    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`,`username`, `phone`, `address`) VALUES (?,?,?,?,?,?,?)";

    insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $amount, $frm_data['name'], $mobile, $frm_data['address']], 'issssss');
    header('Location:' . $payUrl);

}
