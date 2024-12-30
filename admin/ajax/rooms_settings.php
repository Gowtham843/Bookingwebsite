<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();

if (isset($_POST['add_rooms'])) {
    $features = Filteration(json_decode($_POST['features']));  //get features from post request and filter it to remove any harmful code
    $facilities = Filteration(json_decode($_POST['facilities']));  //get features from post request and filter it to remove any harmful code
    $frm_data = Filteration($_POST);

    $flag = 0;
    $q1 = "INSERT INTO `rooms`(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $v = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['description']];
    if (insert($q1, $v, 'siiiiis')) {
        $flag = 1;
    }

    $room_id = mysqli_insert_id($con); //get the last inserted id in room table
    $q2 = "INSERT INTO `rooms_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
    if ($stmt = mysqli_prepare($con, $q2)) {
        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die(mysqli_error($con));
    }
    $q3 = "INSERT INTO `rooms_features`(`rooms_id`, `features_id`) VALUES (?,?)";
    if ($stmt = mysqli_prepare($con, $q3)) {
        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die(mysqli_error($con));
    }

    if ($flag == 1) {
        echo 1;
    } else {
        echo 0;
    }
}


if (isset($_POST['get_rooms'])) {
    $res = select("SELECT * FROM `rooms` WHERE `removed`=?",[0],'i');
    $i = 1;
    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {

        if ($row['status'] == 1) {
            $status = "<button type='button' onclick='toggleStatus($row[sr_no],0)' class='btn btn-dark btn-sm'>Active</button>";
        } else {
            $status = "<button type='button' onclick='toggleStatus($row[sr_no],1)' class='btn btn-warning btn-sm'>Inactive</button>";
        }

        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td>$row[name]</td>
            <td>$row[area] sq.ft</td>
            <td>
            <span class='badge rounded-pill bg-light text-dark'>
                Adult: $row[adult]
            </span>
            <span class='badge rounded-pill bg-light text-dark'>
                Children: $row[children]
            </span>
            </td>
            <td>₹ $row[price]</td>
            <td>$row[quantity]</td>
            <td>$status</td>
            <td><button type='button' class='btn btn-lg bg-white bg-opacity-1' onclick='edit_details($row[sr_no])' data-bs-toggle='modal' data-bs-target='#editRooms-s'>
            <i class='bi bi-pencil-square'></i>
        </button>
            <button type='button' class='btn btn-lg bg-white bg-opacity-1' onclick=\"room_image($row[sr_no],'$row[name]')\"data-bs-toggle='modal' data-bs-target='#imageRooms-s'>
            <i class='bi bi-images'></i>
        </button>
            <button type='button' class='btn btn-lg bg-white bg-opacity-1' onclick='delete_room_image($row[sr_no])'>
            <i class='bi bi-trash-fill'></i>
        </button>
        </td>

        </tr>
    ";
        $i++;
    }
    echo $data;
}


