<?php
include('config.php');
session_start();

session_start();
if (!isset($_SESSION['username']) || $_SESSION['title'] != 'Head of Department') {
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

$exam_query = "SELECT e.CourseID, c.CourseName, e.ExamName, e.ExamDate, e.time, CONCAT(a.FirstName, ' ', a.LastName) AS AssistantName
                FROM exam e
                INNER JOIN courses c ON e.CourseID = c.CourseID
                LEFT JOIN weeklyplan wp ON e.ExamID = wp.ExamID
                LEFT JOIN Employee a ON wp.AssistantID = a.EmployeeID
                ORDER BY e.ExamDate, e.time";
$exam_result = $conn->query($exam_query);

$workload_query = "SELECT wp.AssistantID, CONCAT(e.FirstName, ' ', e.LastName) AS AssistantName, COUNT(wp.PlanID) AS score 
                    FROM weeklyplan wp
                    INNER JOIN Employee e ON wp.AssistantID = e.EmployeeID 
                    GROUP BY wp.AssistantID";
$workload_result = $conn->query($workload_query);

$total_workloads = 0;
$workloads = array();
while ($row = $workload_result->fetch_assoc()) {
    $total_workloads += $row['score'];
    $workloads[$row['AssistantName']] = $row['score'];
}
$workload_result->data_seek(0); // Reset result pointer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Head of Department Page</title>
    <link rel="stylesheet" href="style_login.css">
    
</head>
<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <h1 class="opacity">Welcome, <?php echo $_SESSION['username']; ?></h1>
                <h2 class="opacity">Exam Schedule</h2>
                <table>
                    <tr>
                        <th>Course</th>
                        <th>Exam</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Assistant</th>
                    </tr>
                    <?php while ($row = $exam_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['CourseName']; ?></td>
                        <td><?php echo $row['ExamName']; ?></td>
                        <td><?php echo $row['ExamDate']; ?></td>
                        <td><?php echo $row['time']; ?></td>
                        <td><?php echo $row['AssistantName'] ? $row['AssistantName'] : 'No Assistant Assigned'; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <h2 class="opacity">Assistant Workloads</h2>
                <table>
                    <tr>
                        <th>Assistant</th>
                        <th>Percentage</th>
                    </tr>
                    <?php
                    
                    foreach ($workloads as $assistant => $score) {
                        $percentage = ($score / $total_workloads) * 100;
                        echo "<tr><td>" . $assistant . "</td><td>" . round($percentage, 2) . "%</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="circle circle-two"></div>
        </div>
    </section>
</body>
</html>
