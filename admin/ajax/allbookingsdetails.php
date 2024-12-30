<?php
require('../inc/db_config.php');
require('../inc/essential.php');
adminLogin();



if (isset($_POST['get_bookings'])) {

    $frm_data = Filteration($_POST);

    $limit = 2; // limit for pagination
    $page = $frm_data['page'];  // get the 'page' variable
    $start = ($page - 1) * $limit; // get the 'start' variable for querying the database, it should be ($page-1)*$rows+1 means (1-1)*10=10 start=0



    $query = "SELECT bo.*,bd.* FROM `booking_order` bo
   INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
   WHERE ((bo.booking_status='booked' AND bo.arrival=1)
   OR (bo.booking_status='cancelled' AND bo.refund=1)
   OR (bo.booking_status='pending'))AND
   (bo.order_id LIKE ? OR bd.phone LIKE ? OR bd.address LIKE ? OR bd.username LIKE ?) 
   ORDER BY bo.booking_id DESC";

    $res = select(
        $query,
        ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%"],
        'ssss'
    );

    $limit_query = $query . " LIMIT $start,$limit";
    $limit_res = select(
        $limit_query,
        ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%"],
        'ssss'
    );

    $i = $start+1;
    $table_data = "";

    $total_rows = mysqli_num_rows($res);

    if ($total_rows == 0) {
        $output = json_encode(['table_data' => '<b>No User Found</b>', 'pagination' => '']);
        echo $output;
        exit;
    }

    while ($data = mysqli_fetch_array($limit_res)) {
        $date = date("d-m-Y", strtotime($data['date_time']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        if ($data['booking_status'] == 'booked') {
            $status_bg = 'bg-success';
        } else if ($data['booking_status'] == 'cancelled') {
            $status_bg = 'bg-danger';
        } else if ($data['booking_status'] == 'pending') {
            $status_bg = 'bg-warning text-dark';
        }

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
                <b>Price :</b> ₹$data[price]
             </td>
            <td>
                <b>Amount :</b> ₹$data[trans_amount]<br>
                <b>Date :</b> $date
            </td>
            <td>
                <span class='badge $status_bg p-2 mt-3'>$data[booking_status]</span>
            </td>
            <td>
                <button type='button' onclick='download($data[booking_id])' class='btn text-white btn-sm fw-bold bg-info mt-2' data-bs-toggle='modal' data-bs-target='#assign_room-s'>
                    <i class='bi bi-file-pdf-fill ' style='margin-right:10px'></i>Download
                </button><br>
                <button type='button' onclick='view($data[booking_id])' class='btn text-white btn-sm fw-bold bg-info mt-1' data-bs-toggle='modal' data-bs-target='#assign_room-s'>
                    <i class='bi bi-eye-fill' style='margin-right:10px'></i>View
                </button><br>
                
            </td>
            
            </tr>
        
        ";
        $i++;
    }

    $pagination = "";
    if ($total_rows > $limit) {
        $total_pages = ceil($total_rows / $limit);
        $disabled=($page==1)?"disabled":"";
        $prev=$page-1;
        $next=$page+1;
        $pagination .= "<li class='page-item  $disabled'>
        <button class='page-link' onclick='change_page($prev)'>
          <span aria-hidden='true'>&laquo;</span>
        </button>
      </li>";


        $pagination .= "<li class='page-item'>
        <button class='page-link'>
          <span aria-hidden='true'>$page</span>
        </button>
      </li>";
      
      

      $disabled=($page==$total_pages)?"disabled":"";
      $pagination .= "<li class='page-item $disabled'>
      <button class='page-link' onclick='change_page($next)' >
        <span aria-hidden='true'>&raquo;</span>
      </button>
    </li>";
    }

    $output = json_encode(["table_data" => $table_data, "pagination" => $pagination]);
    echo $output;
}
