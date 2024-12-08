<?php
include('config.php');
session_start();


$departmentID = $_POST['departmentID'];

if (empty($departmentID)) {
    echo "Please select a department.";
    exit;
}

$exam_query = "SELECT * FROM exam WHERE DepartmentID = $departmentID";
$exam_result = $conn->query($exam_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Schedule</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php

if ($exam_result && $exam_result->num_rows > 0) {
    echo "<h2>Exam Schedule for Department</h2>";
    echo "<table>";
    echo "<tr><th>Exam Name</th><th>Date</th><th>Time</th></tr>";
    while ($row = $exam_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['ExamName']."</td>";
        echo "<td>".$row['ExamDate']."</td>";
        echo "<td>".$row['time']."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No exams found for the selected department.";
}

$conn->close();
?>

</body>
</html>
