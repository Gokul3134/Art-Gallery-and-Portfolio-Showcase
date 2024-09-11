<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: front.php");
    exit();
}

// Include database connection file
include 'db.php'; // Ensure this file contains the correct connection details

// Fetch and display artworks
$query = "SELECT a.id, a.title, a.description, a.category, a.price, a.image_path, u.name as artist_name 
          FROM artworks a 
          JOIN users u ON a.artist_id = u.id
          ";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<header>
    <div class="header-left">
        <img src="img/logo5.png" alt="Logo" class="logo" style="height: 50px; width: 80px ">
        <h1 style="color: #333; font-size: 36px;">Art Gallery</h1>
    </div>
    <div class="header-middle">
        <a href="index.php">Home</a>
        <a href="#">About</a>
        <a href="art_gallery.php">Art Gallery</a>
        <a href="artist.php">Artist</a>
        <a href="#">Contact</a>
    </div>
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

<section class="art-gallery" id="gallery">
    <div class="upper">
        <h2>Art Gallery</h2>
    </div>
    <div class="lower">
        <?php
        // Include artwork details
        if (mysqli_num_rows($result) > 0) {
            while ($artwork = mysqli_fetch_assoc($result)) {
                $imagePath = str_replace('uploads/uploads/', 'uploads/', 'uploads/' . htmlspecialchars($artwork['image_path']));
        
                echo '
                <div class="artwork-item">
                    <a href="#gallery" onclick="openImagePreview(\'' . $imagePath . '\')">
                        <img src="' . $imagePath . '" alt="' . htmlspecialchars($artwork['title']) . '" style="max-width: 300px; height:250px;">
                    </a>
                    <h3 style="font-size:24px;">' . htmlspecialchars($artwork['title']) . '</h3>
                    <p><strong>Artwork ID:</strong> ' . htmlspecialchars($artwork['id']) . '</p>
                    <p><strong>Artist:</strong> ' . htmlspecialchars($artwork['artist_name']) . '</p>
                    <p><strong>Description:</strong> ' . htmlspecialchars($artwork['description']) . '</p>
                    <p style="margin-bottom:60px;"><strong>Price:</strong> ₹' . number_format($artwork['price'], 2) . '</p>
                    <button onclick="showContainer()">Buy Now</button>
        
                </div>';
            }
        } else {
            echo "<p>No artworks available at the moment.</p>";
        }
        ?>
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

<!-- Add SweetAlert notifications -->
<?php
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

</body>
</html>
