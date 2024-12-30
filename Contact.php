<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php'); ?>
  <title><?php echo $settings_r['site_title']?> -Contact Us</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>

  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php'); ?>


  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR Contact Us</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
    <?php echo $content_r['contact_text'] ?>
    </p>
  </div>


  <!-- In head.php page there is contact_r query which is giving data to this div -->
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-mg-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4 ">
          <iframe class="w-100 mb-4" src="<?php echo $contact_r['iframe'] ?>" height="450" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <h5>Address</h5>
          <a href="<?php echo $contact_r['gmap'] ?>">
            <span" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-geo-alt-fill me-2"></i><?php echo $contact_r['address'] ?>
              </span>
          </a>
          <div class="bg-white p-0 mt-2 rounded">
            <h5>Call Us</h5>
            <a href="tel: +919874563210" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone me-2"></i>+<?php echo $contact_r['pno'] ?></a>
          </div>
          <div class="bg-white p-0 mt-2 rounded">
            <h5>Contact Us</h5>
            <span" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope me-2"></i><?php echo $contact_r['email'] ?></span>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-mg-6  px-4 ">
        <div class="p-4 bg-white rounded shadow">
          <form method="POST">
            <h5>Send a message</h5>
            <div class="col-md-12 ps-0  mb-3 mt-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="col-md-12 ps-0  mb-3 mt-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-md-12 ps-0  mb-3 mt-3">
              <label class="form-label">Subject</label>
              <input type="text" class="form-control" name="subject" required>
            </div>
            <div class="col-md-12 ps-0  mb-3 mt-3">
              <label class="form-label">Message</label>
              <textarea class="form-control" rows="5" aria-label="With textarea" name="message" required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" name="send" class="btn btn-primary shadow-none">Send<i class="bi bi-arrow-right-circle ms-2"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
    if (isset($_POST['send'])) {
      $frm_data=Filteration($_POST);
      $q="INSERT INTO `user_contact_us`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
      $values=[$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];
      $res=insert($q,$values,'ssss');
      if($res==1){
        alert('success','Message Successfully Sent');
      }else{
        alert('danger','Server Down, Try again..!');
        
      }
    }
  ?>

  <!-- footer -->
  <?php require('commonPage/footer.php'); ?>


</body>

</html>