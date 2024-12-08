<?php
include('config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM Employee WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['title'] = $row['Title'];
        
        switch ($row['Title']) {
            case 'Assistant':
                header("Location: assistant_page.php");
                break;
            case 'Secretary':
                header("Location: secretary_page.php");
                break;
            case 'Head of Department':
                header("Location: head_department_page.php");
                break;
            case 'Head of Secretary':
                header("Location: head_secretary_page.php");
                break;
            case 'Dean':
                header("Location: dean_page.php");
                break;
            default:
                echo "Invalid role.";
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <section class="container">
        <div class="login-container">
            
            <div class="form-container">
                
                <h1 class="opacity">LOGIN</h1>
                <form method="POST" action="">
                    <input type="text" name="username" placeholder="USERNAME" required />
                    <input type="password" name="password" placeholder="PASSWORD" required />
                    <button type="submit" class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="forget_password.php">FORGOT PASSWORD</a>
                </div>
            </div>
            
        </div>
    </section>
</body>
</html>
