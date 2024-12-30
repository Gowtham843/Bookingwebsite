<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essential.php');

date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['info_form'])) {
    $frm_data = Filteration($_POST);
    session_start();

    // Getting users details
    $check_users = select("SELECT * FROM `user_credit` WHERE `number`=? AND `sr_no`!=? LIMIT 1", [$frm_data['phone'], $_SESSION['uid']], 'si');
    if (mysqli_num_rows($check_users) != 0) {
        echo 'Number already used';
        exit;
    }
    $query = "UPDATE `user_credit` SET `name`=?,`address`=?,`number`=?,`pincode`=?,`dob`=? WHERE `sr_no`=?";
    $values = [$frm_data['name'], $frm_data['address'], $frm_data['phone'], $frm_data['pincode'], $frm_data['dob'], $_SESSION['uid']];
    if (update($query, $values, 'sssssi') == 1) {
        $_SESSION['uname'] = $frm_data['name'];
        echo 1;
    } else {
        echo 0;
    }
}


if (isset($_POST['pic_form'])) {
    session_start();

    $image_res = uploadUserImage($_FILES['pic']);
    if ($image_res == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($image_res == 'Error_in_Uploading_the_file') {
        echo 'failed';
        exit;
    }




    // getting user image
    $check_users = select("SELECT `pic` FROM `user_credit` WHERE `sr_no`=? LIMIT 1", [$_SESSION['uid']], 'i');
    $u_fetch = mysqli_fetch_assoc($check_users);

    deleteImage($u_fetch['pic'], USERS_FOLDER);

    $query = "UPDATE `user_credit` SET `pic`=? WHERE `sr_no`=?";
    $values = [$image_res, $_SESSION['uid']];


    if (update($query, $values, 'si') == 1) {
        $_SESSION['upic'] = $image_res;
        echo 1;
    } else {
        echo 0;
    }
}


if (isset($_POST['pass_form'])) {
    $frm_data = Filteration($_POST);
    session_start();

    $check_users = select("SELECT `pass` FROM `user_credit` WHERE `sr_no`=? LIMIT 1", [$_SESSION['uid']], 'i');

    if (mysqli_num_rows($check_users) == 0) {
        echo "User_doesn't_exist";
        exit;
    }
     else {
        $users_fetch = mysqli_fetch_assoc($check_users);
        if (!password_verify($frm_data['opassword'], $users_fetch['pass'])) {
            echo "Invalidpass";
            exit;
        }

        $enc_pass = password_hash($frm_data['password'], PASSWORD_BCRYPT);

        $query = "UPDATE `user_credit` SET `pass`=? WHERE `sr_no`=? LIMIT 1";
        $values = [$enc_pass, $_SESSION['uid']];
        if (update($query, $values, 'si') == 1) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
