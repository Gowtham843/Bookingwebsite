<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essential.php');
 
if (isset($_POST['checkoutclk'])) {
    $frm_data = Filteration($_POST);
    $q="INSERT INTO `checkout`( `name`, `pno`, `booking_id`, `room_id`) VALUES (?,?,?,?)";
    $v=[$frm_data['name'],$frm_data['phone'],$frm_data['book'],$frm_data['room']];
    $res=insert($q,$v,'ssis');
    if($res){
       $q1=" UPDATE `booking_details` SET `checkout`='1' WHERE `booking_id`=? ";
       $v1=[$frm_data['book']];
       $res1=update($q1,$v1,'i');
       if($res1){
        echo 1;
       }else{
        echo 0;
       }
    }else{

        echo 0;
    }
}


?>