<?php
  require('inc/essential.php');
  require('inc/db_config.php');
  session_start();
  if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
    echo"<script>
        window.location.href='dashboard.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin -Panel</title>
    <?php require('inc/commonLinks.php');?>
    <link rel="stylesheet" href="inc/same.css">
    <style>
        .login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 30%;
        }
    </style>
</head>
<body class="bg-light">

    <div class="login-form text-center rounded bg-white shadow overflow-hidden ">
        <form method="POST">
            <h4 class="bg-dark text-white py-3"> Admin Login Panel</h4>
            <div class="p-4">
            <div class="mb-3">
              <input name="admin_name" required type="text" class="form-control text-center" placeholder="Admin Name">
            </div>
            <div class="mb-3">
              <input name="admin_pass" required type="password" class="form-control text-center" placeholder="Admin Password">
            </div>
              <button type="submit" name="login" class="btn btn-warning text-white">Login</button>
          </div>
        </form>
    </div>
    <?php 
    if (isset($_POST['login'])) {

      $frm_data=Filteration($_POST);
      
    
      $query="SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
      $values = [$frm_data['admin_name'],$frm_data['admin_pass']];
    

      $res=select($query,$values,"ss");
      if($res->num_rows==1){
            $row=mysqli_fetch_assoc(
              $res
            );
       
            $_SESSION['adminLogin']=true;
            $_SESSION['adminID']=$row['sr_no'];
            redirect('dashboard.php');
      }else{
          alert('danger','Login Falied - Invalid Credentials!');
      }
  
    }

    ?>
    

<?php require('inc/script.php');?>
</body>
</html>