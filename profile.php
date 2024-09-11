<?php
session_start();

// Redirect non-logged-in users to the front page
if (!isset($_SESSION['user_id'])) {
    header("Location: front.php");
    exit();
}

// Include database connection
include 'db.php'; // Adjust the path if necessary

$success = null; // Variable to track success
$error_message = ''; // Variable to track error messages

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Determine if the user is an artist or visitor
$is_artist = ($user['role'] === 'artist');

// Handle form submission for artwork upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $is_artist) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image_path = 'uploads/' . basename($_FILES['image']['name']);

    // Handle file upload
    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO artworks (artist_id, title, description, category, price, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $title, $description, $category, $price, $image_path);

        if ($stmt->execute()) {
            $success = true; // Artwork submitted successfully
        } else {
            $error_message = $stmt->error;
            $success = false;
        }

        $stmt->close();
    } else {
        $error_message = "Failed to upload image.";
        $success = false;
    }
}

// Fetch artworks if the user is an artist
$artworks = [];
if ($is_artist) {
    $artwork_sql = "SELECT * FROM artworks WHERE artist_id = ?";
    $artwork_stmt = $conn->prepare($artwork_sql);
    $artwork_stmt->bind_param("i", $user_id);
    $artwork_stmt->execute();
    $artwork_result = $artwork_stmt->get_result();
    while ($artwork = $artwork_result->fetch_assoc()) {
        $artworks[] = $artwork;
    }
    $artwork_stmt->close();
}

// Fetch purchased artworks (for all users)
$purchased_artworks = [];
$purchased_sql = "
    SELECT artworks.title, artworks.description, artworks.category, artworks.price, artworks.image_path, sales.sale_price 
    FROM sales 
    JOIN artworks ON sales.artwork_id = artworks.id 
    WHERE sales.user_id = ?
";
$purchased_stmt = $conn->prepare($purchased_sql);
$purchased_stmt->bind_param("i", $user_id);
$purchased_stmt->execute();
$purchased_result = $purchased_stmt->get_result();
while ($artwork = $purchased_result->fetch_assoc()) {
    $purchased_artworks[] = $artwork;
}
$purchased_stmt->close();

// Fetch sold artworks (for artists)
$sold_artworks = [];
if ($is_artist) {
    $sold_sql = "
        SELECT artworks.title, artworks.description, artworks.category, artworks.price, artworks.image_path, SUM(sales.sale_price) as total_sales 
        FROM artworks 
        JOIN sales ON artworks.id = sales.artwork_id 
        WHERE artworks.artist_id = ? 
        GROUP BY artworks.id
    ";
    $sold_stmt = $conn->prepare($sold_sql);
    $sold_stmt->bind_param("i", $user_id);
    $sold_stmt->execute();
    $sold_result = $sold_stmt->get_result();
    while ($artwork = $sold_result->fetch_assoc()) {
        $sold_artworks[] = $artwork;
    }
    $sold_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

    <div class="sidebar" >
        <h2>Dashboard</h2>
        <a href="index.php" style="text-decoration: none;">Home</a>
        <a href="profile.php" style="text-decoration: none;">Profile</a>
        <?php if ($is_artist): ?>
            <a href="#upload-artwork" style="text-decoration: none;">Upload Artwork</a>
            <a href="#my-artworks" style="text-decoration: none;">My Artworks</a>
            <a href="#sold-artworks" style="text-decoration: none;">Sold Artworks</a>
        <?php endif; ?>
        <a href="#purchased-artworks" style="text-decoration: none;">Purchased Artworks</a>
        <a href="logout.php" style="text-decoration: none;">Logout</a>
    </div>

    <div class="main-content">
        <div class="user-profile">
            <h2>User Profile</h2>
            <table class="user-details">
                <tr>
                    <th>User ID</th>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                </tr>
                <?php if ($is_artist): ?>
                    <tr>
                        <th>Biography</th>
                        <td><?php echo htmlspecialchars($user['biography']); ?></td>
                    </tr>
                    <tr>
                        <th>Artist Image</th>
                        <td>
                            <?php if ($user['artist_image']): ?>
                                <img src="uploads/<?php echo htmlspecialchars($user['artist_image']); ?>" alt="Artist Image" style="max-width: 300px;height:350px">
                            <?php else: ?>
                                No image available
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <!-- Upload Artwork Section (for artists) -->
        <?php if ($is_artist): ?>
            <section id="upload-artwork" class="upload-section">
                <div class="modal-content">
                    <h1>Upload Your Artwork</h1>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" required><br>

                        <label for="description">Description:</label>
                        <textarea name="description" id="description" required></textarea><br>

                        <label for="category">Category:</label>
                        <input type="text" name="category" id="category" required><br>

                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" step="0.01" required><br>

                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image" accept="image/*" required><br>

                        <button type="submit">Submit Artwork</button>
                    </form>
                </div>
            </section>
        <?php endif; ?>

        <!-- My Artworks Section (for artists) -->
        <?php if ($is_artist): ?>
            <section id="my-artworks" class="artwork-details">
                <h2>My Artworks</h2>
                <?php if (!empty($artworks)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($artworks as $artwork): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($artwork['title']); ?></td>
                                    <td><?php echo htmlspecialchars($artwork['description']); ?></td>
                                    <td><?php echo htmlspecialchars($artwork['category']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($artwork['price']); ?></td>
                                    <td>
                                        <img src="<?php echo str_replace('uploads/uploads/', 'uploads/', 'uploads/' . htmlspecialchars($artwork['image_path'])); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" style="max-width: 200px;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You haven't uploaded any artworks yet.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <!-- Sold Artworks Section (for artists) -->
        <?php if ($is_artist): ?>
            <section id="sold-artworks" class="artwork-details">
                <h2>Sold Artworks</h2>
                <?php if (!empty($sold_artworks)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sold_artworks as $artwork): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($artwork['title']); ?></td>
                                    <td><?php echo htmlspecialchars($artwork['description']); ?></td>
                                    <td><?php echo htmlspecialchars($artwork['category']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($artwork['price']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($artwork['total_sales']); ?></td>
                                    <td>
                                        <img src="<?php echo str_replace('uploads/uploads/', 'uploads/', 'uploads/' . htmlspecialchars($artwork['image_path'])); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" style="max-width: 200px;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No artworks have been sold yet.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <!-- Purchased Artworks Section -->
        <section id="purchased-artworks" class="artwork-details">
            <h2>Purchased Artworks</h2>
            <?php if (!empty($purchased_artworks)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchased_artworks as $artwork): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($artwork['title']); ?></td>
                                <td><?php echo htmlspecialchars($artwork['description']); ?></td>
                                <td><?php echo htmlspecialchars($artwork['category']); ?></td>
                                <td>₹<?php echo htmlspecialchars($artwork['sale_price']); ?></td>
                                <td>
                                    <img src="<?php echo str_replace('uploads/uploads/', 'uploads/', 'uploads/' . htmlspecialchars($artwork['image_path'])); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" style="max-width: 200px;">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You haven't purchased any artworks yet.</p>
            <?php endif; ?>
        </section>

    </div>
</body>
</html>
