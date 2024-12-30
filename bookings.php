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
  <?php require('commonPage/header.php');
  if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
  } ?>


  <div class="container">
    <div class="row">
      <div class="col-12 my-5 px-4 ">
        <h2 class="fw-bold">Bookings</h2>
        <div class="" style="font-size: 14px;">
          <span><i class="bi bi-house"></i></span>
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="#" class="text-secondary text-decoration-none">Bookings</a>
        </div>
      </div>

      <?php
      $query = "SELECT bo.*,bd.* FROM `booking_order` bo
          INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
          WHERE ((bo.booking_status='booked')
          OR (bo.booking_status='cancelled')
          OR (bo.booking_status='pending')) 
          AND (bo.user_id=?)
          ORDER BY bo.booking_id DESC";

      $res = select($query, [$_SESSION['uid']], 'i');
      while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['date_time']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $status_bg = "";
        $btn = "";
        if ($data['booking_status'] == 'booked') {
          $status_bg = "bg-success";
          if ($data['arrival'] == 1) {
            if ($data['read_review'] == 1) {
              $btn = "<a href='generate_pdf.php?gen_pdf&bookid=$data[booking_id]' class='btn btn-secondary btn-sm fw-bold  p-2' >
              <i class='bi bi-file-pdf-fill ' style='margin-right:10px'></i>Download PDF
               </a>";
            }
            if ($data['read_review'] == 0) {
              $btn = "<a href='generate_pdf.php?gen_pdf&bookid=$data[booking_id]' class='btn btn-secondary btn-sm fw-bold  p-2' >
              <i class='bi bi-file-pdf-fill ' style='margin-right:10px'></i>Download PDF
               </a>
            <button type='button' onclick='reviewRoom($data[booking_id],$data[room_id])' class='btn btn-dark btn-sm fw-bold p-2' data-bs-toggle='modal' data-bs-target='#reviewModal'>
            Rate and Review
            </button>";
            }
          } else {
            $btn = "<button type='button' onclick='cancel_booking_by_user($data[booking_id])' class='btn btn-danger btn-sm fw-bold p-2' >
            Cancel Booking
            </button>";
          }
        } else if ($data['booking_status'] == 'cancelled') {
          $status_bg = "bg-danger";
          if ($data['refund'] == 0) {
            $btn = "<span class='badge bg-primary p-2'>Refund in process</span>";
          } else {
            $btn = "<a href='generate_pdf.php?gen_pdf&bookid=$data[booking_id]' class='btn btn-secondary btn-sm fw-bold p-2' >
            <i class='bi bi-file-pdf-fill ' style='margin-right:10px'></i>Download PDF
             </a>";
          }
        } else {
          $status_bg = "bg-warning";

          $btn = "<a href='generate_pdf.php?gen_pdf&bookid=$data[booking_id]' class='btn btn-secondary btn-sm fw-bold p-2' >
            <i class='bi bi-file-pdf-fill ' style='margin-right:10px'></i>Download PDF
             </a>";
        }

        echo <<<bookings
          <div class='col-md-4 px-4 mb-4 '>
            <div class="bg-white p-3 rounded shadow border">
              <h5 class='fw-bold'>$data[room_name]</h5>
              <p>₹$data[price] per night</p>
              <p>
                <b>Check In : $checkin </b><br>
                <b>Check Out : $checkout </b>
              </p>
              <p>
                <b>Amount : ₹$data[total_pay] </b><br>
                <b>Order Id : $data[order_id] </b><br>
                <b>Date : $date </b>
              </p>
              <p>
                <span class='badge $status_bg p-2'>$data[booking_status] </span>
              </p>
              $btn
            </div>
          </div>
        bookings;
      }

      ?>

    </div>
  </div>

  <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="reviewform">
          <div class="modal-header">
            <h1 class="modal-title fs-5 d-flex align-items-center"><i class="bi bi-chat-heart fs-3 me-2"></i>Rate & Review</h1>
            <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Rating</label>
              <select class="form-select form-select-sm" name="rating">
                <option value="5">Five</option>
                <option value="4">Four</option>
                <option value="3">Three</option>
                <option value="2">Two</option>
                <option value="1">One</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Review</label>
              <textarea class="form-control" name="review" rows="3" aria-label="With textarea" required></textarea>
            </div>
            <input type="hidden" name="booking_id">
            <input type="hidden" name="room_id">
            <div class="d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  if (isset($_GET['cancel_status'])) {
    alert('success', 'Booking cancelled successfully');
  } else if (isset($_GET['review_status'])) {
    alert('success', 'Thank you submitted Rate and Review ');
  }
  ?>

  <!-- footer -->
  <?php require('commonPage/footer.php'); ?>
  <script>
    function cancel_booking_by_user(userid) {

      if (confirm("Are you sure you want to Cancel this booking")) {


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/bookings_user.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


        xhr.onload = function() {
          //    send data to html
          if (this.responseText == '1') {
            window.location.href = "bookings.php?cancel_status=true"
          } else {
            alertScript('danger', "Error...!, Server Error,Please try later");
          }
        }
        xhr.send('cancel_booking_by_user&id=' + userid);
      }

    }

    let review_form = document.getElementById('reviewform');

    function reviewRoom(bookid, roomid) {
      review_form.elements['booking_id'].value = bookid;
      review_form.elements['room_id'].value = roomid;
    }

    review_form.addEventListener('submit', function(e) {
      e.preventDefault();

      let data = new FormData();
      data.append('reviewform', '');
      data.append('rating', review_form.elements['rating'].value);
      data.append('review', review_form.elements['review'].value);
      data.append('booking_id', review_form.elements['booking_id'].value);
      data.append('room_id', review_form.elements['room_id'].value);

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/rr_room.php", true);

      xhr.onload = function() {
        if (this.responseText == 0) {

          var reviewModal = document.getElementById('reviewModal');
          var reviewModalModelControl = bootstrap.Modal.getInstance(reviewModal);
          reviewModalModelControl.hide();
          alertScript('danger', "Error...!, Server Down");
        } else if (this.responseText == 1) {
          window.location.href = 'bookings.php?review_status=true'

        }
      }
      xhr.send(data);
    })
  </script>


</body>

</html>