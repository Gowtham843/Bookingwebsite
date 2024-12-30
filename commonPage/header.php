<nav id="nav_bar" class="navbar navbar-expand-lg bg-body-tertiary bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_r['site_title'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="Rooms.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facilities.php">Facilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="Contact.php">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="About.php">About</a>
        </li>
      </ul>
      <div class="d-flex" role="search">
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
          $path = USERS_IMG_PATH;
          echo <<<data
          <div class="btn-group border shadow-sm">
            <button type="button" class="btn  dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <img src="$path$_SESSION[upic]" style="width:35px;height:45px; margin-right:10px;" class="rounded-1"/>
            $_SESSION[uname]
            </button>
            <ul class="dropdown-menu dropdown-menu-lg-end ">
              <li><a class="text-decoration-none" href="profile.php"><button class="dropdown-item">Profile</button></a></li>
              <li><a class="text-decoration-none" href="bookings.php"><button class="dropdown-item">Bookings</button></a></li>
              <li><a class="text-decoration-none" href="logout.php"><button class="dropdown-item">Logout</button></a></li>
            </ul>
          </div>
          data;
        } else {
          echo <<<data
            <button type="button" class="btn btn-outline shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
            Login
          </button>
          <button type="button" class="btn btn-primary shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#signupModal">
            SignUp
          </button>
          data;
        }
        ?>

      </div>
    </div>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="loginform">
        <div class="modal-header">
          <h1 class="modal-title fs-5 d-flex align-items-center"><i class="bi bi-person fs-3 me-2"></i>User Login</h1>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Email / Mobile Number:</label>
            <input type="text" class="form-control" name="email_no" required>
            <div id="emailHelp" class="form-text">We'll never share your details with anyone else.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="pass" class="form-control" required>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="submit" class="btn btn-outline p-0" data-bs-toggle="modal" data-bs-target="#forgotModal">Forgot Password?</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal2 -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="" id="signupform">
        <div class="modal-header">
          <h1 class="modal-title fs-5 d-flex align-items-center"><i class="bi bi-person-fill-add fs-3 me-3"></i>User
            Registration</h1>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span class="badge text-bg-light mb-3 text-wrap lh-base">Note: Your details must match with your id (ex:
            Aadhar) this required while check in in hotel*</span>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">Name</label><i class="bi bi-person-vcardms-2"></i>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="col-md-6 ps-0  mb-3">
                <label class="form-label">Email</label><i class="bi bi-envelope-at ms-2"></i>
                <input type="email" name="email" class="form-control" required>

              </div>
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">Phone Number</label><i class="bi bi-telephone ms-2"></i>
                <input type="Number" name="number" class="form-control" required>

              </div>
              <div class="col-md-6 ps-0  mb-3">
                <label class="form-label">Picture</label><i class="bi bi-camera ms-2"></i>
                <input type="file" accept=".png, .jpeg, .webg" name="pic" class="form-control" required>

              </div>
              <div class="col-md-12 ps-0  mb-3">
                <label class="form-label">Address</label><i class="bi bi-house ms-2"></i>

                <textarea class="form-control" name="address" rows="1" aria-label="With textarea" required></textarea>

              </div>
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">Pincode</label><i class="bi bi-pin ms-2"></i>
                <input type="Number" class="form-control" name="pincode" required>

              </div>
              <div class="col-md-6 ps-0  mb-3">
                <label class="form-label">Date of birth</label><i class="bi bi-cake2 ms-2"></i>
                <input type="date" class="form-control" name="dob" required>

              </div>


              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">Password</label><i class="bi bi-key ms-2"></i>
                <input type="password" class="form-control" name="pass" required>

              </div>
              <div class="col-md-6 ps-0  mb-3">
                <label class="form-label">Confirm Password</label><i class="bi bi-key ms-2"></i>
                <input type="password" class="form-control" name="cpass" required>

              </div>
            </div>

          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-dark shadow-none">REGISTER</button>
          </div>

        </div>

      </form>
    </div>
  </div>
</div>


<!-- forgot modal  -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="forgotform">
        <div class="modal-header">
          <h1 class="modal-title fs-5 d-flex align-items-center"><i class="bi bi-person fs-3 me-2"></i>Forgot Password</h1>
        </div>
        <div class="modal-body">
          <div id="emailHelp" class="form-text">Note* A link will be sent to your email to reset password</div>
          <div class="mb-4">
            <label class="form-label">Email Address :</label>
            <input type="text" class="form-control" name="Forgot_email_no" required>
          </div>
          <div class="mb-2 text-end">
            <div class="d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="submit" class="btn  btn-outline  pr-4" data-bs-toggle="modal" data-bs-target="#loginModal">Back</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>