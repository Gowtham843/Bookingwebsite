<?php

require('../admin/inc/db_config.php');
require('../admin/inc/essential.php');

date_default_timezone_set("Asia/Kolkata");

session_start();

if (isset($_GET['fetch_rooms'])) {

  $chk_avl = json_decode($_GET['check_aval'], true);

  if ($chk_avl['checkin'] != '' && $chk_avl['checkout'] != '') {
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($chk_avl['checkin']);
    $checkout_date = new DateTime($chk_avl['checkout']);


    if ($checkin_date == $checkout_date) {
      echo "<h3 class='text-center'> Invalid dates</h3>";
      exit;
    } else if ($checkin_date > $checkout_date) {
      echo "<h3 class='text-center'> Invalid dates</h3>";
      exit;
    } else if ($checkin_date <= $today_date) {
      echo "<h3 class='text-center'> Invalid dates</h3>";
      exit;
    }
  }

  //guests data decode
  $guests = json_decode($_GET['guests'],true);
  $adult = ($guests['adults']!='') ? $guests['adults']:0;
  $children = ($guests['children']!='') ? $guests['children']:0;
  

  $count_rooms = 0;
  $output = "";

  //fetching settings table to check website is shutdown or not
  $settings_q = "SELECT * FROM `setings` WHERE `sr_no`=1";
  $settings_r = mysqli_fetch_assoc(mysqli_query($con, $settings_q));

  //query room cards
  $room_rows = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND  `status`=? AND `removed`=?", [$adult,$children,1, 0], 'iiii');
  while ($room_rows_data = mysqli_fetch_assoc($room_rows)) {

    if ($chk_avl['checkin'] != '' && $chk_avl['checkout'] != '') {
      // run quert to check room is available or not 
      $available_rq = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
              WHERE booking_status=? AND room_id=? AND check_out > ? AND check_in < ?";

      $values = ['booked', $room_rows_data['sr_no'], $chk_avl['checkin'], $chk_avl['checkout']];

      $available_rr = select($available_rq, $values, 'siss');
      $available_rf = mysqli_fetch_assoc($available_rr);



      if (($room_rows_data['quantity'] - $available_rf['total_bookings']) <= 0) {
        continue;
      }
    }

    // getting features of room
    $fe_q = mysqli_query($con, "SELECT f.name FROM `features` f 
          INNER JOIN `rooms_features` rfea ON f.sr_no=rfea.features_id
          WHERE rfea.rooms_id='$room_rows_data[sr_no]'");


    $features_data = "";
    while ($fea_row = mysqli_fetch_assoc($fe_q)) {
      $features_data .= "<span class='badge text-bg-light text-wrap lh-base'>
        $fea_row[name]
        </span>";
    }

    // getting facilities of room
    $fa_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
        INNER JOIN `rooms_facilities` rfea ON f.sr_no=rfea.facilities_id
        WHERE rfea.room_id='$room_rows_data[sr_no]'");

    $facilities_data = "";
    while ($fac_row = mysqli_fetch_assoc($fa_q)) {
      $facilities_data .= " <span class='badge text-bg-light  text-wrap lh-base'>$fac_row[name]</span>";
    }

    // getting Tumbnail of room
    $room_thumb = ROOMS_IMG_PATH . "noPhoto.jpg";
    $thumb_q = mysqli_query($con, "SELECT * FROM `room_image` 
      WHERE `room_id`='$room_rows_data[sr_no]'
      AND `thumb`='1'");
    if (mysqli_num_rows($thumb_q) > 0) {
      $thumb_res = mysqli_fetch_assoc($thumb_q);
      $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
    }
    $book_btn = "";
    if (!$settings_r['shutdown']) {
      $login = 0;
      if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        $login = 1;
      }
      $book_btn = "<button onclick='checkLoginToBook($login,$room_rows_data[sr_no])' class='btn btn-sm w-75 text-white rounded-2 custom-bg shadow-none mb-2'>Book Now ></button>";
    }


    // print room card 
    $output .= "
        <div class='card mb-4 border-0 shadow'>
        <div class='row g-0 p-3 align-items-center'>
          <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
            <img src='$room_thumb' class='img-fluid rounded-start' alt='...'>
          </div>
          <div class='col-md-4 px-lg-3 px-md-3 px-0'>
            <h5 class='mb-2'>$room_rows_data[name]</h5>
            <div class='features mb-3 mt-4'>
              <h6 class='mb-1'>Features</h6>
              $features_data
            </div>
            <div class='facilities mb-3'>
              <h6 class='mb-1'>Facilities</h6>
              $facilities_data
            </div>

            <div class='guest '>
              <h6 class='mb-1'>Guest</h6>
              <span class='badge text-bg-light  text-wrap lh-base'>$room_rows_data[adult] Adults</span>
              <span class='badge text-bg-light  text-wrap lh-base'>$room_rows_data[children] Children</span>
            </div>
          </div>
          <div class='col-md-3 text-center mr-3'>
            <h6 class='mb-4'>₹$room_rows_data[price] per night</h6>
            $book_btn
            <a href='moredetailsroom.php?id=$room_rows_data[sr_no]' class='btn btn-sm w-75 btn-outline-dark  rounded-2 shadow-none'>More Details</a>
          </div>
        </div>
      </div>
    ";
    $count_rooms++;
  }
  if ($count_rooms > 0) {
    echo $output;
  } else {
    echo "<h3 class='text-center'> No rooms to show</h3>";
  }
}
