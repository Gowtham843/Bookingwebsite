<?php
require('inc/essential.php');
require('inc/db_config.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel -New Bookings</title>
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
                <h3 class="mb-4">New Bookings</h3>

                <!-- Features Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search bookings..." />
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover border text-center" style="min-width: 1200px;">
                                <thead">
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room details</th>
                                        <th scope="col">Bookings Details</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="newb_data">

                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Assign room Modal -->
    <div class="modal fade" id="assign_room-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Assign Room</h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-4">Room Number</label>
                            <input type="text" name="room_no" class="form-control" required>
                        </div>
                        <span class="badge text-bg-light mb-3 text-wrap lh-base">
                            Note: Assign Room When User Confirms the Booking**
                        </span>
                        <input type="hidden" name="booking_id">

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary text-white shadow-none">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    require('inc/script.php');
    ?>

    <script>
        function get_bookings(search = '') {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/newbookingsdetails.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {

                document.getElementById('newb_data').innerHTML = xhr.responseText;

            }
            xhr.send('get_bookings&search=' + search);
        }

        let assign_room_form = document.getElementById('assign_room_form');

        function assign_room(id) {
            assign_room_form.elements['booking_id'].value = id;
        }
        assign_room_form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Create a FormData object and append our data to it.
            let fd = new FormData();
            fd.append('room_no', assign_room_form.elements['room_no'].value);
            fd.append('booking_id', assign_room_form.elements['booking_id'].value);
            fd.append('assign_room', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/newbookingsdetails.php", true)


            xhr.onload = function() {
                var assign_room = document.getElementById('assign_room-s');
                var assign_roomModelControl = bootstrap.Modal.getInstance(assign_room);
                assign_roomModelControl.hide();

                if (this.responseText == 1) {
                    alertScript('success', "Room number allowed");
                    Facilities_s_form.reset();
                    get_bookings();

                } else {
                    alertScript('danger', "Error...!, Server Error,Please try later");
                }

            }
            xhr.send(fd);

        })


        function cancel_booking(userid) {

            if (confirm("Are you sure you want to Cancel this booking")) {
                let fd = new FormData();
                fd.append('booking_id', userid);
                fd.append('cancel_booking', '');

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/newbookingsdetails.php", true);


                xhr.onload = function() {
                    //    send data to html
                    if (this.responseText == '1') {
                        alertScript('success', "Cancelled booking");
                        get_bookings();
                    } else {
                        alertScript('danger', "Error...!, Server Error,Please try later");

                    }
                }
                xhr.send(fd);
            }

        }



        window.onload = function() {
            get_bookings();
        }
    </script>

</body>

</html>