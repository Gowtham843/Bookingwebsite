<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> -Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>

  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php');
  if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
  }

  $u_exist = select("SELECT * FROM `user_credit` WHERE `sr_no`=? LIMIT 1", [$_SESSION['uid']], 's');
  if (mysqli_num_rows($u_exist) == 0) {
    redirect('index.php');
  }
  $u_fetch = mysqli_fetch_assoc($u_exist);

  ?>


  <div class="container">
    <div class="row">
      <div class="col-12 my-5 px-4 ">
        <h2 class="fw-bold">Profile</h2>
        <div class="" style="font-size: 14px;">
          <span><i class="bi bi-house"></i></span>
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>

        </div>
      </div>

      <div class="col-12 mb-5 px-4 ">
        <div class="bg-white p-3 p-md-4 rounded">
          <form id="info_form">
            <h5 class="mb-3 ffw-bold">Basic Information</h5>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Name</label><i class="bi bi-person-vcardms-2"></i>
                <input type="text" name="name" value="<?php echo $u_fetch['name'] ?>" class="form-control" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Phone Number</label><i class="bi bi-person-vcardms-2"></i>
                <input type="number" name="phone" value="<?php echo $u_fetch['number'] ?>" class="form-control" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Date of birth</label><i class="bi bi-cake2 ms-2"></i>
                <input type="date" class="form-control" name="dob" value="<?php echo $u_fetch['dob'] ?>" required>
              </div>
              <div class="col-md-8 mb-3">
                <label class="form-label">Address</label><i class="bi bi-house ms-2"></i>
                <textarea class="form-control" name="address" rows="1" aria-label="With textarea" required><?php echo $u_fetch['address'] ?></textarea>
              </div>
              <div class="col-md-4 mb-5">
                <label class="form-label">Pincode</label><i class="bi bi-pin ms-2"></i>
                <input type="Number" class="form-control" name="pincode" value="<?php echo $u_fetch['pincode'] ?>" required>
              </div>
            </div>
            <button type="submit" class="btn custom-bg text-white shadow-none">Save</button>
          </form>
        </div>
      </div>


      <div class="col-md-7 col-lg-5 mb-5 px-1 ">
        <div class="bg-white p-3 p-md-4 rounded">
          <form id="pic_form">
            <h5 class="mb-3 ffw-bold">Picture</h5>
            <img src="<?php echo USERS_IMG_PATH . $u_fetch['pic'] ?>" class="rounded-2" style="width:40%;height:10%;">
            <div class="row my-3" style="padding-right: 25%;">
              <label class="form-label ">Add Picture</label>
              <input type="file" accept=".png, .jpeg, .webg" name="pic" class="form-control" required>
            </div>
            <button type="submit" class="btn custom-bg text-white shadow-none">Save</button>
          </form>
        </div>
      </div>


      <div class="col-md-7 col-lg-7 mb-5 px-1 ">
        <div class="bg-white p-3 p-md-4 rounded">
          <form id="pass_form">
            <h5 class="mb-3 ffw-bold">Change Password</h5>
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label class="form-label">Old Password</label>
                  <input type="password" name="opassword" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="text" name="cpassword" class="form-control" required>
                </div>
              </div>
              <button type="submit" class="btn custom-bg text-white shadow-none">Save</button>
          </form>
        </div>
      </div>

    </div>
  </div>



  <!-- footer -->
  <?php require('commonPage/footer.php'); ?>
  <script>
    let info_form = document.getElementById('info_form');
    info_form.addEventListener('submit', function(e) {
      e.preventDefault();
      let data = new FormData();
      // name, phone, dob, address,
      data.append('info_form', '');
      data.append('name', info_form.elements['name'].value);
      data.append('phone', info_form.elements['phone'].value);
      data.append('dob', info_form.elements['dob'].value);
      data.append('pincode', info_form.elements['pincode'].value);
      data.append('address', info_form.elements['address'].value);



      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/info.php", true);

      xhr.onload = function() {
        if (this.responseText == 'Number already used') {
          alertScript('danger', "Error...!, Number is already registered.");
        } else if (this.responseText == 0) {
          alertScript('danger', "Error...!, No changes made.");
        } else if (this.responseText == 1) {
          alertScript('success', "Successfully changed");
          info_form.reset();
          window.location.reload();
        }
      }
      xhr.send(data);
    });

    let pic_form = document.getElementById('pic_form');
    pic_form.addEventListener('submit', function(e) {
      e.preventDefault();
      let data = new FormData();
      // name, phone, dob, address,
      data.append('pic_form', '');
      data.append('pic', pic_form.elements['pic'].files[0]);

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/info.php", true);

      xhr.onload = function() {
        if (this.responseText == 'inv_img') {
          alertScript('danger', "Error...!, Only JPG, WEBP & PNG are only allowed");
        } else if (this.responseText == 'failed') {
          alertScript('danger', "Error...!, Image Uploading Failed");
        } else if (this.responseText == 0) {
          alertScript('danger', "Error...!, Update Failed.");
        } else if (this.responseText == 1) {
          window.location.href = window.location.pathname;
        }
      }
      xhr.send(data);
    });



    let pass_form = document.getElementById('pass_form');
    pass_form.addEventListener('submit', function(e) {
      e.preventDefault();

      let new_pass=pass_form.elements['password'].value;
      let c_pass=pass_form.elements['cpassword'].value;

      if (new_pass!=c_pass) {
        alertScript('danger', "Error...!, Both password are not same");
        return false;
      }

      let data = new FormData();
      // password
      data.append('pass_form', '');
      data.append('opassword', pass_form.elements['opassword'].value);
      data.append('password', new_pass);




      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/info.php", true);

      xhr.onload = function() {
        if (this.responseText == 'Invalidpass') {
          alertScript('danger', "Error...!, Old Password is wrong");
        } if (this.responseText == 0) {
          alertScript('danger', "Error...!, Server Down");
        } else if (this.responseText == 1) {
          alertScript('success', "Successfully changed");
          pass_form.reset();
        }
      }
      xhr.send(data);
    });
  </script>


</body>

</html>