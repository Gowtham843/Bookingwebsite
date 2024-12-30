<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();



if (isset($_POST['get_checkout'])) {

    $frm_data = Filteration($_POST);

    $q = "SELECT * FROM `checkout`";
    $res = mysqli_query($con, $q);

    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No User Found</b>";
        exit;
    }

    while ($data = mysqli_fetch_array($res)) {

        $table_data .= "
            <tr>
            <td>$i</td>
            <td>
                <b> Name:  </b> $data[name]<br>
                <b> Phone:  </b> $data[pno]
            </td>
            <td>
                $data[booking_id]
                
             </td>
            <td>
                 $data[room_id]
                
            </td>
            <td>
                <button type='button' onclick='roomcleaned($data[booking_id],event)' class='btn text-white btn-success btn-sm fw-bold my-2'>
                 Room Cleaned <i class='bi bi-check2-all mx-2'></i>
                </button><br>
                
            </td>
            
            </tr>
        
        ";
        $i++;
    }
    echo $table_data;
}



if (isset($_POST['roomcleaned'])) {
    $frm_data = Filteration($_POST);

    $query = "DELETE FROM `checkout` WHERE `booking_id`=?";
    $values = [$frm_data['booking_id']];
    $res = delete($query, $values, 'i');
    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['piechart'])) {

    $queryn = "SELECT bo.*,bd.* FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
        WHERE bo.date_time = CURDATE()
        AND (bo.booking_status=? AND bo.arrival=?)
        ORDER BY bo.booking_id ASC";

    $resn = select($queryn, ["booked", 0], 'ss');
    $newbooking = mysqli_num_rows($resn);

    $queryr = "SELECT bo.*,bd.* FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
        WHERE bo.date_time = CURDATE()
        AND (bo.booking_status=? AND bo.refund=?)
        ORDER BY bo.booking_id ASC";

    $resr = select($queryr, ["cancelled", 0], 'ss');
    $refubooking = mysqli_num_rows($resr);

    $querycout = "SELECT bo.*,bd.* FROM `booking_order` bo
       INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
       WHERE ((bo.booking_status=? AND bo.arrival=1 AND bo.check_out = CURDATE()))
       ORDER BY bo.booking_id ASC";

    $resc = select($querycout, ['booked'], 's');
    $coutbooking = mysqli_num_rows($resc);




    $data = json_encode([$newbooking, $refubooking,$coutbooking]);
    echo $data;
}
