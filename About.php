<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php');?>
  <title><?php echo $settings_r['site_title']?> -About</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
    .box:hover {
      border-top-color: var(--teal) !important;
    }
  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php'); ?>


  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Our About</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
    <?php echo $content_r['about_text'] ?>
    </p>
  </div>

  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Lorem ipsum dolor sit amet.</h3>
        <p>  <?php echo $content_r['about_b_text'] ?>.</p>
      </div>
      <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order1">
        <img src="images/about.jpg" alt="" class="w-100">
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <div class="row ">
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/hotel.svg" width="70px" alt="">
          <h4 class="mt-3"> 100+ Rooms Available</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/customers.svg" width="70px" alt="">
          <h4 class="mt-3"> 24/7 Customer Support</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/rating.svg" width="70px" alt="">
          <h4 class="mt-3"> Customer latest review</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/staff.svg" width="70px" alt="">
          <h4 class="mt-3"> 100+ Staffs Working</h4>
        </div>
      </div>
    </div>
  </div>

  <h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font">Our Management Team</h2>
  <div class="container px-4">
    <div class="swiper Aboutswiper">
      <div class="swiper-wrapper mb-5">
        <?php
          
         $about_team_r=selectAll('team_details');
         $path=ABOUT_IMG_PATH;
         while($row =mysqli_fetch_assoc($about_team_r)){
          echo<<<data
              <div class="swiper-slide bg-white text-center overflow-hidden rounded">
              <img src="$path$row[picture]" class="w-100" alt="">
              <h5 class="mt-2">$row[name]</h5>
            </div>
          data;
         }
         
        ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>


  <!-- footer -->
  <?php require('commonPage/footer.php'); ?>


  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".Aboutswiper", {
      slidesPerView:4,
      spaceBetween:40,
      pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
      },
      breakpoints: {
        320: {
          slidesPerView: "1"
        },
        640: {
          slidesPerView: "2"
        },
        768: {
          slidesPerView: "3"
        },
        1024: {
          slidesPerView: "4"
        },
      }
    });
  </script>
</body>

</html>