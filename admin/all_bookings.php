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
    <title>Admin Panel -All Bookings</title>
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
                <h3 class="mb-4">All Bookings</h3>

                <!-- Features Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="get_bookings(this.value)" id="search_input" class="form-control shadow-none w-25 ms-auto" placeholder="Search bookings..." />
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover border text-center" style="min-width: 1200px;">
                                <thead">
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room details</th>
                                        <th scope="col">Bookings Details</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="newb_data">

                                    </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination" id="table_pagination">

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <?php
    require('inc/script.php');
    ?>

    <script>
        function get_bookings(search = '', page = 1) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/allbookingsdetails.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {

                document.getElementById('newb_data').innerHTML = JSON.parse(xhr.responseText).table_data;
                document.getElementById('table_pagination').innerHTML = JSON.parse(xhr.responseText).pagination;

            }
            xhr.send('get_bookings&search=' + search + '&page=' + page);
        }

        let assign_room_form = document.getElementById('assign_room_form');


        function change_page(page) {
           get_bookings(document.getElementById('search_input').value,page)
        }
        function download(id){
            window.location.href='generate_pdf.php?gen_pdf&bookid='+id;
        }
        function view(id){
            window.location.href='view_pdf.php?gen_pdf&bookid='+id;
        }


        window.onload = function() {
            get_bookings();
        }
    </script>

</body>

</html>