if (isset($_POST['toggleStatus'])) {
    $frm_data = Filteration($_POST);
    $q = "UPDATE `rooms` SET `status`=? WHERE `sr_no`=?";
    $v = [$frm_data['value'], $frm_data['toggleStatus']];
    if (update($q, $v, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}


if (isset($_POST['getRoomdetails'])) {
    $frm_data = Filteration($_POST);
    $res1 = select('SELECT * FROM `rooms` WHERE `sr_no`=?', [$frm_data['getRoomdetails']], 'i');
    $res2 = select('SELECT * FROM `rooms_features` WHERE `rooms_id`=?', [$frm_data['getRoomdetails']], 'i');
    $res3 = select('SELECT * FROM `rooms_facilities` WHERE `room_id`=?', [$frm_data['getRoomdetails']], 'i');

    $roomdata = mysqli_fetch_assoc($res1);
    $features = [];
    $facilities = [];

    if (mysqli_num_rows($res2) > 0) {
        while ($row = mysqli_fetch_assoc($res2)) {
            array_push($features, $row['features_id']);
        }
    }
    if (mysqli_num_rows($res3) > 0) {
        while ($row = mysqli_fetch_assoc($res3)) {
            array_push($facilities, $row['facilities_id']);
        }
    }
    $data = ["roomdata" => $roomdata, "features" => $features, "facilities" => $facilities];
    echo json_encode($data);
}


if (isset($_POST['UpdateEdit_rooms'])) {
    $features = Filteration(json_decode($_POST['features']));  //get features from post request and filter it to remove any harmful code
    $facilities = Filteration(json_decode($_POST['facilities']));  //get features from post request and filter it to remove any harmful code
    $frm_data = Filteration($_POST);

    $flag = 0;

    $delfeatures = delete("DELETE FROM `rooms_features` WHERE `rooms_id`=?", [$frm_data['room_id']], 'i');
    $delfacilities = delete("DELETE FROM `rooms_facilities` WHERE `room_id`=?", [$frm_data['room_id']], 'i');

    if (!($delfacilities && $delfeatures)) {
        $flag = 0;
    } else {

        $q1 = "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `sr_no`=?";
        $v = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['description'], $frm_data['room_id']];

        if (update($q1, $v, 'siiiiisi')) {
            $flag = 1;
        }



        $q2 = "INSERT INTO `rooms_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
        if ($stmt = mysqli_prepare($con, $q2)) {
            foreach ($facilities as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
                mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die(mysqli_error($con));
        }
        $q3 = "INSERT INTO `rooms_features`(`rooms_id`, `features_id`) VALUES (?,?)";
        if ($stmt = mysqli_prepare($con, $q3)) {
            foreach ($features as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
                mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die(mysqli_error($con));
        }

        if ($flag == 1) {
            echo 1;
        } else {
            echo 0;
        }
    }
}


if (isset($_POST['add_image'])) {
    $frm_data = Filteration($_POST);
    $image_res = uploadImage($_FILES['image'], ROOMS_FOLDER);
    if ($image_res == 'inv_img') {
        echo 'inv_img';
    } else if ($image_res == 'Image_size_is_more') {
        echo $image_res;
    } else if ($image_res == 'Error_in_Uploading_the_file') {
        echo $image_res;
    } else {
        $q = "INSERT INTO `room_image`(`room_id`, `image`) VALUES (?,?)";
        $v = [$frm_data['room_id'], $image_res];

        // Insert is function which is create in db_config.php
        $res = insert($q, $v, 'is');
        echo $res;
    }
}



if (isset($_POST['room_image'])) {
    $frm_data = Filteration($_POST);
    $res = select("SELECT * FROM `room_image` WHERE `room_id`=?", [$frm_data['room_image']], 'i');
    $path = ROOMS_IMG_PATH;

    while ($row = mysqli_fetch_assoc($res)) {
        if($row['thumb']==1){
            $thumb_btn="<button type='submit' class='btn btn-secondary text-white shadow-none'><i class='bi bi-toggle2-on'></i></button>";
        }else{
            $thumb_btn="<button onclick='thumb_image($row[sr_no],$row[room_id])' type='submit' class='btn btn-secondary text-white shadow-none'><i class='bi bi-toggle2-off'></i></button>";

        }
        echo <<<data
        <tr class='align-middle'>
            <td ><img src='$path$row[image]' class='img-fluid'></td>
            <td>$thumb_btn</td>
            <td><button onclick='delete_image($row[sr_no],$row[room_id])' type='submit' class='btn btn-danger text-white shadow-none'>Delete</button></td>
        </tr>
        data;
    }
}


if (isset($_POST['delete_image'])) {
    $frm_data = Filteration($_POST);
    $v = [$frm_data['image_id'], $frm_data['room_id']];

    $pre_q = "SELECT * FROM `room_image` WHERE  `sr_no`=? AND `room_id`=?";
    $res = select($pre_q, $v, 'ii');
    $img = mysqli_fetch_assoc($res);
    if (deleteImage($img['image'], ROOMS_FOLDER)) {
        $q = "DELETE FROM `room_image` WHERE `sr_no`= ? AND `room_id`=?";
        $res = delete($q, $v, 'ii');
        echo $res;
    } else {
        echo 0;
    }
}


if (isset($_POST['thumb_image'])) {
    $frm_data = Filteration($_POST);
    $pre_q="UPDATE `room_image` SET `thumb`=? WHERE `sr_no`=?";
    $upd_val=[0,$frm_data['image_id']];
    $pre_res=update($pre_q,$upd_val,'ii');

    $q="UPDATE `room_image` SET `thumb`=? WHERE `sr_no`=? AND `room_id`=?";
    $v=[1,$frm_data['image_id'],$frm_data['room_id']];
    $res=update($q,$v,"iii");

    echo $res;

}


if (isset($_POST['delete_room_image'])) {
    $frm_data = Filteration($_POST);
    $res1=select("SELECT * FROM `room_image` WHERE `room_id`=?",[$frm_data['room_id']],'i');

    while($row=mysqli_fetch_assoc($res1)){
        deleteImage($row['image'],ROOMS_FOLDER);
    }
    $res2=delete("DELETE FROM `room_image` WHERE `room_id`=?",[$frm_data['room_id']],'i');
    $res3=delete("DELETE FROM `rooms_features` WHERE `rooms_id`=?",[$frm_data['room_id']],'i');
    $res4=delete("DELETE FROM `rooms_facilities` WHERE `room_id`=?",[$frm_data['room_id']],'i');
    $res5=update("UPDATE  `rooms` SET `removed`=? WHERE `sr_no`=?",[1,$frm_data['room_id']],'ii');

    if ($res2 || $res3 || $res4 || $res5 ){
        echo 1;
    }else{
        echo 0;
    }


}

?>