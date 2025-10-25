# Demo URL
http://gowthamhotelbooking.gt.tc/

# Hotel Booking Website  

A full-stack hotel booking system built with **PHP, MySQL, Bootstrap, and Ajax**, integrated with **PhonePe Payment Gateway** and **SMTP Email** notifications. Supports dynamic image uploads for hotel rooms via an admin panel.  

---

## 🚀 Features  

- User registration and login system  
- Hotel room listing with booking functionality  
- Real-time availability check using Ajax  
- Secure payment integration with **PhonePe**  
- Booking confirmation email via SMTP  
- Admin panel to add/manage rooms, including **dynamic image uploads**  
- End to End control from Admin panel **Social media links and texts** 

---

## 🛠️ Tech Stack  

- **Frontend**: HTML, CSS, Bootstrap, JavaScript, Ajax  
- **Backend**: PHP  
- **Database**: MySQL  
- **Payment Gateway**: PhonePe  
- **Email Service**: SMTP (PHP Mailer)  
- **Optional**: Firebase/Cloudinary for dynamic image storage  

---

## 📂 Project Structure  

```
Bookingwebsite/
    assets/ # CSS, JS, static images
    images/ # Uploaded images via admin panel (dynamic)
    includes/ # Header, footer, reusable components
    config/ # DB and API configuration
    pages/ # Booking pages, user dashboard, admin panel
    index.php        # Landing page
    admin_upload.php # Handles dynamic image uploads
```
---

## ⚙️ Setup Instructions  

1. **Clone the repository**  
   ```bash
   git clone https://github.com/Gowtham843/Bookingwebsite.git

   cd Bookingwebsite


## Import the Database

1. Open **phpMyAdmin**  
2. Create a database (e.g., `hotel_booking`)  
3. Import the `.sql` file from the repo  

## Configure Environment Variables

Create `config.php` or `.env` for sensitive keys:

```php
<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "hotel_booking");

define("PHONEPE_KEY", "your_key_here");
define("SMTP_USER", "your_email_here");
define("SMTP_PASS", "your_password_here");
?>
```

## Dynamic Image Uploads

- Create a folder in root: `images/uploads/` (or `images/rooms/`)  
- Ensure PHP can write to it (**755 permissions**)  
- Admin panel form saves uploaded images here  

### Example PHP snippet for uploading:

```php
<?php
$target_dir = "images/uploads/";
$target_file = $target_dir . basename($_FILES["room_image"]["name"]);

if (move_uploaded_file($_FILES["room_image"]["tmp_name"], $target_file)) {
    echo "Upload successful!";
} else {
    echo "Upload failed!";
}
?>
```

## Start local server

- Use XAMPP / WAMP

```Navigate to http://localhost/Bookingwebsite```

# 📸 Displaying Images Dynamically
```
<php
Copy code
<?php
$query = "SELECT filename FROM rooms ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {
    $img_path = "images/uploads/" . $row['filename']; 
    echo "<img src='$img_path' alt='Room Image'>";
}
?>
```

## 📸 Project Screenshots  

![Homepage Screenshot](images\readme_image\homepage.png)

![Room_panel Screenshot](images\readme_image\room_panel.png)

![Room_page Screenshot](images\readme_image\room_page.png)

![Room_payment Screenshot](images\readme_image\payment_page_withfliter.png)

![Booking Screenshot](images\readme_image\booking_page.png)

![Admin Panel Screenshot](images\readme_image\admin_homepage.png)

![Admin Panel Screenshot](images\readme_image\admin_rooms.png)

![Admin Panel Screenshot](images\readme_image\admin_user_info.png)

![Admin Panel Screenshot](images\readme_image\admin_review_rate.png)

![Admin Panel Screenshot](images\readme_image\settings.png)

![Admin Panel Screenshot](images\readme_image\after_login_homepage.png)

![Admin Panel Screenshot](images\readme_image\admin_review_rate.png)

![Admin Panel Screenshot](images\readme_image\admin_review_rate.png)


## 📌 Future Improvements
- OTP verification for bookings








