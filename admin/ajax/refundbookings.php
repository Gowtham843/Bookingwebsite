<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();



if (isset($_POST['get_bookings'])) {

    $frm_data = Filteration($_POST);

    $query = "SELECT bo.*,bd.* FROM `booking_order` bo
   INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
   WHERE (bo.order_id LIKE ? OR bd.phone LIKE ? OR bd.address LIKE ? OR bd.username LIKE ?) 
   AND (bo.booking_status=? AND bo.refund=?)
   ORDER BY bo.booking_id ASC";



    $res = select(
        $query,
        ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "cancelled", 0],
        'ssssss'
    );
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No User Found</b>";
        exit;
    }

    while ($data = mysqli_fetch_array($res)) {
        $date = date("d-m-Y", strtotime($data['date_time']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $table_data .= "
            <tr>
            <td>$i</td>
            <td>
                <span class='badge bg-primary'>
                Order ID: $data[order_id]
                </span><br>
                <b> Name:  </b> $data[username]<br>
                <b> Phone:  </b> $data[phone]
            </td>

            <td>
                <b>Room :</b> $data[room_name]<br>
                <b>Check-in :</b> $data[check_in]<br>
                <b>Check-out :</b> $data[check_out]<br>
                <b>Date :</b> $date
            </td>
            <td>
                <b> ₹$data[trans_amount]</b>
            </td>
            <td>
                <button type='button' onclick='refund_booking($data[booking_id])' class='btn text-white btn-sm fw-bold bg-success pr-1' >
                    <i class='bi bi-cash-stack mx-2'></i>Refund Amount
                </button>
            </td>
            
            </tr>
        
        ";
        $i++;
    }
    echo $table_data;
}


if (isset($_POST['refund_booking'])) {
    $frm_data = Filteration($_POST);

    $query = "UPDATE `booking_order`SET  `refund`=? WHERE booking_id=?";
    $values = [ 1, $frm_data['booking_id']];
    $res = update($query, $values, 'ii');
    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}
