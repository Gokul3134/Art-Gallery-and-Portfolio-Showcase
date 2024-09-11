<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Front Page</title>
    <link rel="stylesheet" href="front.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .content a {
            text-decoration: none;
            background-color: #0d6efd;
            color: #ffffff;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="background-image">
        <div class="content">
            <h1>Welcome to Our Art Gallery</h1>
            <p>Your journey starts here. Explore our services and offerings.</p>
            <a href="#" id="learnMore">Login / Register</a>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" id="loginClose">&times;</span>
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <label>Email:</label>
                <input type="email" name="email" required><br>
                <label>Password:</label>
                <input type="password" name="password" required><br>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="#" id="showRegister">Register here</a></p>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close" id="registerClose">&times;</span>
            <h2>Register</h2>
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <label>Name:</label>
                <input type="text" name="name" required><br>
                <label>Email:</label>
                <input type="email" name="email" required><br>
                <label>Password:</label>
                <input type="password" name="password" required><br>
                <label>Role:</label>
                <select name="role" id="roleSelect" required>
                    <option value="select">Select</option>
                    <option value="artist">Artist</option>
                    <option value="visitor">Visitor</option>
                </select><br>
                <div id="artistFields" class="hidden">
                    <label>Artist Biography:</label>
                    <textarea name="biography" rows="4" cols="50" placeholder="Write a short biography"></textarea><br>
                    <label>Artist Image:</label>
                    <input type="file" name="artist_image" accept="image/*"><br>
                </div>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="#" id="showLogin">Login here</a></p>
        </div>
    </div>

    <script>
        // Get the modals
        var loginModal = document.getElementById('loginModal');
        var registerModal = document.getElementById('registerModal');

        // Get the buttons that open the modals
        var learnMore = document.getElementById('learnMore');

        // Get the <span> elements that close the modals
        var loginClose = document.getElementById('loginClose');
        var registerClose = document.getElementById('registerClose');

        // Get the links to switch between forms
        var showRegister = document.getElementById('showRegister');
        var showLogin = document.getElementById('showLogin');

        // Get role select and artist fields
        var roleSelect = document.getElementById('roleSelect');
        var artistFields = document.getElementById('artistFields');

        // When the user clicks on the "Learn More" link, open the login modal
        learnMore.onclick = function(event) {
            event.preventDefault(); // Prevent the default anchor behavior
            loginModal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the corresponding modal
        loginClose.onclick = function() {
            loginModal.style.display = "none";
        }

        registerClose.onclick = function() {
            registerModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target === loginModal) {
                loginModal.style.display = "none";
            }
            if (event.target === registerModal) {
                registerModal.style.display = "none";
            }
        }

        // Show the register modal when the user clicks the "Register here" link
        showRegister.onclick = function() {
            loginModal.style.display = "none";
            registerModal.style.display = "block";
        }

        // Show the login modal when the user clicks the "Login here" link
        showLogin.onclick = function() {
            registerModal.style.display = "none";
            loginModal.style.display = "block";
        }

        // Show or hide artist fields based on role selection
        roleSelect.onchange = function() {
            if (roleSelect.value === 'artist') {
                artistFields.classList.remove('hidden');
            } else {
                artistFields.classList.add('hidden');
            }
        };

        // SweetAlert2 message based on registration status
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful!',
                    text: 'You have been successfully registered.',
                });
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: 'There was an error registering your account.',
                });
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
