<?php
require('inc/essential.php');
adminLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel -Carousel</title>
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
                <h3 class="mb-4">CAROUSEL</h3>

                <!-- Carousel Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Carousel Settings</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#Carousel-s">
                                Add
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>

                        <!-- making a div to siplay images -->
                        <div class="row" id="Carousel-data">
                        </div>
                    </div>
                </div>
                <!-- Carousel Modal -->
                <div class="modal fade" id="Carousel-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="Carousel_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Add Carousel Image</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-4">Select Image</label>
                                        <input type="file" id="Carousel_picture_inp" name="Carousel_picture" accept="[.jpg, .png, .webp, .jpeg]" class="form-control" required>
                                    </div>
                                    <h6 class="text-dark fw-bold ">Add 1920*570 pixel photo only **</h6>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-secondary text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php
    require('inc/script.php');
    ?>
    <script>
        // Team Management Details
        let Carousel_s_form = document.getElementById('Carousel_s_form');
        let Carousel_picture_inp = document.getElementById('Carousel_picture_inp');

        function add_image_Carousel() {
            let fd = new FormData();

            fd.append('picture', Carousel_picture_inp.files[0]);
            fd.append('add_image_Carousel', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/Carousel-crud.php", true)


            xhr.onload = function() {
                var Carousel_s = document.getElementById('Carousel-s');
                var Carousel_sModelControl = bootstrap.Modal.getInstance(Carousel_s);
                Carousel_sModelControl.hide();

                //    send data to html
                if (this.responseText == 'inv_img') {
                    alertScript('danger', "Error...!, Invalid Image Formate");

                } else if (this.responseText == 'Image_size_is_more') {
                    alertScript('danger', "Error...!, Image Size is more than allowed");

                } else if (this.responseText == 'Error_in_Uploading_the_file') {
                    alertScript('danger', "Error...!, Server Error,Please try later");

                } else if (this.responseText == '1') {
                    alertScript('success', "Image Successfully Saved");
                    Carousel_picture_inp.value = '';
                    get_Image_Carousel();
                }
            }
            xhr.send(fd);
        }

        function get_Image_Carousel() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/Carousel-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('Carousel-data').innerHTML = this.responseText;
            }
            xhr.send('get_Image_Carousel');
        }

        function del_image_Carousel(val) {
            console.log('y')
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/Carousel-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.responseText == 1) {
                    alertScript('success', "Image Successfully Deleted");
                    get_Image_Carousel();
                } else {
                    alertScript('danger', "Error...!, Image was not able to be delete");
                }

            }
            xhr.send('del_image_Carousel=' + val);
        }

        Carousel_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_image_Carousel();
        })


        window.onload = function() {
            get_Image_Carousel();
        }
    </script>
</body>

</html>