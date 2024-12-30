<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> -Room Booking</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>

  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php'); ?>
  <?php
  /*  LIST:
    check room id from url is present or not
    shutdown is off
    user is logined
  */

  if (!isset($_GET['id']) || $settings_r['shutdown'] == true) {
    redirect('rooms.php');
  } else  if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('rooms.php');
  }

  // Filter and get room and user data
  $data = Filteration($_GET);

  $room_res = select("SELECT * FROM `rooms` WHERE `sr_no`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');
  if (mysqli_num_rows($room_res) == 0) {
    redirect('Rooms.php');
  }
  $room_data = mysqli_fetch_assoc($room_res);

  $_SESSION['room'] = [
    "sr_no" => $room_data['sr_no'],
    "name" => $room_data['name'],
    "price" => $room_data['price'],
    "payment" => null,
    "available" => false,
  ];




  // user data
  $res_users = select("SELECT * FROM `user_credit` WHERE `sr_no`=? LIMIT 1", [$_SESSION['uid']], 'i');
  $user_data = mysqli_fetch_assoc($res_users);

  ?>

  <div class="container">
    <div class="row">
      <div class="col-12 my-5 px-4 mb-4">
        <h2 class="fw-bold">Confirm Booking</h2>
        <div class="" style="font-size: 14px;">
          <span><i class="bi bi-house"></i></span>
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
          <span class="text-secondary"> > </span>
          <a href="#" class="text-secondary text-decoration-none">Confirm</a>
        </div>
      </div>

      <div class="col-lg-7 col-md-12 px-4 mt-3">

        <?php
        $room_thumb = ROOMS_IMG_PATH . "noPhoto.jpg";
        $thumb_q = mysqli_query($con, "SELECT * FROM `room_image` 
        WHERE `room_id`='$room_data[sr_no]'
        AND `thumb`='1'");
        if (mysqli_num_rows($thumb_q) > 0) {
          $thumb_res = mysqli_fetch_assoc($thumb_q);
          $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
        }
        echo <<<data
          <div class="card p-3 shadow-sm rounded">
          <img src="$room_thumb" class="img-fluid rounded-start mb-3">
          <h5>$room_data[name]</h5>
          <h6>₹$room_data[price] per night</h6>
        </div>
        data;


        ?>

      </div>

      <div class="col-lg-5 col-md-12 px-4 mt-3">
        <div class="card mb-4 border-0 shadow-sm rounded-3">
          <div class="card-body">
            <form action="pay_now.php" method="POST" id="booking_form">
              <h6 class="mb-3">Booking Details</h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" value="<?php echo $user_data['name'] ?>" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Phone Number</label>
                  <input type="text" value="<?php echo $user_data['number'] ?>" name="pno" class="form-control" required>
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Address</label>
                  <textarea class="form-control" name="address" rows="1" aria-label="With textarea" required><?php echo $user_data['address'] ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Check In Date </label>
                  <input type="date" onchange="check_avalable()" name="checkin" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <label class="form-label">Check out Date </label>
                  <input type="date" onchange="check_avalable()" name="checkout" class="form-control" required>
                </div>
                <div class="col-12">
                  <div class="d-flex justify-content-center mb-3">
                    <div class="spinner-grow spinner-grow-sm mx-2  text-info d-none" id="info_loader" role="status">
                    </div>
                    <div class="spinner-grow spinner-grow-sm mx-2 text-info d-none" id="info_loader1" role="status">
                    </div>
                    <div class="spinner-grow spinner-grow-sm mx-2 text-info d-none" id="info_loader2" role="status">
                    </div>
                  </div>
                  <h6 class="mb-3 text-danger" id="pay_info">Provide proper Check-in & Check-out *</h6>

                  <button name="pay_now" class="btn w-100 btn-secondary text-white shadow-none mb-2" disabled> Pay Now</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>




    </div>
  </div>


  <!-- footer -->
  <?php require('commonPage/footer.php'); ?>
  <script>
    let booking_form = document.getElementById('booking_form');
    let info_loader = document.getElementById('info_loader');
    let info_loader1 = document.getElementById('info_loader1');
    let info_loader2 = document.getElementById('info_loader2');
    let pay_info = document.getElementById('pay_info');

    function check_avalable() {
      let checkin_val = booking_form.elements['checkin'].value;
      let checkout_val = booking_form.elements['checkout'].value;

      booking_form.elements['pay_now'].setAttribute('disabled', true);
      if (checkin_val != '' && checkout_val != '') {
        pay_info.classList.add('d-none');
        pay_info.classList.replace('text-dark', 'text-danger');
        info_loader.classList.remove('d-none');
        info_loader1.classList.remove('d-none');
        info_loader2.classList.remove('d-none');

        let data = new FormData();

        data.append('check_avalable', '');
        data.append('check_in', checkin_val);
        data.append('check_out', checkout_val);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/confirmBooking.php", true);

        xhr.onload = function() {
          let data = JSON.parse(xhr.responseText);


          if (data.status == 'matching') {
            pay_info.innerText = "You cannot CheckIn and CheckOut on same date";
            booking_form.elements['pay_now'].setAttribute('disabled', true);

          } else if (data.status == 'earlier') {
            pay_info.innerText = "Your Checkout date is earlier then CheckIn date";
            booking_form.elements['pay_now'].setAttribute('disabled', true);

          } else if (data.status == 'checkin_today') {
            pay_info.innerText = "You cannot CheckIn today";
            booking_form.elements['pay_now'].setAttribute('disabled', true);

          } else if (data.status == 'unavailable') {
            pay_info.innerText = "Room is unavailable on this CheckIn date";
            booking_form.elements['pay_now'].setAttribute('disabled', true);

          } else {
            pay_info.classList.replace('text-danger', 'text-dark')
            //show the payment information
            pay_info.innerHTML = "No. of Days: " + data.days + "<br>" + "Total Amount to pay : ₹" + data.payment;
            booking_form.elements['pay_now'].removeAttribute('disabled');
          }
          info_loader.classList.add('d-none');
          info_loader1.classList.add('d-none');
          info_loader2.classList.add('d-none');
          pay_info.classList.remove('d-none');
        }
        xhr.send(data);

      }

    }
  </script>


</body>

</html>