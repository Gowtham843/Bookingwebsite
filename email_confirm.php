<?php
require('admin/inc/db_config.php');
require('admin/inc/essential.php');

if (isset($_GET['email_confirm'])) {
    $data = Filteration($_GET);
    $query = select("SELECT * FROM `user_credit` WHERE `email`=? AND `token`=? LIMIT 1", [$data['email'], $data['token']], 'ss');
    if (mysqli_num_rows($query) == 1) {
        $row = mysqli_fetch_assoc($query);
        if ($row['is_verify'] == 1) {
            echo "<script>alert('Email already verified!');</script>";
        } else {
            $update_q = update("UPDATE `user_credit` SET `is_verify`=? WHERE `sr_no`=? ", [1, $row['sr_no']], 'ii');
            if ($update_q) {
                echo "<script>alert('Verification Successful! Please Login to Continue');</script>";
            } else {
                echo "<script>alert('Verification failed, Server Down');</script>";
            }
        }
        redirect('index.php');
    } else {
        echo "<script>alert('Invalid Link..!');</script>";
    }
}
?>
