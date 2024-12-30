<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();

if (isset($_POST['get_general'])) {
    $q = "Select * from `setings` where `sr_no` =?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    $jsonData = json_encode($data);
    echo $jsonData;
}


if (isset($_POST['upd_general'])) {
    $frm_data = Filteration($_POST);
    $q = "UPDATE `setings` SET `site_title`=?,`site_about`=? WHERE `sr_no`=?";
    $v = [$frm_data['site_title'], $frm_data['site_about'], 1];
    $res = update($q, $v, 'ssi');
    echo $res;
}


if (isset($_POST['upd_shutdown'])) {
    $frm_data = ($_POST['upd_shutdown'] == 0) ? 1 : 0;
    $q = "UPDATE `setings` SET `shutdown`=? WHERE `sr_no`=?";
    $v = [$frm_data, 1];
    $res = update($q, $v, 'ii');
    echo $res;
}

//content text
if (isset($_POST['get_content'])) {
    $q = "Select * from `content_text` where `sr_no` =?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    $jsonData = json_encode($data);
    echo $jsonData;
}

if (isset($_POST['upd_content'])) {
    $frm_data = Filteration($_POST);
    $q = "UPDATE `content_text` SET `facilities_text`=? , `contact_text`=? , `about_text`=? , `about_b_text`=? WHERE `sr_no`=?";
    $v = [$frm_data['facilities_text'], $frm_data['contact_text'],$frm_data['about_text'],$frm_data['about_b_text'], 1];
    $res = update($q, $v, 'ssssi');
    echo $res;
}


// get contact 

if (isset($_POST['get_contacts'])) {
    $q = "Select * from `contact` where `sr_no` =?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    $jsonData = json_encode($data);
    echo $jsonData;
}

if (isset($_POST['upd_contact'])) {
    $frm_data = Filteration($_POST);
    $q = "UPDATE `contact` SET `address`=?,`gmap`=?,`pno`=?,`email`=?,`tl`=?,`fl`=?,`il`=?,`iframe`=? WHERE `sr_no`=?";
    $v = [$frm_data['address'], $frm_data['gmap'], $frm_data['pno'], $frm_data['email'], $frm_data['tl'], $frm_data['fl'], $frm_data['il'], $frm_data['iframe'], 1];
    $res = update($q, $v, 'ssssssssi');
    echo $res;
}

if (isset($_POST['add_member'])) {
    $frm_data = Filteration($_POST);
    $image_res = uploadImage($_FILES['picture'], ABOUT_FOLDER);
    if ($image_res == 'inv_img') {
        echo 'inv_img';
    } else if ($image_res == 'Image_size_is_more') {
        echo $image_res;
    } else if ($image_res == 'Error_in_Uploading_the_file') {
        echo $image_res;
    } else {
        $q = "INSERT INTO `team_details`(`name`, `picture`) VALUES (?,?)";
        $v = [$frm_data['name'], $image_res];

        // Insert is function which is create in db_config.php
        $res = insert($q, $v, 'ss');
        echo $res;
    }
}

if (isset($_POST['get_members'])) {
    // select all function is there in dbconfig, it will select all the information in the table;
    $res = selectAll('team_details');

    while ($row = mysqli_fetch_assoc($res)) {
        $path=ABOUT_IMG_PATH;
        echo <<<data
        <div class="col-md-2 mb-3">
        <div class="card bg-dark text-white">
            <img src="$path$row[picture]" class="card-img" >
            <div class="card-img-overlay text-end" onclick="del_member($row[sr_no])">
                <button class="btn btn-danger btn-sm">
              <i class="bi bi-trash"></i>
                </button>
            </div>
            <p class="card-text text-center px-3 py-3">$row[name]</p>
        </div>
    </div>
    data;
    }
}


if (isset($_POST['del_member'])) {
    $frm_data = Filteration($_POST);
    $pre_q = "SELECT * FROM `team_details` WHERE  `sr_no`=? ";
    $v = [$frm_data['del_member']];
    $res = select($pre_q, $v, 'i');
    $img=mysqli_fetch_assoc($res);
    if (deleteImage($img['picture'],ABOUT_FOLDER)) {
        $q = "DELETE FROM `team_details` WHERE `sr_no`= ?";
        $res=delete($q,$v,'i');
        echo $res;
    }else{
        echo 0;
    }
}