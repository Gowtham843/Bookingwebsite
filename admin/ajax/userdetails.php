<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();



if (isset($_POST['get_user'])) {
    $res = selectAll('user_credit');
    $i = 1;
    $path = USERS_IMG_PATH;


    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "<button type='button' class='btn text-light bg-danger opacity-80' onclick='delete_user($row[sr_no])'>
        <i class='bi bi-trash-fill'></i>
    </button>";

        $verified = " <span class='badge bg-warning text-dark p-2 fs-6'> <i class='bi bi-x-lg'></i> </span>";

        if ($row['is_verify']) {
            $verified = " <span class='badge bg-success p-2 fs-6'> <i class='bi bi-check-lg'></i> </span>";
            $del_btn = "";
        }

        if ($row['status'] == 1) {
            $status = "<button type='button' onclick='toggleStatus($row[sr_no],0)' class='btn btn-dark btn-sm'>Active</button>";
        } else {
            $status = "<button type='button' onclick='toggleStatus($row[sr_no],1)' class='btn btn-warning btn-sm'>Inactive</button>";
        }

        $date = date("d-m-Y", strtotime($row['datetime']));


        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td>
            <img src='$path$row[pic]' width='55px'>
            <br>
            $row[name]</td>
            <td>$row[email]</td>
            <td>$row[number]</td>
            <td>$row[address]| $row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
       

        </tr>
    ";
        $i++;
    }
    echo $data;
}


if (isset($_POST['toggleStatus'])) {
    $frm_data = Filteration($_POST);
    $q = "UPDATE `user_credit` SET `status`=? WHERE `sr_no`=?";
    $v = [$frm_data['value'], $frm_data['toggleStatus']];
    if (update($q, $v, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}


if (isset($_POST['delete_user'])) {
    $frm_data = Filteration($_POST);

    $res=delete("DELETE FROM `user_credit` WHERE `sr_no`=? AND `is_verify`=?",[$frm_data['userid'],0],'ii');

    if ($res ){
        echo 1;
    }else{
        echo 0;
    }


}


if (isset($_POST['search_user'])) {
    $frm_data=Filteration($_POST);

    $query="SELECT * FROM `user_credit` WHERE `name` LIKE ?";

    $res = select($query,["%$frm_data[name]%"],"s");
    $i = 1;
    $path = USERS_IMG_PATH;


    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn = "<button type='button' class='btn text-light bg-danger opacity-80' onclick='delete_user($row[sr_no])'>
        <i class='bi bi-trash-fill'></i>
    </button>";

        $verified = " <span class='badge bg-warning text-dark p-2 fs-6'> <i class='bi bi-x-lg'></i> </span>";

        if ($row['is_verify']) {
            $verified = " <span class='badge bg-success p-2 fs-6'> <i class='bi bi-check-lg'></i> </span>";
            $del_btn = "";
        }

        if ($row['status'] == 1) {
            $status = "<button type='button' onclick='toggleStatus($row[sr_no],0)' class='btn btn-dark btn-sm'>Active</button>";
        } else {
            $status = "<button type='button' onclick='toggleStatus($row[sr_no],1)' class='btn btn-warning btn-sm'>Inactive</button>";
        }

        $date = date("d-m-Y", strtotime($row['datetime']));


        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td>
            <img src='$path$row[pic]' width='55px'>
            <br>
            $row[name]</td>
            <td>$row[email]</td>
            <td>$row[number]</td>
            <td>$row[address]| $row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
       

        </tr>
    ";
        $i++;
    }
    echo $data;
}



?>