<?php
// artist_details.php

// Include database connection (replace with your actual connection file or credentials)
include 'db.php';

$query = "SELECT name, biography, artist_image FROM users WHERE role = 'artist'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($artist = mysqli_fetch_assoc($result)) {
        echo '
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <img src="uploads/' . htmlspecialchars($artist['artist_image']) . '" alt="' . htmlspecialchars($artist['name']) . '">
                </div>
                <div class="flip-card-back">
                    <h2>' . htmlspecialchars($artist['name']) . '</h2>
                    <p>' . htmlspecialchars($artist['biography']) . '</p>
                </div>
            </div>
        </div>
        ';
    }
} else {
    echo '<p>No artists found.</p>';
}

// Close the connection
mysqli_close($conn);
?>
