<?php
require('inc/essential.php');
require('inc/db_config.php');
adminLogin();

if (isset($_GET['seen'])) {
    $frm_data = Filteration($_GET);
    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `user_contact_us` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as read');
        } else {
            alert('danger', 'Operation failed');
        }
    } else {
        $q = "UPDATE `user_contact_us` SET `seen`=? WHERE `sr_no`=?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read');
        } else {
            alert('danger', 'Operation failed');
        }
    }
}
if (isset($_GET['delete'])) {
    $frm_data = Filteration($_GET);
    if ($frm_data['delete'] == 'all') {

        $q = "DELETE FROM `user_contact_us`";

        if (mysqli_query($con, $q)) {
            alert('success', 'All Data Deleted successfully');
        } else {
            alert('danger', 'Operation failed');
        }
    } else {
        $q = "DELETE FROM `user_contact_us` WHERE `sr_no`=?";
        $values = [$frm_data['delete']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data deleted successfully');
        } else {
            alert('danger', 'Operation failed');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel -Features and Facilities</title>
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
                <h3 class="mb-4">Features and Facilities</h3>

                <!-- Features Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#features-s">
                                Add
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>


                        <div class="table-responsive-md" style="height: 350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead">
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="features_data">

                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#facilities-s">
                                Add
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>


                        <div class="table-responsive-md" style="height: 350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities_data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>

    <!-- Features and Facilities Modal -->
    <div class="modal fade" id="features-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="Features_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Feature Member</h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-4">Name</label>
                            <input type="text" name="feature_name" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- facilities Modal -->
    <div class="modal fade" id="facilities-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="facilities_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Facilities </h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-4">Name</label>
                            <input type="text" name="facilities_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-4">Select Image</label>
                            <input type="file" name="facilities_icon" accept=".svg" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-4">Description </label>
                            <textarea class="form-control" name="facilities_description" rows="2" aria-label="With textarea" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    require('inc/script.php');
    ?>

    <script>
        let Feature_s_form = document.getElementById('Features_s_form');
        Feature_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_Feature();
        });


        function add_Feature() {
            let fd = new FormData();
            fd.append('name', Feature_s_form.elements['feature_name'].value);
            fd.append('add_Feature', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true)


            xhr.onload = function() {
                var feature_s = document.getElementById('features-s');
                var feature_sModelControl = bootstrap.Modal.getInstance(feature_s);
                feature_sModelControl.hide();

                //    send data to html
                if (this.responseText == 1) {
                    alertScript('success', "Feature Successfully Added");
                    Feature_s_form.elements['feature_name'].value;
                    Feature_s_form.reset()
                    get_Feature();
                } else {
                    alertScript('danger', "Error...!, Server Error,Please try later");
                }
            }
            xhr.send(fd);
        }

        function get_Feature() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('features_data').innerHTML = this.responseText;
            }
            xhr.send('get_Feature');
        }

        function del_features(val) {

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.responseText == 1) {
                    alertScript('success', "Feature Successfully Deleted");
                    get_Feature();
                } else if (this.responseText == 'room_added') {
                    alertScript('danger', "Error...!, Feature is added in room");
                } else {
                    alertScript('danger', "Error...!, Feature was not able to be delete");
                }

            }
            xhr.send('del_features=' + val);
        }

        // facilities
        let Facilities_s_form = document.getElementById('facilities_s_form');
        Facilities_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_facilities();
        });

        function add_facilities() {
            let fd = new FormData();
            fd.append('name', Facilities_s_form.elements['facilities_name'].value);
            fd.append('icon', Facilities_s_form.elements['facilities_icon'].files[0]);
            fd.append('description', Facilities_s_form.elements['facilities_description'].value);
            fd.append('add_facilities', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true)


            xhr.onload = function() {
                var facilities_s = document.getElementById('facilities-s');
                var facilities_sModelControl = bootstrap.Modal.getInstance(facilities_s);
                facilities_sModelControl.hide();

                //    send data to html
                if (this.responseText == 'inv_img') {
                    alertScript('danger', "Error...!, Invalid Image Formate");

                } else if (this.responseText == 'Image_size_is_more') {
                    alertScript('danger', "Error...!, Image Size is more than allowed");

                } else if (this.responseText == 'Error_in_Uploading_the_file') {
                    alertScript('danger', "Error...!, Server Error,Please try later");

                } else if (this.responseText == '1') {
                    alertScript('success', "New Facilities Successfully Saved");
                    Facilities_s_form.reset();
                    get_facilities();
                }
                
            }
            xhr.send(fd);
        }

        function get_facilities() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('facilities_data').innerHTML = this.responseText;
            }
            xhr.send('get_facilities');
        }

        function del_facilities(val) {

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          
            xhr.onload = function() {
                
                if (this.responseText == 1) {
                    alertScript('success', "facilities Successfully Deleted");
                    get_facilities();
                } else if (this.responseText == 'room_added') {
                    alertScript('danger', "Error...!, facilities is added in room");
                } else {
                    alertScript('danger', "Error...!, facilities was not able to be delete");
                }

            }
            xhr.send('del_facilities=' + val);
        }

        window.onload = function() {
            get_Feature();
            get_facilities();
        }
    </script>

</body>

</html>