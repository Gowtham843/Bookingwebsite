<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
    .availability-form {
      margin-top: -2%;
      z-index: 999;
      position: relative;
    }

    @media screen and (max-width:575px) {
      .availability-form {
        margin-top: 2%;
        padding: 0 3%;
      }
    }
  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php'); ?>

  <!-- Carousel -->

  <div class="container-fluid px-lg-4 ">
    <div class="swiper swiper-container">
      <div class="swiper-wrapper">
        <?php
        $carousel_image_r = selectAll('carousel');
        $path = CAROUSEL_IMG_PATH;
        while ($row = mysqli_fetch_assoc($carousel_image_r)) {
          echo <<<data
            <div class="swiper-slide">
            <img src="$path$row[picture]" class="w-100 d-block" />
          </div>
          data;
        }
        ?>

      </div>

    </div>
  </div>


  <!-- check availability -->

  <div class="container availability-form">
    <div class="row">
      <div class="col-lg-12 bg-white shadow p-4 rounded">
        <h5 class="mb-4"> Check Booking Availability</h5>
        <form action="Rooms.php" method="GET">
          <div class="row align-items-end">
            <div class="col-lg-3 mb-3">
              <label class="form-label" style="font-weight: 500;">Check-in</label>
              <input type="date" class="form-control" name="checkin" required>
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label" style="font-weight: 500;">Check-out</label>
              <input type="date" class="form-control" name="checkout" required>
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label" style="font-weight: 500;">Adult</label>
              <select class="form-select shadow-none" name="adults" required>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
            <div class="col-lg-2 mb-3">
              <label class="form-label" style="font-weight: 500;">Children</label>
              <select class="form-select shadow-none" name="children" required>
                <option value="0">None</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
            <div class="col-lg-1 mb-lg-3 mt-2">
              <button class="btn text-white custom-bg" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- RoomsList -->

    <h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">Our Rooms</h2>
    <div class="container">
      <div class="row">
        <?php
        $room_rows = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `sr_no` DESC LIMIT 3", [1, 0], 'ii');
        while ($room_rows_data = mysqli_fetch_assoc($room_rows)) {
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
            $book_btn = "<button onclick='checkLoginToBook($login,$room_rows_data[sr_no])' class='btn btn-sm text-white rounded-2 custom-bg shadow-none'>Book Now ></button>";
          }

          $rating_q = "SELECT AVG(rating) AS avrating FROM `raing_review`
        WHERE `room_id`='$room_rows_data[sr_no]' ORDER BY `sr_no` DESC LIMIT 20";
          $ra_res = mysqli_query($con, $rating_q);
          $rating_fetch = mysqli_fetch_assoc($ra_res);
          $rating_data = "";
          if ($rating_fetch['avrating'] != NULL) {
            $rating_data = " <div class='rating mb-4'>
                      <h6 class='mb-1 mx-1'>Rating</h6>
                      <span class='badge text-bg-light rounded-pill'>";

            for ($i = 0; $i < $rating_fetch['avrating']; $i++) {
              $rating_data .= "<i class='bi bi-star-fill text-warning' style='margin-right:4px'></i>";
            }
            $rating_data .= "</span>
                      </div>";
          }
          if ($rating_fetch['avrating'] == NULL) {
            $rating_data = " <div class='rating mb-4'>
                      <h6 class='mb-1 mx-1'>Rating</h6>
                      <span class='badge text-bg-light rounded-pill'>No Ratings as done</span></div>";
          }

          // print room card 
          echo <<<data
                <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 400px; ; margin: auto;">
                  <img src="$room_thumb" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5>$room_rows_data[name]</h5>
                    <h6 class="mb-4">₹$room_rows_data[price] per night</h6>
                    <div class="features mb-4">
                      <h5 class="mb-1">Features</h5>
                      $features_data
                    </div>
                    <div class="facilities mb-4">
                      <h6 class="mb-1">Facilities</h6>
                      $facilities_data
                    </div>
                    <div class="guest mb-4">
                      <h6 class="mb-1">Guest</h6>
                      <span class="badge text-bg-light  text-wrap lh-base">$room_rows_data[adult]  Adults</span>
                      <span class="badge text-bg-light  text-wrap lh-base">$room_rows_data[children] Children</span>

                    </div>
                   $rating_data
                      
                    <div class="d-flex justify-content-between">
                      $book_btn
                      <a href="moredetailsroom.php?id=$room_rows_data[sr_no]" class="btn btn-sm btn-outline-dark  rounded-2 shadow-none">More Details</a>
                    </div>
                  </div>
                </div>
              </div>
          data;
        }

        ?>


        <div class="col-lg-12 text-center mt-5">
          <a href="Rooms.php" class="btn btn-sm btn-outline-dark rounded-2 shadow-none">More Rooms >>></a>
        </div>
      </div>
    </div>

    <!-- Facilities -->
    <h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">Our Facilities</h2>

    <div class="container">
      <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
        <?php
        $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY `sr_no` DESC LIMIT 5 ");
        $path = FACILITIES_IMG_PATH;

        while ($row = mysqli_fetch_assoc($res)) {
          echo <<<data
    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3 ">
        <img src="$path$row[icon]" width="50px" alt="">
        <h5 class="mt-3">$row[name]</h5>
      </div>
      
    data;
        }
        ?>

        <div class="col-lg-12 text-center mt-5">
          <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-2 shadow-none">More Facilities >>></a>
        </div>
      </div>
    </div>

    <!-- Testimonials -->
    <h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">Testimonials</h2>

    <div class="container">
      <!-- Swiper -->
      <div class="swiper Testimonials-mySwiper">
        <div class="swiper-wrapper mb-5">

          <?php
          $q = "SELECT rr.*,uc.name AS uname ,uc.pic, r.name AS rname FROM `raing_review` rr
        INNER JOIN `user_credit` uc ON rr.user_id = uc.sr_no
        INNER JOIN `rooms` r ON rr.room_id = r.sr_no
        ORDER BY `sr_no` desc LIMIT 4";

          $qv = mysqli_query($con, $q);
          $img_path = USERS_IMG_PATH;

          if (mysqli_num_rows($qv) == 0) {
            echo 'NO REVIEWS YET.!';
          } else {
            while ($row = mysqli_fetch_assoc($qv)) {
              $stars = "<i class='bi bi-star-fill text-warning'></i>";

              for ($i = 1; $i < $row['rating']; $i++) {
                $stars .= "<i class='bi-star-fill text-warning'></i>";
              }
              echo <<< data
                  <div class="swiper-slide bg-white p-4">
                <div class="profile d-flex align-items-center mb-3">
                  <img src="$img_path$row[pic]" width="30px" class="rounded-2" loading="lazy"/>
                  <h6 class="m-0 ms-2">$row[uname]</h6>
                </div>
                <p>$row[review]</p>
                <div class="rating">
                  $stars
                </div>
              </div>
            data;
            }
          }

          ?>



        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="col-lg-12 text-center mt-5">
        <a href="About.php" class="btn btn-sm btn-outline-dark rounded-2 shadow-none">Know more >>></a>
      </div>
    </div>

    <!-- Reach Us -->

    <!-- In contact table in sql taking all the data stored in it,and inserting that data into below div, the query is in header.php page -->
    <h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">Reach Us</h2>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 p-1 mb-lg-0 mb-3 bg-light rounded-5 p-3">
          <iframe class="w-100" src="<?php echo $contact_r['iframe'] ?>" height="450" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="col-lg-4 col-md-4 mt-3">
          <div class="bg-white p-4 rounded">
            <h5>Call Us</h5>
            <a href="tel: +919874563210" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone me-2"></i>+<?php echo $contact_r['pno'] ?></a>
          </div>
          <div class="bg-white p-4 rounded">
            <h5>Follow Us</h5>
            <?php
            if ($contact_r['tl'] != '') {
              echo <<<data
            <a href="$contact_r[tl]" class="d-inline-block mb-2 text-decoration-none text-dark"><span
              class="badge bg-light text-dark fs-6 ps-6"><i class="bi bi-twitter me-2"></i>Twitter</span></a>
            data;
            }
            if ($contact_r['fl'] != '') {
              echo <<<data
            <a href=" $contact_r[fl] " class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-light text-dark fs-6 ps-6"><i class="bi bi-facebook me-2"></i>Facebook</span></a>
            data;
            }
            if ($contact_r['il'] != '') {
              echo <<<data
            <a href=" $contact_r[il]" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-light text-dark fs-6 ps-6"><i class="bi bi-instagram me-2"></i>Instagram</span></a>
            data;
            }

            ?>

          </div>
          <div class="bg-white p-4 rounded">
            <h5>Contact Us</h5>
            <span" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope me-2"></i><?php echo $contact_r['email'] ?></span>
          </div>
          <div class="bg-white p-4 rounded">
            <h5>Address</h5>
            <span" class="d-inline-block mb-2 text-decoration-none text-dark"><?php echo $contact_r['address'] ?>
              </span>
          </div>
        </div>
      </div>
    </div>

    <!--  PASSWORD RESET MODAL  -->
    <div class="modal fade" id="passresetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="passresetform">
            <div class="modal-header">
              <h1 class="modal-title fs-5 d-flex align-items-center"><i class="bi bi-shield-lock fs-3 me-2"></i>Set up New Password </h1>
            </div>
            <div class="modal-body">
              <div class="mb-4">
                <label class="form-label">New Password :</label>
                <input type="password" class="form-control" name="newpass" required>
                <input type="hidden" name="email">
                <input type="hidden" name="token">
              </div>
              <div class="mb-2 text-end">
                <div class="d-flex align-items-center justify-content-between">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="submit" class="btn  btn-outline  pr-4" data-bs-dimiss="modal">Back</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- footer -->
    <?php require('commonPage/footer.php'); ?>

    <?php
    if (isset($_GET['account_recovery'])) {
      $data = Filteration($_GET);
      // checking that token is not expired by checking its date and time
      $todays_date = date('Y-m-d');

      $query = select(
        "SELECT * FROM `user_credit` WHERE `email`=? AND `token`=? AND `t_expire`=? LIMIT 1",
        [$data['email'], $data['token'], $todays_date],
        'sss'
      );

      if (mysqli_num_rows($query) == 1) {
        echo <<<modal
        <script>
          var passresetModal = document.getElementById('passresetModal');
          passresetModal.querySelector("input[name='email']").value='$data[email]';
          passresetModal.querySelector("input[name='token']").value='$data[token]';

          var passresetModalModelControl = bootstrap.Modal.getOrCreateInstance(passresetModal);
          passresetModalModelControl.show();
          </script>
        modal;
      } else {
        alert('danger', "Invalid Link");
      }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".swiper-container", {
        spaceBetween: 30,
        effect: "fade",
        loop: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        }

      });

      var swiper1 = new Swiper(".Testimonials-mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        slidesPerView: "3",
        loop: true,
        coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: false,
        },
        pagination: {
          el: ".swiper-pagination",
        },
        breakpoints: {
          320: {
            slidesPerView: "1"
          },
          640: {
            slidesPerView: "1"
          },
          768: {
            slidesPerView: "2"
          },
          1024: {
            slidesPerView: "3"
          },
        }
      });

      // Password recovery

      let passresetform = document.getElementById('passresetform');
      passresetform.addEventListener('submit', function(e) {
        e.preventDefault();
        resetPasswordUser();
      });

      function resetPasswordUser() {

        let fd = new FormData();
        fd.append('newpass', passresetform.elements['newpass'].value);
        fd.append('email', passresetform.elements['email'].value);
        fd.append('token', passresetform.elements['token'].value);
        fd.append('resetPasswordUser', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/loginandregister.php", true);

        xhr.onprogress = function() {
          alertScript('info', "Progress is going on");
        }

        xhr.onload = function() {

          if (this.responseText == 'failed') {
            alertScript('danger', "Error...!,Password was not able to change !");
          } else if (this.responseText == 1) {
            alertScript('success', "Password Successfully changed ");
            var passresetModal = document.getElementById('passresetModal');
            var passresetModalModelControl = bootstrap.Modal.getInstance(passresetModal);
            passresetModalModelControl.hide();
            forgotform.reset();
          }

        }
        xhr.send(fd);
      }
    </script>
</body>

</html>