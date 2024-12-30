<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();



if (isset($_POST['add_image_Carousel'])) {

    $image_res = uploadImage($_FILES['picture'], CAROUSEL_FOLDER);
    if ($image_res == 'inv_img') {
        echo 'inv_img';
    } else if ($image_res == 'Image_size_is_more') {
        echo $image_res;
    } else if ($image_res == 'Error_in_Uploading_the_file') {
        echo $image_res;
    } else {
        $q = "INSERT INTO `carousel`(`picture`) VALUES (?)";
        $v = [$image_res];
        // Insert is function which is create in db_config.php
        $res = insert($q, $v, 's');
        echo $res;
    }
}

if (isset($_POST['get_Image_Carousel'])) {
    // select all function is there in dbconfig, it will select all the information in the table;
    $res = selectAll('carousel');

    while ($row = mysqli_fetch_assoc($res)) {
        $path = CAROUSEL_IMG_PATH;
        echo <<<data
        <div class="col-md-6 mb-3">
        <div class="card bg-dark text-white">
            <img src="$path$row[picture]" class="card-img" >
            <div class="card-img-overlay text-end" onclick="del_image_Carousel($row[sr_no])">
                <button class="btn btn-danger btn-sm">
              <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
    data;
    }
}


if (isset($_POST['del_image_Carousel'])) {
    $frm_data = Filteration($_POST);
    $pre_q = "SELECT * FROM `carousel` WHERE  `sr_no`=? ";
    $v = [$frm_data['del_image_Carousel']];
    $res = select($pre_q, $v, 'i');
    $img = mysqli_fetch_assoc($res);
    if (deleteImage($img['picture'], CAROUSEL_FOLDER)) {
        $q = "DELETE FROM `carousel` WHERE `sr_no`= ?";
        $res = delete($q, $v, 'i');
        echo $res;
    } else {
        echo 0;
    }
}

?>