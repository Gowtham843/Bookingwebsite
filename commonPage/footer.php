<div class="container-fluid bg-white mt-5">
  <div class="row">
    <div class="col-lg-4 p-4">
      <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
      <p>
        <?php echo $settings_r['site_about'] ?>
      </p>
    </div>
    <div class="col-lg-4 p-4">
      <h5 class="mb-3">
        Links
      </h5>
      <a href="index.php" class="d-inline-block mb-2 text-decoration-none text-dark">Home</a><br>
      <a href="Rooms.php" class="d-inline-block mb-2 text-decoration-none text-dark">Room</a><br>
      <a href="facilities.php" class="d-inline-block mb-2 text-decoration-none text-dark">Facilities</a><br>
      <a href="Contact.php" class="d-inline-block mb-2 text-decoration-none text-dark">Contact Us</a><br>
      <a href="About.php" class="d-inline-block mb-2 text-decoration-none text-dark">About</a>
    </div>


    <div class="col-lg-4 p-4">
      <h5 class="mb-3">
        Follow Us
      </h5>
      <?php
      if ($contact_r['tl'] != '') {
        echo <<<data
        <a href="$contact_r[tl]" class="d-inline-block mb-2 text-decoration-none text-dark"><span
          class="badge bg-light text-dark fs-6 ps-6"><i class="bi bi-twitter me-2"></i>Twitter</span></a><br><br>
        data;
      }
      if ($contact_r['fl'] != '') {
        echo <<<data
        <a href=" $contact_r[fl] " class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-light text-dark fs-6 ps-6"><i class="bi bi-facebook me-2"></i>Facebook</span></a><br><br>
        data;
      }
      if ($contact_r['il'] != '') {
        echo <<<data
        <a href=" $contact_r[il]" class="d-inline-block mb-2 text-decoration-none text-dark"><span class="badge bg-light text-dark fs-6 ps-6"><i class="bi bi-instagram me-2"></i>Instagram</span></a><br><br>
        data;
      } ?>

    </div>

  </div>
</div>

