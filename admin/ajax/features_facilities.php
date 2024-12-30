<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();


if (isset($_POST['add_Feature'])) {
    $frm_data = Filteration($_POST);

    $q = "INSERT INTO `features`(`name`) VALUES (?)";
    $v = [$frm_data['name']];
    // Insert is function which is create in db_config.php
    $res = insert($q, $v, 's');
    echo $res;
}

if (isset($_POST['get_Feature'])) {
    // select all function is there in dbconfig, it will select all the information in the table;
    $res = selectAll('features');
    $i = 1;
    while ($row = mysqli_fetch_assoc($res)) {

        echo <<<data
        <tr>
        <td>$i</td>
        <td>$row[name]</td>
        <td><button class="btn btn-danger btn-sm"  onclick="del_features($row[sr_no])">Delete
        <i class="bi bi-trash"></i>
          </button></td>
        </tr>
        
    data;
        $i++;
    }
}


if (isset($_POST['del_features'])) {
    $frm_data = Filteration($_POST);
    $v = [$frm_data['del_features']];

    $check_q=select("SELECT * FROM `rooms_features` WHERE `features_id`=?",[$frm_data['del_features']],'i');
    if(mysqli_num_rows($check_q)==0){
    $q = "DELETE FROM `features` WHERE  `sr_no`=? ";
        $res = delete($q, $v, 'i');
        echo $res;
    }else{
        echo"room_added";
    }

  
}


if (isset($_POST['add_facilities'])) {
    $frm_data = Filteration($_POST);
    $image_res = uploadsvgImage($_FILES['icon'], FACILITIES_FOLDER);
    if ($image_res == 'inv_img') {
        echo 'inv_img';
    } else if ($image_res == 'Image_size_is_more') {
        echo $image_res;
    } else if ($image_res == 'Error_in_Uploading_the_file') {
        echo $image_res;
    } else {
        $q = "INSERT INTO `facilities`( `icon`, `name`, `description`) VALUES (?,?,?)";
        $v = [$image_res, $frm_data['name'], $frm_data['description']];

        // Insert is function which is create in db_config.php
        $res = insert($q, $v, 'sss');
        echo $res;
    }
}


if (isset($_POST['get_facilities'])) {
    // select all function is there in dbconfig, it will select all the information in the table;
    $res = selectAll('facilities');
    $i = 1;
    $path = FACILITIES_IMG_PATH;
    while ($row = mysqli_fetch_assoc($res)) {

        echo <<<data
        <tr class="align-middle">
        <td>$i</td>
        <td><img src="$path$row[icon]" width="50px"></td>
        <td>$row[name]</td>
        <td>$row[description]</td>
        <td><button class="btn btn-danger btn-sm"  onclick="del_facilities($row[sr_no])">Delete
        <i class="bi bi-trash"></i>
          </button></td>
        </tr>
        
    data;
        $i++;
    }
}


if (isset($_POST['del_facilities'])) {
    $frm_data = Filteration($_POST);
    $v = [$frm_data['del_facilities']];

    $check_q=select("SELECT * FROM `rooms_facilities` WHERE `facilities_id`=?",[$frm_data['del_facilities']],'i');
    if(mysqli_num_rows($check_q)==0){
        $pre_q = "SELECT * FROM `facilities` WHERE  `sr_no`=? ";
        $pre_res = select($pre_q, $v, 'i');
        $img = mysqli_fetch_assoc($pre_res);
        if (deleteImage($img['icon'], FACILITIES_FOLDER)) {
            $q = "DELETE FROM `facilities` WHERE  `sr_no`=? ";
            $res = delete($q, $v, 'i');
            echo $res;
        } else {
            echo 0;
        }
    }else{
        echo"room_added";
    }
   
}
