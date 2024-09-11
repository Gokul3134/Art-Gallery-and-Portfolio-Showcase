<?php
// Include database connection
include 'db.php'; // Assuming you have a database connection file


// Fetch and display artworks with image zoom functionality
$query = "SELECT a.id, a.title, a.description, a.category, a.price, a.image_path, u.name as artist_name 
          FROM artworks a 
          JOIN users u ON a.artist_id = u.id
          LIMIT 8";

$result = mysqli_query($conn, $query);

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

