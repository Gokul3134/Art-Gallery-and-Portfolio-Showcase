<?php
// Include database connection
include 'db.php';

// Get artwork ID from query parameter
$artwork_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch artwork details
$query = "SELECT a.title, a.price, a.image_path 
          FROM artworks a 
          WHERE a.id = $artwork_id";
$result = mysqli_query($conn, $query);
$artwork = mysqli_fetch_assoc($result);

if (!$artwork) {
    echo "<p>Artwork not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Now</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<header>
    <!-- Include your header code here -->
</header>

<main>
    <section class="buy-now">
        <h2>Buy Artwork</h2>
        <div class="artwork-details">
            <img src="<?php echo htmlspecialchars($artwork['image_path']); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?>" style="max-width: 300px;">
            <h3><?php echo htmlspecialchars($artwork['title']); ?></h3>
            <p>Price: ₹<?php echo number_format($artwork['price'], 2); ?></p>
        </div>
        <form action="process_purchase.php" method="post">
            <input type="hidden" name="artwork_id" value="<?php echo $artwork_id; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" required>
            <br>
            <label for="address">Shipping Address:</label>
            <textarea id="address" name="address" required></textarea>
            <br>
            <button type="submit">Buy Now</button>
        </form>
    </section>
</main>

<footer>
    <!-- Include your footer code here -->
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
