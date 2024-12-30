<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/common.css">

<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
require('admin/inc/db_config.php');
require('admin/inc/essential.php');


$contact_q = "SELECT * FROM `contact` WHERE `sr_no`=?";
$settings_q = "SELECT * FROM `setings` WHERE `sr_no`=?";
$content_q = "SELECT * FROM `content_text` WHERE `sr_no`=?";
$c_value = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $c_value, 'i'));
$settings_r = mysqli_fetch_assoc(select($settings_q, $c_value, 'i'));
$content_r = mysqli_fetch_assoc(select($content_q, $c_value, 'i'));

if ($settings_r['shutdown']) {

    echo <<<data
    <div class="bg-warning text-center fw-bold p-2 rounded">
    <i class="bi bi-exclamation-triangle mx-2" ></i>Bookings are temporarily closed
    </div>
    data;
}
if ((isset($_SESSION['login']) && $_SESSION['login'] == true)) {
   
$query = "SELECT bo.*, bd.* 
          FROM `booking_order` bo
          INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
          WHERE ((bo.booking_status='booked')
          AND (bo.user_id=?)
          AND DATE(bo.check_out) = CURDATE() 
          AND bd.checkout = 0)
          ORDER BY bo.booking_id DESC LIMIT 1";

// Assuming your select function is capable of handling prepared statements and parameter binding
$res = select($query, [$_SESSION['uid']], 'i');

while ($data = mysqli_fetch_assoc($res)) {
    echo <<<data
        <div class="bg-warning text-center fw-bold p-2 rounded">
            <p class="my-2">Ready for checkout : <button type="button" class="btn btn-primary mx-3" onClick="checkoutclk(event)">CheckOut</button></p>
            <input type="hidden" id="chname" value="$data[username]">
            <input type="hidden" id="chphone" value="$data[phone]">
            <input type="hidden" id="chbook" value="$data[booking_id]">
            <input type="hidden" id="chroom" value="$data[room_no]">
        </div>
    data;
}
}


?>