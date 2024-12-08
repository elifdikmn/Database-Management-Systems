<?php
include('config.php');
session_start();
if (!isset($_SESSION['username']) || $_SESSION['title'] != 'Assistant') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$employeeQuery = "SELECT EmployeeID FROM Employee WHERE username = '$username'";
$employeeResult = $conn->query($employeeQuery);
if ($employeeResult->num_rows > 0) {
    $employeeRow = $employeeResult->fetch_assoc();
    $employeeID = $employeeRow['EmployeeID'];
} else {
    echo "Error: Employee not found";
    exit();
}

// Boş InstructorID'li kursları getir
$coursesQuery = "SELECT CourseID, CourseName FROM Courses WHERE InstructorID IS NOT NULL";
$coursesResult = $conn->query($coursesQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['selected_course'])) {
        $selectedCourseID = $_POST['selected_course'];

        // Seçilen kursun InstructorID'sini asistanın ID'siyle güncelle
        $updateCourseQuery = "UPDATE Courses SET InstructorID = '$employeeID' WHERE CourseID = '$selectedCourseID'";
        if ($conn->query($updateCourseQuery) === TRUE) {
            echo "Instructor assigned to course successfully.";
        } else {
            echo "Error assigning instructor to course: " . $conn->error;
        }

        // Asistanı weekly plana eklemek için güncelleme sorgusu
        $updateWeeklyPlanQuery = "INSERT INTO WeeklyPlan (CourseID, AssistantID) VALUES ('$selectedCourseID', '$employeeID')";
        if ($conn->query($updateWeeklyPlanQuery) === TRUE) {
            echo "Weekly plan updated successfully.";
            // Sayfayı yenile
            echo '<meta http-equiv="refresh" content="0">';
            exit();
        } else {
            echo "Error updating weekly plan: " . $conn->error;
        }
    }
}

// Asistanın haftalık planını al (kurslar ve sınavlar)
$examPlanQuery = "SELECT WeeklyPlan.*, Courses.CourseName, Exam.ExamDate, Exam.time
                  FROM WeeklyPlan
                  LEFT JOIN Courses ON WeeklyPlan.CourseID = Courses.CourseID
                  LEFT JOIN Exam ON WeeklyPlan.ExamID = Exam.ExamID
                  WHERE WeeklyPlan.AssistantID = '$employeeID' AND Exam.ExamDate IS NOT NULL";
$examPlanResult = $conn->query($examPlanQuery);

$coursePlanQuery = "SELECT WeeklyPlan.*, Courses.CourseName
                    FROM WeeklyPlan
                    LEFT JOIN Courses ON WeeklyPlan.CourseID = Courses.CourseID
                    LEFT JOIN Exam ON WeeklyPlan.ExamID = Exam.ExamID
                    WHERE WeeklyPlan.AssistantID = '$employeeID' AND Exam.ExamDate IS NULL";
$coursePlanResult = $conn->query($coursePlanQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Page</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            position: relative;
            width: 40rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        

        /* Tablo stilleri */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e9e9e9;
        }

        h2 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

    </style>
</head>
<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <h1 class="opacity">Welcome, <?php echo $username; ?></h1>
                <h2 class="opacity">Your Courses</h2>
                <form method="post">
                    <select name="selected_course">
                        <option value="">Select Course</option>
                        <?php while ($courseRow = $coursesResult->fetch_assoc()): ?>
                            <option value="<?php echo $courseRow['CourseID']; ?>"><?php echo $courseRow['CourseName']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="submit" value="Assign Instructor">
                </form>
                <h2 class="opacity">Weekly Plan</h2>
                <h3>Exams</h3>
                <table>
                    <tr>
                        <th>Course</th>
                        <th>Exam Date</th>
                        <th>Time</th>
                    </tr>
                    <?php while ($row = $examPlanResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['CourseName']; ?></td>
                            <td><?php echo $row['ExamDate']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <h3>Courses</h3>
                <table>
                    
                    <?php while ($row = $coursePlanResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['CourseName']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <form method="post">
                    <input type="submit" name="refresh" value="Refresh">
                </form>
            </div>
            <div class="circle circle-two"></div>
        </div>
    </section>
</body>
</html>
