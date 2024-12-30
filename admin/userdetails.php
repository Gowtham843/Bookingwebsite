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
    <title>Admin Panel -Users</title>
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
                <h3 class="mb-4">Users</h3>

                <!-- Features Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search Users..." />
                        </div>


                        <div class="table-responsive">
                            <h3 id="nosearch" class="text-center mt-2" style="visibility: hidden;">No User Avaliable</h3>
                            <table class="table table-hover border text-center" id="user_display" style="min-width:1300px">
                                <thead">
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone No</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">DOB</th>
                                        <th scope="col">Verified</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="user_data">

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

    <script>
        function get_user() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/userdetails.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {

                document.getElementById('user_data').innerHTML = xhr.responseText;

            }
            xhr.send('get_user');
        }

        function toggleStatus(id, val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/userdetails.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            console.log(id, val)
            xhr.onload = function() {

                if (this.responseText == 1) {
                    alertScript('success', 'Status Changed Successfully!');
                    get_user();
                } else {
                    alertScript('danger', "Error...!, Server Error,Please try later");
                }

            }
            xhr.send('toggleStatus=' + id + '&value= ' + val);
        }

        function delete_user(userid) {

            if (confirm("Are you sure you want to delete this User")) {
                let fd = new FormData();
                fd.append('userid', userid);
                fd.append('delete_user', '');

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/userdetails.php", true);


                xhr.onload = function() {
                    //    send data to html
                    if (this.responseText == '1') {
                        alertScript('success', "User Successfully Delete");
                        get_user();
                    } else {
                        alertScript('danger', "Error...!, Server Error,Please try later");

                    }
                }
                xhr.send(fd);
            }

        }

        function search_user(value) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/userdetails.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            console.log(value);
            if (value == "") {
                document.getElementById('user_display').style.visibility = "visible";
                get_user();
            }
            xhr.onload = function() {
                if (xhr.responseText == "") {
                    document.getElementById('user_display').style.visibility = "hidden";
                    document.getElementById('nosearch').style.visibility = "visible";
                } else {
                    document.getElementById('nosearch').style.visibility = "hidden";
                }
                document.getElementById('user_data').innerHTML = xhr.responseText;

            }
            xhr.send('search_user&name=' + value);
        }

        window.onload = function() {
            get_user();
        }
    </script>

</body>

</html>