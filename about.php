<?php
// about.php (at the top)
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
    <title>About Us</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        section {
            padding: 20px 20px;
            background-color: #fff;
            text-align: center;
        }
    </style>
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
        <a href="#">Contact</a>
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

<section class="about-section">
    <div style="max-width: 50%;">
        <!-- <img src="img/back3.jpg" alt="About Image" style="width:100%"> -->
        <video width="600" height="500px" autoplay muted loop >
            <source src="img/video2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div style="max-width: 50%; margin-left: 50px; ">
        <h1>About Us</h1>
        <p>Our art gallery is a haven for art enthusiasts, showcasing a diverse collection of contemporary works. From vibrant paintings to intricate sculptures, our curated exhibits offer something for everyone. Discover the unique stories behind each piece and connect with talented artists. Located in the heart of the city, our gallery provides a dynamic and inspiring environment. Join us to experience the transformative power of art and connect with fellow art lovers.</p>
        <!-- <a href="about.php" class="button">Learn More</a> -->
    </div>
</section>

<section class="about-section" >
    <div style="max-width: 50%;">
        <h1>Our Goals</h1>
        <p>Our art gallery aims to promote and showcase contemporary art, educate the public, inspire creativity, support artists, and contribute to the local community. By attracting a diverse audience, hosting successful exhibitions, building a strong reputation, generating revenue, and fostering a sense of community, art galleries can play a vital role in the cultural landscape.</p>
        <!-- <a href="about.php" class="button">Learn More</a> -->
    </div>
    <div style="max-width: 50%;">
        <!-- <img src="img/back3.jpg" alt="About Image" style="width:100%"> -->
        <video width="600" height="500px" autoplay muted loop >
            <source src="img/video3.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
