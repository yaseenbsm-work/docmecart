<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration & Login Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@400;600&display=swap">
    <style>
        body {
            background: linear-gradient(to right, #e0f2f1, #ffffff); 
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 500px; 
            width: 100%;
            background: #ffffff; 
            padding: 30px; 
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); 
            border: 2px solid #004d40; 
            overflow: hidden; 
        }
        .header {
            text-align: center;
            margin-bottom: 20px; 
        }
        .header img {
            width: 180px; 
            height: auto;
        }
        h1 {
            color: #004d40;  
            font-size: 24px; 
            margin: 10px 0;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #004d40; 
            font-family: 'Roboto', sans-serif;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px; 
            margin-bottom: 16px; 
            border: 1px solid #004d40; 
            border-radius: 8px; 
            font-size: 16px; 
            box-sizing: border-box;
            background-color: #ffffff; 
            color: #000000; 
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #388e3c; 
            outline: none;
            box-shadow: 0 0 0 3px rgba(56, 142, 60, 0.2); 
        }
        input[type="submit"] {
            background-image: linear-gradient(to right, #004d40, #00796b); 
            border: none;
            color: #ffffff; 
            padding: 12px;
            font-size: 18px; 
            cursor: pointer;
            border-radius: 8px; 
            transition: background-color 0.3s, transform 0.3s;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
        }
        input[type="submit"]:hover {
            background: linear-gradient(to right, #e0f2f1, #e0f2f2);
            color: green; 
            transform: scale(1.05);
        }
        .error {
            color: #d32f2f; 
            font-size: 14px; 
            margin-top: -6px;
            margin-bottom: 14px;
            font-family: 'Roboto', sans-serif;
        }
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .tabs button {
            background: #004d40;
            color: white;
            border: none;
            border-radius: 8px 8px 0 0;
            padding: 12px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
            width: 50%;
        }
        .tabs button.active {
            background: #ffffff;
            color:  #004d40;
        }
        .form-container {
            display: none;
        }
        .form-container.active {
            display: block;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px; 
            }
            h1 {
                font-size: 22px; 
            }
            input[type="submit"] {
                font-size: 16px; 
            }
            .tabs button {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php
$servername = "localhost";
$username = "yaseen";
$password = "Yaseen@123";
$dbname = "own_cart";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

$fullName = $email = $password = $confirmPassword = "";
$loginEmail = $loginPassword = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $fullName = sanitizeInput($_POST["fullName"]);
        $email = sanitizeInput($_POST["email"]);
        $password = sanitizeInput($_POST["password"]);
        $confirmPassword = sanitizeInput($_POST["confirmPassword"]);

        // Validate Full Name
        if (empty($fullName) || !preg_match("/^[a-zA-Z\s]+$/", $fullName)) {
            $errors['fullName'] = "Full Name is required and must contain only letters and spaces.";
        }

        // Validate Email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "A valid Email Address is required.";
        } else {
            // Check if email is already registered
            $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors['email'] = "This email is already registered.";
            }
            $stmt->close();
        }

        // Validate Password
        if (strlen($password) < 8) {
            $errors['password'] = "Password is required and must be at least 8 characters long.";
        }

        // Validate Confirm Password
        if ($password !== $confirmPassword) {
            $errors['confirmPassword'] = "Passwords do not match.";
        }

        // If no errors, proceed with registration
        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullName, $email, $hashedPassword);

            if ($stmt->execute()) {
                echo "<script>
                    $(document).ready(function() {
                        alert('Registration successful! Welcome to Docme Cart, $fullName.');
                        window.location.href = 'task5.1.php';
                    });
                </script>";
            } else {
                $errors['general'] = "An error occurred while registering. Please try again.";
            }
            $stmt->close();
        }
    } elseif (isset($_POST["login"])) {
        $loginEmail = sanitizeInput($_POST["loginEmail"]);
        $loginPassword = sanitizeInput($_POST["loginPassword"]);

        // Validate Login Email
        if (empty($loginEmail) || !filter_var($loginEmail, FILTER_VALIDATE_EMAIL)) {
            $errors['loginEmail'] = "A valid Email Address is required.";
        } else {
            // Check if email is registered
            $stmt = $conn->prepare("SELECT password, is_admin FROM users WHERE email=?");
            $stmt->bind_param("s", $loginEmail);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 0) {
                $errors['loginEmail'] = "Email not registered.";
            } else {
                $stmt->bind_result($storedPassword, $isAdmin);
                $stmt->fetch();
                // Validate Login Password
                if (!password_verify($loginPassword, $storedPassword)) {
                    $errors['loginPassword'] = "Incorrect password.";
                } else {
                    // Successful login
                    session_start();
                    $_SESSION['user_email'] = $loginEmail;
                    $_SESSION['is_admin'] = $isAdmin;

                    $redirectUrl = $isAdmin ? 'task5.php' : 'task5.1.php';

                    echo "<script>
                        $(document).ready(function() {
                            alert('Login successful! Welcome back to Docme Cart.');
                            window.location.href = '$redirectUrl';
                        });
                    </script>";                }
            }
            $stmt->close();
        }
    }
}
?>

