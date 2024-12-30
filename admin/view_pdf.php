<?php
require('inc/essential.php');
require('inc/db_config.php');
require('inc/mpdf/vendor/autoload.php');
adminLogin();


if (isset($_GET['gen_pdf']) && isset($_GET['bookid'])) {
    $frm_data = Filteration($_GET);
    $bookid = $frm_data['bookid']; // Assuming $frm_data is an array
    $query = "SELECT bo.*, bd.*, uc.email 
              FROM `booking_order` bo
              INNER JOIN `booking_details` bd ON bd.booking_id = bo.booking_id 
              INNER JOIN `user_credit` uc ON bo.user_id = uc.sr_no
              WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
              OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
              OR (bo.booking_status = 'pending'))
              AND bo.booking_id = '$bookid'"; // Add closing quote after $bookid

    $res = mysqli_query($con, $query);

    $total_rows = mysqli_num_rows($res);

    if ($total_rows == 0) {
        echo "<b><center>NOT ALLOWED</center></b>";
        exit;
    }

    $data = mysqli_fetch_assoc($res);

    $date = date("h:ia", strtotime($data['date_time']));
    $date1 = date("d-m-Y", strtotime($data['date_time']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));

    $table_data = "
    <style>
    
@import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap');

* {

  font-family: 'Source Sans Pro', sans-serif;
}

.container1 {
  display: block;
  width: 100%;
  background: #fff;
  max-width: 350px;
  padding: 25px;
  margin: 20px auto 0;
  box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
}

.receipt_header {
  padding-bottom: 10px;
  border-bottom: 1px dashed #000;
  text-align: center;
}

.receipt_header h1 {
  font-size: 20px;
  margin-bottom: 5px;
  text-transform: uppercase;
}

.receipt_header h1 span {
  display: block;
  font-size: 25px;
}

.receipt_header h2 {
  font-size: 14px;
  color: #727070;
  font-weight: 300;
}

.receipt_header h2 span {
  display: block;
}

.receipt_body {
  margin-top: 20px;
}

.table1 {
  width: 100%;
  margin-bottom: 20px;
}

.thead1,
.tfoot1 {
  position: relative;
}

.thead1 th:not(:last-child) {
  text-align: left;
}

.thead1 th:last-child {
  text-align: right;
}

.thead1::after {
  content: '';
  width: 100%;
  border-bottom: 1px dashed #000;
  display: block;
  position: absolute;
}

.tbody1 td:not(:last-child),
.tfoot1 td:not(:last-child) {
  text-align: left;
}

.tbody1 td:last-child,
.tfoot1 td:last-child {
  text-align: right;
}

.tbody1 tr:first-child td {
  padding-top: 15px;
}

.tbody1 tr:last-child td {
  padding-bottom: 15px;
}

.tfoot1 tr:first-child td {
  padding-top: 15px;
}

.tfoot1::before {
  content: '';
  width: 100%;
  border-top: 1px dashed #000;
  display: block;
  position: absolute;
}

.tfoot1 tr:first-child td:first-child,
.tfoot1 tr:first-child td:last-child {
  font-weight: bold;
  font-size: 20px;
}


.date_time_con {
  display: flex;
  justify-content: center;
  column-gap: 25px;
}

.items {
  margin-top: 25px;
}

.container1 h3 {
  border-top: 1px dashed #000;
  padding-top: 10px;
  margin-top: 25px;
  text-align: center;
  text-transform: uppercase;
}
    
    </style>
    <div class='container1'>
    <div class='receipt_header'>
    <h1>Receipt of booking <span>Dequeue</span></h1>
    <h2>Address: Lorem Ipsum, 1234-5 <span>Tel: +1 012 345 67 89</span></h2>
    </div>
    
    <div class='date_time_con' style='margin-top:10px;'>
        <div class='date'>Date:</div>
        <div class='date'>$date</div>
        </div>
        <div class='date_time_con'>
        <div class='time'>Time:</div>
        <div class='time'>$date1</div>
    </div>
    <div class='receipt_body'>

        <div style='text-align:center;' class='my-1'>Order Id: $data[order_id]</div>
        <div style='text-align:center;' class='my-1'>Name: $data[username]</div>
        <div style='text-align:center;' class='my-1'>Phone: $data[phone]</div>
        <div style='text-align:center;' class='my-1'>Email: $data[email]</div>
        <div style='text-align:center;' class='my-1'>Address: $data[address]</div>
    
       
        <div class='items'>
            <table class='table1'> 
                <thead class='thead1'>
                    <th>Room Name:</th>
                    <th></th>
                    <th>Cost</th>
                </thead>
        
                <tbody class='tbody1'>
                    <tr>
                        <td> $data[room_name]</td>
                        <td></td>
                        <td > ₹$data[price] per night</td>
                    </tr>
                </tbody>
                </table>

                <table class='table1'> 
                    <thead class='thead1'>
                        <th>Check In</th>
                        <th></th>  
                        <th>Check out</th>
                    </thead>
            
                    <tbody class='tbody1'>
                        <tr>
                            <td> $checkin</td>
                         <td></td>
                            <td>$checkout</td>
                        </tr>
                    </tbody>

                <tfoot class='tfoot1'>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td>$data[total_pay]</td>
                    </tr>
                    <tr><td >Status:</td><td></td><td> $data[booking_status]</td></tr>
                </tfoot>
            </table>
        </div>
    </div>
    <h3>Thank You!</h3>
</div>
    ";

    echo $table_data;
} else {
    echo "<b><center>NOT ALLOWED TO THIS PAGE 404...!</center></b>";
}
