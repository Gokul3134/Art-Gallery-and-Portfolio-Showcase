<?php
// contact.php (at the top)
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: front.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<header>
    <!-- Left side: Logo and Title -->
    <div class="header-left">
        <img src="img/logo5.png" alt="Logo" class="logo" style="height: 50px; width: 80px ">
        <h1 style="color: #333; font-size: 36px;">Art Gallery</h1>
    </div>

    <!-- Middle: Navigation Menu -->
    <div class="header-middle">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="art_gallery.php">Art Gallery</a>
        <a href="artist.php">Artist</a>
        <a href="contact.php">Contact</a>
    </div>

    <!-- Right side: User Profile Dropdown -->
    <div class="header-right">
        <div class="dropdown">
            <button class="dropbtn" style="font-size: 18px;font-weight: 500;">Welcome, <?php echo $_SESSION['user_name']; ?> <i class="fa fa-caret-down" style="color:#333; height:20px; padding: 0;font-size: 20px;width: 60px;text-align: center;text-decoration: none;border-radius: 50%;"></i></button>
            <div class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</header>

<section class="contact-section">
    <div>
        <h2>Contact Us</h2>
        <form id="contactForm" action="contact_db.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
    <div>
        <h3>Office Address:</h3>
        <hr>
        <p>ANO 717, Astra Towers, Action Area IIC, <br>Newtown, New Town, West Bengal 700135</p>
        <h3>Contact Info:</h3>
        <hr>
        <!-- <h5>Call Us:</h5> -->
        <p>+91 9648571234</p>
        <!-- <h5>E-mail Us:</h5> -->
        <p>artgallery@gmail.com</p>
        <h3>Office Location:</h3>
        <hr>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1094.923259271096!2d88.46469283000823!3d22.621397370167617!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f89f308e3e063d%3A0x4cb8ec196b283f75!2sAstra%20Tower!5e0!3m2!1sen!2sin!4v1722242783399!5m2!1sen!2sin" width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<footer>
    <div class="foot">
        <div class="address">
                <h3>Quick Access:</h3>
                <a href="index.php">Home</a> <br>
                <a href="about.php">About</a> <br>
                <a href="art_gallery.php">Art Gallery</a> <br>
                <a href="artist.php">Artist</a> <br>
                <a href="contact.php">Contact</a> <br>
            </div>
            <div class="contact_info">
                <h3>Contact Info:</h3>
                <h5>Call Us:</h5>
                <p>+91 9648571234</p>
                <p>+91 9875642317</p>
                <h5>E-mail Us:</h5>
                <p>artstore@gmail.com</p>
                <p>artgallery@gmail.com</p>
            </div>
            <div class="follow">
                <h3>Follow Us:</h3>
                <a href="#" class="fa fa-facebook"></a>
                <a href="#" class="fa fa-twitter"></a>
                <a href="#" class="fa fa-linkedin"></a> <br>
                <a href="#" class="fa fa-youtube"></a>
                <a href="#" class="fa fa-instagram"></a>
                <p>© 'Art Gallery', 2024. All Rights Reserved.</p>
            </div>
    </div>
</footer>
<script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Perform form validation and submission using AJAX (if needed)
            var form = event.target;
            var formData = new FormData(form);

            // Example AJAX request (replace with your actual AJAX call)
            fetch(form.action, {
                method: form.method,
                body: formData
            }).then(response => response.json())
            .then(data => {
                // Assuming the server returns a success message in JSON format
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Your message has been sent successfully!',
                    });
                    form.reset(); // Reset the form after successful submission
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error sending your message. Please try again later.',
                    });
                }
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error sending your message. Please try again later.',
                });
            });
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
