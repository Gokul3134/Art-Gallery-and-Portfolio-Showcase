<?php
// index.html (at the top)
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: front.php");
    exit();
}



// Check if the sale was successful
if (isset($_SESSION['sale_success'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: 'Purchased Artworks Successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>";
    // Unset the session variable after showing the message
    unset($_SESSION['sale_success']);
}

// Check if there was an error
if (isset($_SESSION['sale_error'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error!',
                text: '" . $_SESSION['sale_error'] . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    </script>";
    // Unset the session variable after showing the error
    unset($_SESSION['sale_error']);
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <a href="#">Home</a>
        <a href="about.php">About</a>
        <a href="art_gallery.php">Art Gallery</a>
        <a href="artist.php">Artist</a>
        <a href="contact.php">Contact</a>
    </div>

    <!-- Right side: User Profile Dropdown -->
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


<div class="slideshow-container" >
    <img class="slides" src="img/slide.jpg" alt="Slide 1">
    <img class="slides" src="img/slide2.jpg" alt="Slide 2">
    <img class="slides" src="img/slide3.jpg" alt="Slide 3">
    <span class="arrow left" onclick="plusSlides(-1)">&#10094;</span>
    <span class="arrow right" onclick="plusSlides(1)">&#10095;</span>
</div>

<section class="about-section">
    <div style="max-width: 50%;">
        <!-- <img src="about.jpg" alt="About Image" style="width:100%"> -->
        <video width="600" height="500px" autoplay muted loop >
            <source src="img/video2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div style="max-width: 50%; margin-left: 50px; ">
        <h1>About Us</h1>
        <p>Our art gallery is a haven for art enthusiasts, showcasing a diverse collection of contemporary works. From vibrant paintings to intricate sculptures, our curated exhibits offer something for everyone. Discover the unique stories behind each piece and connect with talented artists. Located in the heart of the city, our gallery provides a dynamic and inspiring environment. Join us to experience the transformative power of art and connect with fellow art lovers.</p>
        <a href="about.php" class="button">Learn More</a>
    </div>
</section>


<section class="art-gallery" id="gallery">
    <div class="upper">
        <h2>Art Gallery</h2>
        <a href="art_gallery.php">View All</a>
    </div>
    <div class="lower">
        <?php include 'artwork_details.php'; ?>
    </div>
</section>

    <div class="container">
        <div class="buy-now">
            <span class="close" id="registerClose">&times;</span>
            <h2>Buy Now</h2>
            <form action="process_sale.php" method="POST">
                <label for="artwork_id">Artwork ID:</label>
                <input type="number" id="artwork_id" name="artwork_id" required>
                
                <label for="user_id">User ID:</label>
                <input type="number" id="user_id" name="user_id" required>
                
                <label for="sale_price">Sale Price:</label>
                <input type="text" id="sale_price" name="sale_price" required>
                
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
                
                <button type="submit">Buy Now</button>
            </form>
        </div>
    </div>


<section class="artist-section">
    <div class="upper">
        <h2>Meet Our Artists</h2>
        <a href="artist.php">View All</a>
    </div>
    <div class="lower">
        <?php include 'artist_details.php'; ?>
    </div>
</section>


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
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let slides = document.getElementsByClassName("slides");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 2000); // Change image every 3 seconds
    }

    function plusSlides(n) {
        slideIndex += n - 1;
        showSlides();
    }

    
</script>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Image Preview Modal -->
<div id="image-preview" class="image-preview">
    <span class="close-preview" onclick="closeImagePreview()">&times;</span>
    <img id="preview-image" class="preview-image" src="" alt="Artwork Image">
    <div class="zoom-controls">
        <button onclick="zoomImage(1.2)">Zoom In</button>
        <button onclick="zoomImage(0.8)">Zoom Out</button>
    </div>
</div>

<script>
    // Function to show the container
function showContainer() {
    const container = document.querySelector('.container');
    if (container) {
        container.style.display = 'block'; // Show the container
    }
}

// Function to hide the container (optional)
function hideContainer() {
    const container = document.querySelector('.container');
    if (container) {
        container.style.display = 'none'; // Hide the container
    }
}


document.addEventListener("DOMContentLoaded", function() {
    // Get the close button element
    const closeButton = document.getElementById("registerClose");
    
    // Add click event listener to the close button
    if (closeButton) {
        closeButton.addEventListener("click", function() {
            // Get the container element to be hidden
            const container = document.querySelector('.container');
            if (container) {
                container.style.display = 'none'; // Hide the container
            }
        });
    }
});


</script>

<script>
    let zoomLevel = 1;

    function openImagePreview(imagePath) {
        const previewDiv = document.getElementById("image-preview");
        const previewImage = document.getElementById("preview-image");

        previewImage.src = imagePath;
        previewDiv.style.display = "flex";
    }

    function closeImagePreview() {
        const previewDiv = document.getElementById("image-preview");
        previewDiv.style.display = "none";
    }

    function zoomImage(scale) {
        const previewImage = document.getElementById("preview-image");
        zoomLevel *= scale;
        previewImage.style.transform = `scale(${zoomLevel})`;
    }

</script>

</body>
</html>
