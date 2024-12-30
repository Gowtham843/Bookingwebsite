<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> -Rooms Details</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>

  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php'); ?>
  <?php
  if (!isset($_GET['id'])) {
    redirect('rooms.php');
  }
  $data = Filteration($_GET);

  $room_res = select("SELECT * FROM `rooms` WHERE `sr_no`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');
  if (mysqli_num_rows($room_res) == 0) {
    redirect('rooms.php');
  }
  $room_data = mysqli_fetch_assoc($room_res);
  ?>

  <div class="container">
    <div class="row">
      <div class="col-12 my-5 px-4 mb-4">
        <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
        <div class="" style="font-size: 14px;">
          <span><i class="bi bi-house"></i></span>
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
        </div>
      </div>

      <div class="col-lg-7 col-md-12 px-4 mt-3">
        <div id="roomImageSlider" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php
            // <!-- getting Tumbnail of room -->
            $room_img = ROOMS_IMG_PATH . "noPhoto.jpg";
            $img_q = mysqli_query($con, "SELECT * FROM `room_image` 
                  WHERE `room_id`='$room_data[sr_no]'");
            if (mysqli_num_rows($img_q) > 0) {
              $active_class = 'active';
              while ($img_res = mysqli_fetch_assoc($img_q)) {

                echo "<div class='carousel-item $active_class'>
                  <img src='" . ROOMS_IMG_PATH . $img_res['image'] . "' class='d-block w-100 rounded-2'>
                </div>";
                $active_class = "";
              }
            } else {
              echo "<div class='carousel-item active'>
                <img src='$room_img' class='d-block w-100'>
              </div>";
            }
            ?>

          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#roomImageSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#roomImageSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

      <div class="col-lg-5 col-md-12 px-4 mt-3">
        <div class="card mb-4 border-0 shadow-sm rounded-3">
          <div class="card-body">
            <?php
            echo <<<price
                <h4 class="mb-1 mt-1">₹$room_data[price] per night</h4>
                price;
            $rating_q = "SELECT AVG(rating) AS avrating FROM `raing_review`
                WHERE `room_id`='$room_data[sr_no]' ORDER BY `sr_no` DESC LIMIT 20";
            $ra_res = mysqli_query($con, $rating_q);
            $rating_fetch = mysqli_fetch_assoc($ra_res);
            $rating_data = "";
            if ($rating_fetch['avrating'] != NULL) {


              for ($i = 0; $i < $rating_fetch['avrating']; $i++) {
                $rating_data .= "<i class='bi bi-star-fill text-warning' style='margin-right:4px'></i>";
              }
            }
            if ($rating_fetch['avrating'] == NULL) {
              $rating_data = " <div class='rating mb-4'>
                              <h6 class='mb-1 mx-1'>Rating</h6>
                              <span class='badge text-bg-light rounded-pill'>No Ratings as done</span></div>";
            }
            echo <<<rating
                <div class="rating mb-2">
                $rating_data
              </div>
              rating;

            // getting features of room
            $fe_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                INNER JOIN `rooms_features` rfea ON f.sr_no=rfea.features_id
                WHERE rfea.rooms_id='$room_data[sr_no]'");


            $features_data = "";
            while ($fea_row = mysqli_fetch_assoc($fe_q)) {
              $features_data .= "<span class='badge text-bg-light text-wrap lh-base'>
                        $fea_row[name]
                        </span>";
            }
            echo <<<fea
              <div class="features mb-1">
                    <h6 class="mb-2">Features :</h6>
                    $features_data
                  </div>
              fea;

            // getting facilities of room
            $fa_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                INNER JOIN `rooms_facilities` rfea ON f.sr_no=rfea.facilities_id
                WHERE rfea.room_id='$room_data[sr_no]'");


            $facilities_data = "";
            while ($fac_row = mysqli_fetch_assoc($fa_q)) {
              $facilities_data .= " <span class='badge text-bg-light  text-wrap lh-base'>$fac_row[name]</span>";
            }
            echo <<<FAC
              <div class="facilities mt-2 mb-3">
                    <h6 class="mb-1">Facilities :</h6>
                    $facilities_data
                  </div>
              FAC;

            echo <<<guest
              <div class="guest ">
                    <h6 class="mb-1 mt-2">Guest :</h6>
                    <span class="badge text-bg-light  text-wrap lh-base">$room_data[adult] Adults</span>
                    <span class="badge text-bg-light  text-wrap lh-base">$room_data[children] Children</span>
                  </div>
              guest;

            echo <<<area
                <div class="mt-2 mb-3">
              <h6 class="mb-1">Area :</h6>
              <span class="badge text-bg-light  text-wrap lh-base">$room_data[area]sq.ft</span>
              </div>
              area;

            $book_btn = "";
            if (!$settings_r['shutdown']) {
              $login = 0;
              if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $login = 1;
              }
              $book_btn = "<button onclick='checkLoginToBook($login,$room_data[sr_no])' class='btn btn-lg w-100 text-white rounded-2 custom-bg py-2 mt-1 shadow-none mb-1'>Book Now ></button>";
            }

            echo <<<btn
              $book_btn
              btn;
            ?>
          </div>
        </div>
      </div>

      <!-- descripiton div -->
      <div class="col-12 px-4 mt-3">
        <div class="mb-4">
          <h5>Description</h5>
          <p>
            <?php
            echo $room_data['description'];
            ?>
          </p>
        </div>
      </div>

      <div>
        <h5 class="mb-3">Reviews $ Ratings</h5>
        <?php
        $q = "SELECT rr.*,uc.name AS uname ,uc.pic, r.name AS rname FROM `raing_review` rr
        INNER JOIN `user_credit` uc ON rr.user_id = uc.sr_no
        INNER JOIN `rooms` r ON rr.room_id = r.sr_no
        WHERE rr.room_id='$room_data[sr_no]' 
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
            echo <<<rev
                <div class="mb-3">
                <div class="swiper-slide bg-white p-4 mb-2">
                  <div class=" d-flex align-items-center p-4">
                    <img src="$img_path$row[pic]" width="30px" />
                    <h6 class="m-0 ms-2">$row[uname]</h6>
                  </div>
                  <p>$row[review]</p>
                <div class="rating">
                  $stars
                </div>
                </div>
                </div>
                rev;
          }
        }
        ?>

      </div>



    </div>
  </div>


  <!-- footer -->
  <?php require('commonPage/footer.php'); ?>


</body>

</html>