<h6 class="bg-dark text-white w-100 text-center p-3 m-0">Designed and Developed by Dequeue Dev @copyright 234</h6>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function alertScript(type, msg, position = 'body') {
    let el = document.createElement('div');
    el.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show " role="alert">
              <strong class="me-3">${msg}</strong>.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>`;
    if (position == 'body') {
      document.body.append(el);
      el.classList.add('custom-alert');
    } else {
      document.getElementById(position).appendChild(el);
    }
    setTimeout(delAlert, 4000);
  }

  function delAlert() {
    document.getElementsByClassName('alert')[0].remove();
  }


  function setactive() {
    let filename = location.pathname.split('/').pop().split('.')[0];
    let a_tags = document.querySelectorAll('#nav_bar a');

    a_tags.forEach(tag => {
      if (tag.href.includes(filename)) {
        tag.classList.add('active');
      }
    });
  }

  setactive();
</script>

<script>

//  checking User is logined
function checkLoginToBook(status,room_id){
  if ((status)) {
    window.location.href='confirm_booking.php?id='+room_id;
  }else{
    alertScript('danger','Please login to Book');
  }
}

</script>

<!-- Signupmodal -->
<script>
  let signupform = document.getElementById('signupform');
  let loginform = document.getElementById('loginform');
  let forgotform = document.getElementById('forgotform');

  signupform.addEventListener('submit', function(e) {
    e.preventDefault();
    addUser();
  });

  function addUser() {
    let fd = new FormData();
    fd.append('name', signupform.elements['name'].value);
    fd.append('email', signupform.elements['email'].value);
    fd.append('number', signupform.elements['number'].value);
    fd.append('pic', signupform.elements['pic'].files[0]);
    fd.append('address', signupform.elements['address'].value);
    fd.append('pincode', signupform.elements['pincode'].value);
    fd.append('dob', signupform.elements['dob'].value);
    fd.append('pass', signupform.elements['pass'].value);
    fd.append('cpass', signupform.elements['cpass'].value);
    fd.append('addUser', '');

    var signupModal = document.getElementById('signupModal');
    var signupModalModelControl = bootstrap.Modal.getInstance(signupModal);
    signupModalModelControl.hide();



    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/loginandregister.php", true);


    xhr.onload = function() {

      if (this.responseText == 'pass no') {
        alertScript('danger', "Error...!,  Password and Confirm password doesn't match");
      } else if (this.responseText == 'Email already Used') {
        alertScript('danger', "Error...!, Email is already registered.");
      } else if (this.responseText == 'Number already used') {
        alertScript('danger', "Error...!, Number is already registered.");
      } else if (this.responseText == 'inv_img') {
        alertScript('danger', "Error...!, Only JPG, WEBP & PNG are only allowed");
      } else if (this.responseText == 'failed') {
        alertScript('danger', "Error...!, Image Uploading Failed");
      } else if (this.responseText == 'mail_send_failed') {
        alertScript('danger', "Error...!, Mail send Failed, Server Error");
      } else if (this.responseText == 'ins_failed') {
        alertScript('danger', "Error...!, Registration Failed, Try again");
      } else if (this.responseText == 1) {
        alertScript('success', "Registration Successful, Confirmation Link has been Sent to Your Email");
        signupform.reset();
      }

    }
    xhr.send(fd);
  }


  // Login code
  loginform.addEventListener('submit', function(e) {
    e.preventDefault();
    loginUser();
  });

  function loginUser() {
    let fd = new FormData();
    fd.append('email_no', loginform.elements['email_no'].value);
    fd.append('pass', loginform.elements['pass'].value);
    fd.append('loginUser', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/loginandregister.php", true);
    
    xhr.onprogress = function() {
      alertScript('info', "Progress is going on");
    }
    xhr.onload = function() {

      if (this.responseText == "User_doesn't_exist") {
        alertScript('danger', "Error...!, User doesn't exist.");
      } else if (this.responseText == 'Account_is_Not_verified') {
        alertScript('danger', "Error...!, Email is not verified. Please check your email for verification link.");
      } else if (this.responseText == 'Account_as_been_banned') {
        alertScript('danger', "Error...!, Account as been banned admin.");
      } else if (this.responseText == 'Invalidpass') {
        alertScript('danger', "Error...!, Wrong  password!");
      } else if (this.responseText == 1) {
        var loginModal = document.getElementById('loginModal');
        var loginModalModelControl = bootstrap.Modal.getInstance(loginModal);
        loginModalModelControl.hide();
        loginform.reset();
        let fileUrl=window.location.href.split('/').pop().split('?').shift();
        if (fileUrl=='moredetailsroom.php') {
          window.location=window.location.href
        }else{
          window.location = window.location.pathname;
        }
      }

    }
    xhr.send(fd);
  }


  forgotform.addEventListener('submit', function(e) {
    e.preventDefault();
    forgotPasswordUser();
  });

  function forgotPasswordUser() {

    let fd = new FormData();
    fd.append('Forgot_email_no', forgotform.elements['Forgot_email_no'].value);
    fd.append('forgotPasswordUser', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/loginandregister.php", true);

    xhr.onprogress = function() {
      alertScript('info', "Progress is going on");
    }

    xhr.onload = function() {

      if (this.responseText == "User_doesn't_exist") {
        alertScript('danger', "Error...!, User doesn't exist.");
      } else if (this.responseText == 'Account_is_Not_verified') {
        alertScript('danger', "Error...!, Email is not verified. Please check your email for verification link.");
      } else if (this.responseText == 'Account_as_been_banned') {
        alertScript('danger', "Error...!, Account as been banned admin.");
      } else if (this.responseText == 'mail_failed') {
        alertScript('danger', "Error...!, Server down Please try later !");
      } else if (this.responseText == 'failed') {
        alertScript('danger', "Error...!, Server down Please try later !");
      } else if (this.responseText == 1) {
        alertScript('success', "Reset link is successfully sent to your email");
        var forgotModal = document.getElementById('forgotModal');
        var forgotModalModelControl = bootstrap.Modal.getInstance(forgotModal);
        forgotModalModelControl.hide();
        forgotform.reset();
      }

    }
    xhr.send(fd);
  }
</script>

<script>
  function checkoutclk(e){
    e.preventDefault();

    // Create a FormData object and append our data to it.
    let fd = new FormData();
    fd.append('name', document.getElementById('chname').value);
    fd.append('phone', document.getElementById('chphone').value);
    fd.append('book', document.getElementById('chbook').value);
    fd.append('room', document.getElementById('chroom').value);
    fd.append('checkoutclk', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/checkout.php", true)


    xhr.onload = function() {
      

        if (this.responseText == 1) {
            window.location.reload();           
        } else {
            alertScript('danger', "Error...!, Server Error,Please try later");
        }

    }
    xhr.send(fd);

  }
</script>