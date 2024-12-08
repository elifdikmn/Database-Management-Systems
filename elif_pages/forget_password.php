<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $username = $_POST['username'];
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Şifreyi güncelleme sorgusu
        $update_query = "UPDATE Employee SET password = '$new_password' WHERE username = '$username' AND email = '$email'";
        $result = $conn->query($update_query);
        
        if ($result === TRUE) {
            $update_message = '<div class="success">Password updated successfully.</div>';
            header('Location: login.php');
            exit();
        } else {
            $update_message = '<div class="error">Error updating password: ' . $conn->error . '</div>';
        }
    } else {
        $update_message = '<div class="error">Passwords do not match.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <section class="container">
        <div class="login-container">
            
            <div class="form-container">
                
                <h1 class="opacity">FORGOT PASSWORD</h1>
                <form method="POST">
                    <input type="text" name="username" placeholder="USERNAME" />
                    <input type="email" name="email" placeholder="EMAIL" />
                    <input type="password" name="new_password" placeholder="NEW PASSWORD" />
                    <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" />
                    <button type="submit" class="opacity">SUBMIT</button>
                </form>
            </div>
            
        </div>
    </section>
</body>
</html>

