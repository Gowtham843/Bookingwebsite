<?php
require('inc/essential.php');
require('inc/db_config.php');
adminLogin();

if (isset($_GET['seen'])) {
    $frm_data=Filteration($_GET);
    if ($frm_data['seen']=='all') {
        $q="UPDATE `raing_review` SET `seen`=?";
        $values=[1];
        if (update($q,$values,'i')) {
            alert('success','Marked all as read');
        }else{
            alert('danger','Operation failed');
        }
    }else{
        $q="UPDATE `raing_review` SET `seen`=? WHERE `sr_no`=?";
        $values=[1,$frm_data['seen']];
        if (update($q,$values,'ii')) {
            alert('success','Marked as read');
        }else{
            alert('danger','Operation failed');
        }
    }
}
if (isset($_GET['delete'])) {
    $frm_data=Filteration($_GET);
    if ($frm_data['delete']=='all') {
        
        $q="DELETE FROM `raing_review`";
        
        if (mysqli_query($con,$q)) {
            alert('success','All Data Deleted successfully');
        }else{
            alert('danger','Operation failed');
        }
    }else{
        $q="DELETE FROM `raing_review` WHERE `sr_no`=?";
        $values=[$frm_data['delete']];
        if (delete($q,$values,'i')) {
            alert('success','Data deleted successfully');
        }else{
            alert('danger','Operation failed');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel -Rate & review</title>
    <?php
    require('inc/commonLinks.php');
    ?>
    <link rel="stylesheet" href="inc/same.css">
</head>

<body class="bg-light">
    <?php
    require('inc/header.php');
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Rate & review</h3>

                <!-- User Contact Data Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                        <a href='?seen=all' class='btn btn-dark rounded-pill btn-primary'>Mark all as read</a>
                        <a href='?delete=all' class='btn btn-danger rounded-pill btn-primary'>Delete all</a>
                        </div>
                        <div class="table-responsive-md" style="height: 570px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Room Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col" width="30%">Review</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                   $q="SELECT rr.*,uc.name AS uname , r.name AS rname FROM `raing_review` rr
                                   INNER JOIN `user_credit` uc ON rr.user_id = uc.sr_no
                                   INNER JOIN `rooms` r ON rr.room_id = r.sr_no
                                   ORDER BY `sr_no` desc";

                                   $data=mysqli_query($con,$q);
                                   $i=1;
                                   while ($row=mysqli_fetch_assoc($data)) {
                                    $seen='';
                                    $date=date('d-m-y',strtotime($row['datetime']));
                                    if($row['seen']!=1){
                                        $seen="<a href='?seen=$row[sr_no]' class='btn btn-sm  btn-primary mx-2 '><i class='bi bi-check2-all'></i></a>";
                                    }
                                    $seen.="<a href='?delete=$row[sr_no]' class='btn btn-sm  btn-danger mx-2 '><i class='bi bi-trash'></i></a>";
                                    echo<<<data
                                    <tr>
                                        <td>$i</td>
                                        <td>{$row['rname']}</td>
                                        <td>{$row['uname']}</td>
                                        <td>{$row['rating']}</td>
                                        <td>{$row['review']}</td>
                                        <td>$date</td>
                                        <td>$seen</td>
                                    </tr>
                                    data;
                                    $i++;
                                   }
                                   ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php
    require('inc/script.php');
    ?>

</body>

</html>