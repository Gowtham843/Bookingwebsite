<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php');?>
  <title><?php echo $settings_r['site_title']?> -FACILITIES</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
   .pop:hover{
    border-top-color: var(--teal) !important;
    transform: scale(1.03);
    transition: all 0.3s;
   }
  </style>
</head>

<body class="bg-light">
  <!-- Header -->
  <?php require('commonPage/header.php'); ?>


  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
    <?php echo $content_r['facilities_text'] ?>
    </p>
  </div>

  <div class="container">
    <div class="row">

  <?php 
   $res=selectAll('facilities');
   $path=FACILITIES_IMG_PATH;

   while($row=mysqli_fetch_assoc($res)){
    echo<<<data
      <div class="col-lg-4 col-mg-6 mb-5 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
        <div class="d-flex align-items-center mb-2">
          <img src="$path$row[icon]" alt="" width="40px">
          <h5 class="m-0 ms-3">$row[name]</h5>
        </div>
        <p>$row[description]</p>
      </div>
    </div>
    data;

   }
  ?>
      
   
    </div>
  </div>


  <!-- footer -->
 <?php require('commonPage/footer.php'); ?>


</body>

</html>