<div class="container">
    <div class="header">
        <img src="docme.png" alt="Logo">
        <h1>Registration & Login</h1>
    </div>
    <div class="tabs">
        <button class="active" data-target="#registerForm">Register</button>
        <button data-target="#loginForm">Login</button>
    </div>
    <div class="form-container active" id="registerForm">
        <form id="registrationForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" value="<?php echo $fullName; ?>" required>
            <div class="error"><?php echo isset($errors['fullName']) ? $errors['fullName'] : ''; ?></div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            <div class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></div>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></div>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <div class="error"><?php echo isset($errors['confirmPassword']) ? $errors['confirmPassword'] : ''; ?></div>

            <input type="submit" name="register" value="Register">
        </form>
    </div>
    <div class="form-container" id="loginForm">
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="loginEmail">Email:</label>
            <input type="email" id="loginEmail" name="loginEmail" value="<?php echo $loginEmail; ?>" required>
            <div class="error"><?php echo isset($errors['loginEmail']) ? $errors['loginEmail'] : ''; ?></div>

            <label for="loginPassword">Password:</label>
            <input type="password" id="loginPassword" name="loginPassword" required>
            <div class="error"><?php echo isset($errors['loginPassword']) ? $errors['loginPassword'] : ''; ?></div>

            <input type="submit" name="login" value="Login">
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.tabs button').click(function() {
            $('.tabs button').removeClass('active');
            $(this).addClass('active');
            $('.form-container').removeClass('active');
            $($(this).data('target')).addClass('active');
        });

        // Client-side validation
        $('#registrationForm input').on('keyup input', function() {
            var fullName = $('#fullName').val().trim();
            var email = $('#email').val().trim();
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();

            var valid = true;

            // Full Name Validation
            if (!/^[a-zA-Z\s]+$/.test(fullName)) {
                $('#fullName').next('.error').text('Full Name is required and must contain only letters and spaces.');
                valid = false;
            } else {
                $('#fullName').next('.error').text('');
            }

            // Email Validation
            if (!/^\S+@\S+\.\S+$/.test(email)) {
                $('#email').next('.error').text('A valid Email Address is required.');
                valid = false;
            } else {
                $('#email').next('.error').text('');
            }

            // Password Validation
            if (password.length < 8) {
                $('#password').next('.error').text('Password is required and must be at least 8 characters long.');
                valid = false;
            } else {
                $('#password').next('.error').text('');
            }

            // Confirm Password Validation
            if (password !== confirmPassword) {
                $('#confirmPassword').next('.error').text('Passwords do not match.');
                valid = false;
            } else {
                $('#confirmPassword').next('.error').text('');
            }

            // Enable/Disable Submit Button
            if (!valid) {
                $('input[type="submit"]').prop('disabled', true);
            } else {
                $('input[type="submit"]').prop('disabled', false);
            }
        });

        $('#loginForm input').on('keyup input', function() {
            var loginEmail = $('#loginEmail').val().trim();
            var loginPassword = $('#loginPassword').val();

            var valid = true;

            // Login Email Validation
            if (!/^\S+@\S+\.\S+$/.test(loginEmail)) {
                $('#loginEmail').next('.error').text('A valid Email Address is required.');
                valid = false;
            } else {
                $('#loginEmail').next('.error').text('');
            }

            // Login Password Validation
            if (loginPassword.length < 8) {
                $('#loginPassword').next('.error').text('Password is required and must be at least 8 characters long.');
                valid = false;
            } else {
                $('#loginPassword').next('.error').text('');
            }

            // Enable/Disable Submit Button
            if (!valid) {
                $('input[type="submit"]').prop('disabled', true);
            } else {
                $('input[type="submit"]').prop('disabled', false);
            }
        });
    });
</script>

</body>
</html>
