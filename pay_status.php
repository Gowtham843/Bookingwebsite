<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('commonPage/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> -Rooms</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<style>
  .bg {
    background-color: #6c7bee;
    width: 480px;
    overflow: hidden;
    margin: 0 auto;
    box-sizing: border-box;
    padding: 40px;
    font-family: 'Roboto';
    margin-top: 20px;
    text-align: center;
  }

  .card {
    background-color: #fff;
    width: 100%;
    float: left;
    margin-top: 10px;
    border-radius: 5px;
    box-sizing: border-box;
    padding: 80px 30px 25px 30px;
    text-align: center;
    position: relative;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  }

  .card__success {
    position: absolute;
    top: -50px;
    left: 145px;
    width: 100px;
    height: 100px;
    border-radius: 100%;
    background-color: #60c878;
    border: 5px solid #fff;
  }

  .card__success i {
    color: #fff;
    line-height: 100px;
    font-size: 45px;
  }

  .card__msg {
    text-transform: uppercase;
    color: #55585b;
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 5px;
  }

  .card__submsg {
    color: #959a9e;
    font-size: 16px;
    font-weight: 400;
    margin-top: 0px;
  }

  .card__body {
    background-color: #f8f6f6;
    border-radius: 4px;
    width: 100%;
    margin-top: 30px;
    float: left;
    box-sizing: border-box;
    padding: 30px;
  }

  .card__avatar {
    width: 50px;
    height: 50px;
    border-radius: 100%;
    display: inline-block;
    margin-right: 10px;
    position: relative;
    top: 7px;
  }

  .card__recipient-info {
    display: inline-block;
  }

  .card__recipient {
    color: #232528;
    text-align: center;
    margin-bottom: 5px;
    font-weight: 600;
  }

  .card__email {
    color: #838890;
    text-align: center;
    margin-top: 0px;
  }

  .card__price {
    color: #232528;
    font-size: 70px;
    margin-top: 25px;
    margin-bottom: 30px;
  }

  .card__price span {
    font-size: 60%;
  }

  .card__method {
    color: #896e6e;
    text-transform: uppercase;
    text-align: left;
    font-size: 11px;
    margin-bottom: 5px;
  }

  .card__payment {
    background-color: #fff;
    border-radius: 4px;
    width: 100%;
    height: 100px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .card__credit-card {
    width: 50px;
    display: inline-block;
    margin-right: 15px;
  }

  .card__card-details {
    display: inline-block;
    text-align: left;
  }

  .card__card-type {
    text-transform: uppercase;
    color: #232528;
    text-align: center;
    font-weight: 600;
    font-size: 12px;
    margin-bottom: 3px;
  }

  .card__card-number {
    color: #838890;
    text-align: center;
    font-size: 12px;
    margin-top: 0px;
  }

  .card__tags {
    clear: both;
    padding-top: 15px;
  }

  .card__tag {
    text-transform: uppercase;
    background-color: #f8f6f6;
    box-sizing: border-box;
    padding: 3px 5px;
    border-radius: 3px;
    font-size: 10px;
    color: #d3cece;
  }
</style>

<body>
  <?php
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
  redirect('rooms.php');
}
  $frm_data = Filteration($_GET);
  $user_query = "SELECT `name`, `email` FROM `user_credit` WHERE `sr_no`=?";
  $stmt = mysqli_prepare($con, $user_query);
  mysqli_stmt_bind_param($stmt, "i", $_SESSION['uid']);
  mysqli_stmt_execute($stmt);
  $user_res = mysqli_stmt_get_result($stmt);
  $user_fetch = mysqli_fetch_assoc($user_res);

  ?>
  <div class="bg">

    <div class="card">

      <span class="card__success"><i class="bi bi-check-lg"></i></span>

      <h1 class="card__msg">Payment Complete</h1>
      <h2 class="card__submsg">Thank you for your transfer</h2>

      <div class="card__body">


        <div class="card__recipient-info">
          <p class="card__recipient"><?php echo $user_fetch['name'] ?></p>
          <p class="card__email"><?php echo $user_fetch['email'] ?></p>
        </div>

        <h1 class="card__price"><span>₹</span><?php echo $frm_data['amount'] / 100 ?><span>.00</span></h1>

        <p class="card__method">Payment method</p>
        <div class="card__payment">

          <div class="card__card-details">
            <p class="card__card-type"><?php echo $frm_data['type'] ?></p>
           
            <p class="card__card-number"><?php echo $frm_data['tid'] ?></p>
          </div>
        </div>

      </div>

      <div class="card__tags">
        <span class="card__tag">completed</span>
        <span class="card__tag"><?php echo $frm_data['order'] ?></span>
      </div>
      <button class="btn btn-primary shadow-none mt-2"><a href="bookings.php" class="text-light">Go to bookings</a></button>
     
    </div>

  </div>
</body>

</html>