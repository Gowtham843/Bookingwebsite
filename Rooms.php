<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> -Rooms</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>

  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php'); ?>


  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR Rooms</h2>
    <div class="h-line bg-dark"></div>
  </div>

  <div class="container-fluid">
    <div class="row">


      <div class="col-lg-3 col-md-12 mb-4 mb-lg-0 ps-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
          <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2">FILTERS</h4>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#FilterDropdown" aria-controls="FilterDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="FilterDropdown">
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size: 18px;">
                  <span>Check Availability</span>
                  <button class="btn btn-sm text-secondary d-none" onclick="chk_avl_clr()" id="cl_btn">Clear</button>
                </h5>
                <label class="form-label " style="font-weight: 500;">Check-in</label>
                <input type="date" id="checkin" class="form-control shadow-none mb-3" onchange="chk_avl_fliter()">
                <label class="form-label" style="font-weight: 500;">Check-out</label>
                <input type="date" id="checkout" class="form-control shadow-none" onchange="chk_avl_fliter()">
              </div>
             
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="mb-3" style="font-size: 18px;"></h5>
                <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size: 18px;">
                  <span>Guests </span>
                  <button class="btn btn-sm text-secondary d-none" onclick="guests_avl_clr()" id="guests_btn">Clear</button>
                </h5>
                <div class="d-flex">
                  <div class="me-3">
                    <label class="form-label">Adults</label>
                    <input type="number" id="AV" min="1" oninput="guests_filter()" class="form-control shadow-none mb-3">
                  </div>
                  <div>
                    <label class="form-label">Children</label>
                    <input type="number" id="CV" min="1" oninput="guests_filter()" class="form-control shadow-none mb-3">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>

      <div class="col-lg-9 col-md-12 px-4" id="rooms_data">


      </div>

    </div>
  </div>
  <script>
    let rooms_data = document.getElementById('rooms_data');
    let checkin = document.getElementById('checkin');
    let checkout = document.getElementById('checkout');
    let cl_btn = document.getElementById('cl_btn');


    let guests_btn = document.getElementById('guests_btn');
    let adult = document.getElementById('AV');
    let children = document.getElementById('CV');


    function chk_avl_fliter() {
      if (checkin.value != '' && checkout.value != '') {
        fetch_rooms();
        cl_btn.classList.remove('d-none');
      }
    }

    function chk_avl_clr() {
      checkin.value = ''
      checkout.value = ''
      fetch_rooms();
      cl_btn.classList.add('d-none');
    }


    function guests_avl_clr() {
      adult.value = ''
      children.value = ''
      fetch_rooms();
      guests_btn.classList.add('d-none');
    }

    function fetch_rooms() {

      let ck_avl = JSON.stringify({
        checkin: checkin.value,
        checkout: checkout.value
      })
      
    let guests=JSON.stringify({
      adults:adult.value,
      children:children.value
    });
  


      let xhr = new XMLHttpRequest();
      xhr.open("GET", "ajax/room.php?fetch_rooms&check_aval="+ck_avl+"&guests="+guests, true);
      xhr.onprogress = function() {
        rooms_data.innerHTML = `<div class="spinner-border text-primary d-block mx-auto" role="status">
          <span class="sr-only"></span>
        </div>
`
      }
      xhr.onload = function() {
        rooms_data.innerHTML = xhr.responseText;
      }
      xhr.send();
    }

    function guests_filter(){
      if (adult.value>0 || children.value>0) {
        fetch_rooms();
        guests_btn.classList.remove('d-none');
      }
    }

    fetch_rooms();
  </script>


  <!-- footer -->
  <?php require('commonPage/footer.php'); ?>


</body>

</html>