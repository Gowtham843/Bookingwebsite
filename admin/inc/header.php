<div class="conatiner-fluid bg-dark text-light p-3 d-flex align-item-center justify-content-between sticky-top">
    <h3 class="mb-0">Dequeue</h3>
    <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
</div>

<div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2 text-light">ADMIN PANEL</h4>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="adminDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="adminDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item mb-1">
                        <button class="btn text-white px-3 w-100 text-start d-flex align-items justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#boooking_list">
                            <span>Bookings</span>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="boooking_list">
                            <ul class="nav nav-pills flex-column ">
                                <li class="nav-item ">
                                    <a href="new_bookings.php" class="nav-link text-white rounded  mt-1">New Bookings</a>
                                </li>
                                <li class="nav-item ">
                                    <a href="refund_bookings.php" class="nav-link text-white rounded  mt-1">Refund Bookings</a>
                                </li>
                                <li class="nav-item ">
                                    <a href="all_bookings.php" class="nav-link text-white rounded  mt-1">All Bookings</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="userdetails.php">Userdetails</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="ffpage.php">Features and Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rate_review.php">Rate and Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="userdata.php">User Contact data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="carousel.php">Carousel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Settings</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>