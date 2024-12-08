<?php
include('config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Selection</title>
</head>
<body>

<h1>Choose a Department</h1>

<form method="POST" action="examSchedule.php">
    <label for="departments">Choose a department:</label>
    <select id="departments" name="departmentID"> <!-- Changed name attribute to departmentID -->
        <option value="">Select Department</option>
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
    <button type="submit">Show Exam Schedule</button>
</form>

</body>
</html>
