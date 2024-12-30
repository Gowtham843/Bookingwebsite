<?php
require('inc/essential.php');
adminLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel -Settings</title>
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
                <h3 class="mb-4">SETTINGS</h3>

                <!-- General Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#general-s">
                                Edit
                                <i class="bi bi-pencil"></i>
                            </button>


                        </div>

                        <h6 class="card-subtitle mb-1 fw-bold">Side Title</h6>
                        <p class="card-text" id="site_title_text"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us in footer</h6>
                        <p class="card-text" id="site_about_text"></p>
                    </div>
                </div>
                <!-- General Modal -->
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">General Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-4">Site Title</label><i class="bi bi-person-vcardms-2"></i>
                                        <input type="text" id="site_title_text_inp" name="site_title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-4">About text in footer</label>
                                        <textarea class="form-control" id="site_about_text_inp" name="site_about" rows="5" aria-label="With textarea" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="site_title.value=general_data.site_title , site_about.value=general_data.site_about" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-secondary text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- All Page text Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Content Settings</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#content-s">
                                Edit
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Facilities Title</h6>
                        <p class="card-text" id="facilities_text"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">Contact Us Title</h6>
                        <p class="card-text" id="contact_text"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us Title</h6>
                        <p class="card-text" id="about_us_text"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us below Title</h6>
                        <p class="card-text" id="about_us_b_text"></p>
                    </div>
                </div>


                <!-- content Modal -->
                <div class="modal fade" id="content-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="content_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Content Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-4">Facilities Title</label>
                                        <textarea class="form-control" id="facilities_text_inp" name="facilities" rows="2" aria-label="With textarea" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-4">Contact Us text</label>
                                        <textarea class="form-control" id="contact_us_text_inp" name="contact_us" rows="2" aria-label="With textarea" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-4">About Us text</label>
                                        <textarea class="form-control" id="about_us_text_inp" name="about_us" rows="2" aria-label="With textarea" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-4">About Us below text</label>
                                        <textarea class="form-control" id="about_us_b_text_inp" name="about_us_b" rows="2" aria-label="With textarea" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-secondary text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Shutdown Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <div class="form-check form-switch">
                                <form action="">
                                    <input onchange="upd_shutdown(this.value)" role="switch" class="form-check-input" type="checkbox" id="ShutdownButton">
                                </form>
                            </div>

                        </div>
                        <p class="card-text">Website is down, Kindly wait for few hours</p>
                    </div>
                </div>

                <!-- Contact Details Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contact Details Settings</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#Contact-s">
                                Edit
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phone no</h6>
                                    <p class="card-text"><i class="bi bi-telephone me-2"></i><span id="pno"></span></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Email</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                    <p class="card-text mb-1"><i class="bi bi-twitter me-2"></i><span id="tl"></span></p>
                                    <p class="card-text mb-1"><i class="bi bi-facebook me-2"></i><span id="fl"></span></p>
                                    <p class="card-text mb-1"><i class="bi bi-instagram me-2"></i><span id="il"></span></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame Links</h6>
                                    <iframe class="border p-2 w100" id="iframesrc" loading='lazy'></iframe>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- contact Modal -->
                <div class="modal fade" id="Contact-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="Contact_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Contact Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-4">Address </label>
                                                    <textarea class="form-control" id="address_inp" name="address" rows="1" aria-label="With textarea" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-4">Gmap</label><i class="bi bi-person-vcardms-2"></i>
                                                    <input type="text" id="gmap_inp" name="gmap" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-4">Phone Number</label><i class="bi bi-person-vcardms-2"></i>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="bi bi-telephone me-2"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control shadow-none" name="pno" id="pno_inp" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-4">Email</label><i class="bi bi-person-vcardms-2"></i>
                                                    <input type="email" id="email_inp" name="email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label class="form-label fw-4"> Social Links</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-twitter me-2"></i></span>
                                                        <input type="text" class="form-control shadow-none" name="tl" id="tl_inp" required>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-facebook me-2"></i></span>
                                                        <input type="text" class="form-control shadow-none" name="fl" id="fl_inp" required>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-instagram me-2"></i></span>
                                                        <input type="text" class="form-control shadow-none" name="il" id="il_inp" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-4">Iframe </label>
                                                    <textarea class="form-control" id="iframe_inp" name="iframe" rows="3" aria-label="With textarea" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="contacts_inp(contacts_data)" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-secondary text-white shadow-none">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Management Team Settings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Settings</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#team-s">
                                Add
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>

                        <!-- making a div to siplay images -->
                        <div class="row" id="team-data">
                        </div>
                    </div>
                </div>
                <!-- Management Modal -->
                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="team_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Add Team Member</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-4">Name</label>
                                        <input type="text" id="memeber_name_inp" name="memeber_name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-4">Select Image</label>
                                        <input type="file" id="memeber_picture_inp" name="memeber_picture" accept="[.jpg, .png, .webp, .jpeg]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="memeber_name.value='',memeber_picture.value='' " class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
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
        let general_data, contacts_data;
        let general_s_form = document.getElementById('general_s_form');
        let site_titleinp = document.getElementById('site_title_text_inp');
        let site_aboutinp = document.getElementById('site_about_text_inp');

        function get_general() {
            let site_title = document.getElementById('site_title_text');
            let site_about = document.getElementById('site_about_text');

            let shutdown_button = document.getElementById('ShutdownButton');


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                general_data = JSON.parse(this.responseText);
                site_title.innerText = general_data.site_title;
                site_about.innerText = general_data.site_about;

                site_titleinp.value = general_data.site_title;
                site_aboutinp.value = general_data.site_about;

                if (general_data.shutdown == 0) {
                    shutdown_button.checked = false;
                    shutdown_button.value = 0;
                } else {
                    shutdown_button.checked = true;
                    shutdown_button.value = 1;
                }
            }
            xhr.send('get_general');

        }

        general_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            upd_general(site_titleinp.value, site_aboutinp.value);
        })


        function upd_general(site_title_value, site_about_value) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                var general_s = document.getElementById('general-s');
                var general_sModelControl = bootstrap.Modal.getInstance(general_s);
                general_sModelControl.hide();

                //    send data to html
                if (this.responseText == 1) {
                    alertScript('success', "Changes Saved Successfully")
                    get_general();
                } else {
                    alertScript('danger', "Error...!, Changes is not saved")

                }
            }
            xhr.send('site_title=' + site_title_value + '&site_about=' + site_about_value + '&upd_general');
        }





        // content text 
        let content_data;
        let content_s_form = document.getElementById('content_s_form');
        let facilities_text_inp = document.getElementById('facilities_text_inp');
        let contact_us_text_inp = document.getElementById('contact_us_text_inp');
        let about_us_text_inp = document.getElementById('about_us_text_inp');
        let about_us_b_text_inp = document.getElementById('about_us_b_text_inp');

        function get_content() {
            let facilities_text = document.getElementById('facilities_text');
            let contact_text = document.getElementById('contact_text');
            let about_us_text = document.getElementById('about_us_text');
            let about_us_b_text = document.getElementById('about_us_b_text');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                content_data = JSON.parse(this.responseText);
                facilities_text.innerText = content_data.facilities_text;
                contact_text.innerText = content_data.contact_text;
                about_us_text.innerText = content_data.about_text;
                about_us_b_text.innerText = content_data.about_b_text;

                // placing in input tag 
                facilities_text_inp.value = content_data.facilities_text;
                contact_us_text_inp.value = content_data.contact_text;
                about_us_text_inp.value = content_data.about_text;
                about_us_b_text_inp.value = content_data.about_b_text;

                

            
            }
            xhr.send('get_content');

        }

        content_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            upd_content(facilities_text_inp.value,contact_us_text_inp.value,about_us_text_inp.value,about_us_b_text_inp.value);
        })


        function upd_content(ft,ct,at,abt) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                var content_s = document.getElementById('content-s');
                var content_sModelControl = bootstrap.Modal.getInstance(content_s);
                content_sModelControl.hide();

                //    send data to html
                if (this.responseText == 1) {
                    alertScript('success', "Changes Saved Successfully")
                    get_content();
                } else {
                    alertScript('danger', "Error...!, Changes is not saved")

                }
            }
            xhr.send('facilities_text=' + ft + '&contact_text=' + ct + '&about_text=' + at + '&about_b_text=' + abt + '&upd_content');
        }


        // shutdown 
        function upd_shutdown(val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {

                //    send data to html
                if (this.responseText == 1 && general_data.shutdown == 0) {
                    alertScript('success', "Shutdown mode on Successfully")
                } else {
                    alertScript('success', "Shutdown mode off Successfully")
                }
                get_general();
            }
            xhr.send('upd_shutdown=' + val);
        }

        // Contact Details
        let Contact_s_form = document.getElementById('Contact_s_form');

        // get contact_details
        function get_contacts() {

            let contacts_p_id = ['address', 'gmap', 'pno', 'email', 'tl', 'fl', 'il'];
            let iframesrc = document.getElementById('iframesrc');


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                contacts_data = JSON.parse(this.responseText);
                contacts_data = Object.values(contacts_data);

                for (let index = 0; index < contacts_p_id.length; index++) {
                    document.getElementById(contacts_p_id[index]).innerHTML = contacts_data[index + 1];

                }
                iframesrc.src = contacts_data[8];
                contacts_inp(contacts_data);
            }
            xhr.send('get_contacts');

        }

        // Updating data in model contact_s

        function contacts_inp(contacts_data) {
            let contacts_inp_id = ['address_inp', 'gmap_inp', 'pno_inp', 'email_inp', 'tl_inp', 'fl_inp', 'il_inp', 'iframe_inp'];
            for (let index = 0; index < contacts_inp_id.length; index++) {
                document.getElementById(contacts_inp_id[index]).value = contacts_data[index + 1];

            }
        }

        function upd_contact() {
            let index = ['address', 'gmap', 'pno', 'email', 'tl', 'fl', 'il', 'iframe'];
            let contacts_inp_id = ['address_inp', 'gmap_inp', 'pno_inp', 'email_inp', 'tl_inp', 'fl_inp', 'il_inp', 'iframe_inp'];

            let data_str = "";

            for (let i = 0; i < index.length; i++) {
                data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';

            }
            data_str += 'upd_contact';
            console.log('y')

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                var contact_s = document.getElementById('Contact-s');
                var contact_sModelControl = bootstrap.Modal.getInstance(contact_s);
                contact_sModelControl.hide();

                //    send data to html
                if (this.responseText == 1) {
                    alertScript('success', "Changes Saved Successfully");
                    get_contacts();

                } else {
                    alertScript('danger', "Error...!, Changes is not saved")

                }
            }
            xhr.send(data_str);

        }

        Contact_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            upd_contact();
        })

        // Team Management Details
        let team_s_form = document.getElementById('team_s_form');
        let memeber_name_inp = document.getElementById('memeber_name_inp');
        let memeber_picture_inp = document.getElementById('memeber_picture_inp');

        function add_member() {
            let fd = new FormData();
            fd.append('name', memeber_name_inp.value);
            fd.append('picture', memeber_picture_inp.files[0]);
            fd.append('add_member', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)


            xhr.onload = function() {
                var team_s = document.getElementById('team-s');
                var team_sModelControl = bootstrap.Modal.getInstance(team_s);
                team_sModelControl.hide();

                //    send data to html
                if (this.responseText == 'inv_img') {
                    alertScript('danger', "Error...!, Invalid Image Formate");

                } else if (this.responseText == 'Image_size_is_more') {
                    alertScript('danger', "Error...!, Image Size is more than allowed");

                } else if (this.responseText == 'Error_in_Uploading_the_file') {
                    alertScript('danger', "Error...!, Server Error,Please try later");

                } else if (this.responseText == '1') {
                    alertScript('success', "Image Successfully Saved");
                    memeber_name_inp.value = '';
                    memeber_picture_inp.value = '';
                    get_members();
                }
            }
            xhr.send(fd);
        }

        function get_members() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('team-data').innerHTML = this.responseText;
            }
            xhr.send('get_members');
        }

        function del_member(val) {
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings-crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.responseText == 1) {
                    alertScript('success', "Image Successfully Deleted");
                    get_members();
                } else {
                    alertScript('danger', "Error...!, Image was not able to be delete");
                }

            }
            xhr.send('del_member=' + val);
        }

        team_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_member();
        })


        window.onload = function() {
            get_general();
            get_content();
            get_contacts();
            get_members();
        }
    </script>
</body>

</html>