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
    <title>Admin Panel -Rooms</title>
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
                <h3 class="mb-4">Rooms</h3>

                <!-- Features Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#addRooms-s">
                                Add
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>


                        <div class="table-responsive-lg" style="height: 450px; overflow-y:scroll;">
                            <table class="table table-hover border text-center ">
                                <thead">
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="Room_data">

                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Modal -->
    <div class="modal fade" id="addRooms-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="addRooms_s_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add New Room</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Name</label>
                                <input type="text" name="room_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Area</label>
                                <input type="number" min="1" name="room_area" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Price</label>
                                <input type="number" min="1" name="room_price" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Quantity</label>
                                <input type="number" min="1" name="room_quantity" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Adult (MAX:)</label>
                                <input type="number" min="1" name="room_adult" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Children (MAX:)</label>
                                <input type="number" min="1" name="room_children" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-4"> Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "
                                    <div class='col-6 col-sm-4 col-md-3 mb-3'>
                                        <label><input type='checkbox' name='room_feature' value='$row[sr_no] class='form-check-input'/>
                                        $row[name]</label></div>
                                   ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-4"> Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "
                                    <div class='col-6 col-sm-4 col-md-3 mb-3'>
                                        <label><input type='checkbox' name='room_facilities' value='$row[sr_no] class='form-check-input'/>
                                        $row[name]</label></div>
                                   ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-4">Description</label>
                                <textarea name="room_description" rows="3" class="form-control"></textarea>
                            </div>
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



    <!-- Rooms Edit Modal -->
    <div class="modal fade" id="editRooms-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editRooms_s_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Room</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Name</label>
                                <input type="text" name="room_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Area</label>
                                <input type="number" min="1" name="room_area" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Price</label>
                                <input type="number" min="1" name="room_price" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Quantity</label>
                                <input type="number" min="1" name="room_quantity" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Adult (MAX:)</label>
                                <input type="number" min="1" name="room_adult" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-4">Children (MAX:)</label>
                                <input type="number" min="1" name="room_children" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-4"> Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "
                                    <div class='col-6 col-sm-4 col-md-3 mb-3'>
                                        <label><input type='checkbox' name='room_feature' value='$row[sr_no]' class='form-check-input'/>
                                        $row[name]</label></div>
                                   ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-4"> Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "
                                    <div class='col-6 col-sm-4 col-md-3 mb-3'>
                                        <label><input type='checkbox' name='room_facilities' value='$row[sr_no]' class='form-check-input'/>
                                        $row[name]</label></div>
                                   ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-4">Description</label>
                                <textarea name="room_description" rows="3" class="form-control"></textarea>
                            </div>
                            <input type="hidden" name="room_id">
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

    <!-- Managing Image of Rooms Modal -->
    <div class="modal fade" id="imageRooms-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="room_title"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image_alert">
                    </div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form action="" id="add_image_form">
                            <div class="mb-3">
                                <label class="form-label fw-4">Add Image</label>
                                <input type="file" name="image" accept="[.jpg, .png, .webp, .jpeg]" class="form-control mb-3" required>
                                <button type="submit" class="btn btn-secondary text-white shadow-none">Add</button>
                                <input type="hidden" name="room_id"/>
                            </div>
                        </form>
                        <h6 class="text-dark fw-bold ">Add 1920*1080 pixel photo only **</h6>
                    </div>
                    <div class="table-responsive-lg" style="height: 350px; overflow-y:scroll;">
                        <table class="table table-hover border text-center ">
                            <thead">
                                <tr class="sticky-top text-white table-dark">
                                    <th scope="col" width=60%>IMAGE</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Delete</th>
                                </tr>
                                </thead>
                                <tbody id="room_image_data">

                                </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php
    require('inc/script.php');
    ?>

    <script src="scriptroompage/step1.js"></script>
    <script src="scriptroompage/step2.js"></script>

</body>

</html>