<?php
include('config.php');
session_start();

if (!isset($_SESSION['username']) || $_SESSION['title'] !== 'Head of Secretary') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseName = $_POST['courseName'];
    $departmentID = $_POST['departmentID'];
    $instructorID = $_POST['instructorID'];

    // Add course
    $add_course_query = "INSERT INTO courses (CourseName, DepartmentID, InstructorID) VALUES ('$courseName', $departmentID, $instructorID)";
    if ($conn->query($add_course_query) === TRUE) {
        echo "Course added successfully.";
    } else {
        echo "Error: " . $add_course_query . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course - Head of Secretary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            padding: 8px;
            font-size: 16px;
            margin-top: 8px;
            margin-bottom: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .logout-button {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }
        .logout-button button {
            background-color: #dc3545;
            color: #fff;
        }
        .logout-button button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add Course</h1>

    <!-- Add course form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="courseName">Course Name:</label>
        <input type="text" id="courseName" name="courseName" required>

        <label for="departmentID">Department:</label>
        <select id="departmentID" name="departmentID" required>
            <?php
            $department_query = "SELECT * FROM department";
            $department_result = $conn->query($department_query);
            if ($department_result && $department_result->num_rows > 0) {
                while ($row = $department_result->fetch_assoc()):
            ?>
            <option value="<?php echo $row['DepartmentID']; ?>"><?php echo $row['DepartmentName']; ?></option>
            <?php
                endwhile;
            }
            ?>
        </select>

        <label for="instructorID">Instructor:</label>
        <select id="instructorID" name="instructorID" required>
            <?php
            $instructor_query = "SELECT * FROM employee WHERE Title = 'Assistant'";
            $instructor_result = $conn->query($instructor_query);
            if ($instructor_result && $instructor_result->num_rows > 0) {
                while ($row = $instructor_result->fetch_assoc()):
            ?>
            <option value="<?php echo $row['EmployeeID']; ?>"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></option>
            <?php
                endwhile;
            }
            ?>
        </select>

        <button type="submit">Add Course</button>
    </form>

    <div style="text-align: center;">
        <p><a href="head_secretary_page.php">Go back</a></p>
        <div class="logout-button">
            <form action="logout.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
