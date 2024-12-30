<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essential.php');
require('../PHPMailer/Exception.php');
require('../PHPMailer/SMTP.php');
require('../PHPMailer/PHPMailer.php');
date_default_timezone_set("Asia/Kolkata");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($email, $token,$type)
{
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    if($type=="email_confirm"){
        $page='email_confirm.php';
        $subject='Account Verification Link';
        $content='confirm your email';
    }else if($type=="account_recovery"){
        $page='index.php';
        $subject='Account Reset Link';
        $content='reset your account';

    }
    try {
        //Server settings

        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = USER_EMAIL;                     //SMTP username
        $mail->Password   = EMAIL_PASS;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom(USER_EMAIL, USER_NAME);
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "Click  the link to $content: <br> <a href='" . SITE_URL . "$page?$type&email=$email&token=$token" . "'>Click Me </a> ";

        $mail->send();
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}


if (isset($_POST['addUser'])) {
    $data = Filteration($_POST);

    // Checking cpass and pass is matching
    if ($data['pass'] != $data['cpass']) {
        echo 'pass no';
        exit;
    }

    // checking user already exists
    $check_users = select("SELECT * FROM `user_credit` WHERE `email`=? OR `number`=? LIMIT 1", [$data['email'], $data['number']], 'ss');
    if (mysqli_num_rows($check_users) != 0) {
        $check_users_fetch = mysqli_fetch_assoc($check_users);
        echo $check_users_fetch['email'] == $data['email'] ? 'Email already Used' : 'Number already used';
        exit;
    }

    // upload user image to server
    $image_res = uploadUserImage($_FILES['pic']);
    if ($image_res == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($image_res == 'Error_in_Uploading_the_file') {
        echo 'failed';
        exit;
    }

    // send confirmation link to user's email
    $token = bin2hex(random_bytes(16));
    if (!send_mail($data['email'], $token,"email_confirm")) {
        echo 'mail_send_failed';
        exit;
    }

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);
    $insert_query = "INSERT INTO `user_credit`(`name`, `email`, `address`, `number`, `pincode`, `dob`,`pic`, `pass`, `token`) 
  VALUES (?,?,?,?,?,?,?,?,?)";
    $values = [$data['name'], $data['email'], $data['address'], $data['number'], $data['pincode'], $data['dob'], $image_res, $enc_pass, $token];
    if (insert($insert_query, $values, 'sssssssss')) {
        echo 1;
    } else {
        echo 'ins_failed';
    }
}

if (isset($_POST['loginUser'])) {

    $data = Filteration($_POST);

    // checking user already exists
    $check_users = select("SELECT * FROM `user_credit` WHERE `email`=? OR `number`=? LIMIT 1", [$data['email_no'], $data['email_no']], 'ss');
    if (mysqli_num_rows($check_users) == 0) {
        echo "User_doesn't_exist";
        exit;
    }else{
        $users_fetch = mysqli_fetch_assoc($check_users);
        if ($users_fetch['is_verify']==0) {
            echo "Account_is_Not_verified";
        }
        else if ($users_fetch['status']==0) {
            echo "Account_as_been_banned";
        }else{
            if (!password_verify($data['pass'],$users_fetch['pass'])) {
                echo "Invalidpass";
            }else{
                session_start();
                $_SESSION['login']=true;
                $_SESSION['uid']=$users_fetch['sr_no'];
                $_SESSION['uname']=$users_fetch['name'];
                $_SESSION['upic']=$users_fetch['pic'];
                $_SESSION['unumber']=$users_fetch['number'];
                echo 1;
            }
        }
    } 
}


if (isset($_POST['forgotPasswordUser'])) {
    $data =Filteration($_POST);
    $check_users = select("SELECT * FROM `user_credit` WHERE `email`=? LIMIT 1", [$data['Forgot_email_no']], 's');
    if (mysqli_num_rows($check_users) == 0) {
        echo "User_doesn't_exist";
        exit;
    }else{
        $users_fetch = mysqli_fetch_assoc($check_users);
        if ($users_fetch['is_verify']==0) {
            echo "Account_is_Not_verified";
        }
        else if ($users_fetch['status']==0) {
            echo "Account_as_been_banned";
        }else{
            // send password reset to email
            $token=bin2hex(random_bytes(16));
            if(!send_mail($data['Forgot_email_no'],$token,"account_recovery")){
                echo 'mail_failed';
            }else{
                $date=date('Y-m-d');
                $u_q=mysqli_query($con,"UPDATE `user_credit` SET `token`='$token', `t_expire`='$date' WHERE `sr_no`='$users_fetch[sr_no]'");
                if($u_q){
                    echo 1;
                }else{
                    echo 'failed';
                }
            }
        }
    }

}


if (isset($_POST['resetPasswordUser'])) {
    $data =Filteration($_POST);
    $enc_pass =password_hash($data['newpass'],PASSWORD_BCRYPT);
    $u_q="UPDATE `user_credit` SET `pass`=?, `token`=?, `t_expire`=? WHERE `email`=? AND `token`=?";
    $values=[$enc_pass,null,null,$data['email'],$data['token']];

    if (update($u_q,$values,'sssss')) {
        echo 1;
    }else{
        echo 'failed';
    }

}

















?>