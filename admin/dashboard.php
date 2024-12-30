<?php
require('inc/essential.php');
adminLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel -Dashboard</title>
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
                <h5 class="my-2" style="font-size: 40px;">DashBoard <span style="font-size: 18px;"><?php echo date('d M Y') ?></span> </h5>
                <div class="border bg-light p-3 mt-2 rounded mb-3">
                    <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size: 25px;">
                        <span>Checkout Notification </span>
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover border text-center" style="min-width: 1200px;max-height: 1200px;overflow-y: scroll;">
                            <thead">
                                <tr class="table-dark">
                                    <th scope="col">#</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Booking No</th>
                                    <th scope="col">Room No</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody id="newb_data">

                                </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 ms-auto p-4 overflow-hidden">
                <div class="border bg-light p-3 rounded mb-3 w-40">
                    <h5 class="mb-3" style="font-size: 18px;"></h5>
                    <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size: 25px;">
                        <span>User Active </span>
                    </h5>
                    <div class="card chart-container">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div </div>


            <?php
            require('inc/script.php');
            ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js">
            </script>

            <script>
                function get_checkout() {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/dashboard.php", true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {

                        document.getElementById('newb_data').innerHTML = xhr.responseText;

                    }
                    xhr.send('get_checkout');
                }

                function roomcleaned(id, e) {
                    e.preventDefault();

                    // Create a FormData object and append our data to it.
                    let fd = new FormData();

                    fd.append('booking_id', id);
                    fd.append('roomcleaned', '');

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/dashboard.php", true);


                    xhr.onload = function() {


                        if (this.responseText == 1) {
                            alertScript('success', "Noted");
                            get_checkout();

                        } else {
                            alertScript('danger', "Error...!, Server Error,Please try later");
                        }

                    }
                    xhr.send(fd);
                }

                function piechart() {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/dashboard.php", true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        let data;
                        try {
                            data = JSON.parse(xhr.responseText);
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                            // Handle parsing error gracefully
                        }

                        const ctx = document.getElementById("chart").getContext('2d');
                        const myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ["New Bookings", "Refund", "Checkout"],
                                datasets: [{
                                    label: 'Info',
                                    data: data,
                                    backgroundColor: ["#0074D9", "#FF4136", "#F012BE"]
                                }]
                            },
                        });

                    }
                    xhr.send('piechart');
                }

                window.onload = function() {
                    get_checkout();
                    piechart();
                }
            </script>

            <?php

            ?>


            <script>

            </script>
</body>

</html>