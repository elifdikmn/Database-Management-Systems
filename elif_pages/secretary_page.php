<?php
include('config.php');
session_start();
if (!isset($_SESSION['username']) || $_SESSION['title'] != 'Secretary') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Kullanıcının EmployeeID'sini al
$employeeQuery = "SELECT * FROM Employee WHERE username = '$username'";
$employeeResult = $conn->query($employeeQuery);
if ($employeeResult->num_rows > 0) {
    $employeeRow = $employeeResult->fetch_assoc();
    $employeeID = $employeeRow['EmployeeID'];
} else {
    echo "Error: Employee not found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretary Page</title>
    <link rel="stylesheet" href="style_secretary.css">
    <script>
        function showSection(sectionId) {
            var sections = document.querySelectorAll('.form-container');
            sections.forEach(function(section) {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</head>
<body>
    <section class="container">
        <div class="login-container">
            <div class="menu-container">
                <button onclick="showSection('createExam')">Create Exam</button>
                <button onclick="showSection('insertCourse')">Insert Course</button>
                <button onclick="location.href='logout.php'">Logout</button>
            </div>

            <div class="form-container" id="createExam" style="display: none;">
                <h2>Create Exam</h2>
                <form action="create_exam.php" method="post">
                    <input type="text" name="exam_name" placeholder="Exam Name" required />
                    <input type="date" name="exam_date" placeholder="Exam Date" required />
                    <input type="time" name="time" placeholder="Exam Time" required />
                    
                    <!-- CourseID ve InstructorID dropdown menüleri -->
                    <select name="course_id" required>
                        <option value="">Select Course</option>
                        <?php
                        // Mevcut kursları veritabanından al
                        $courseQuery = "SELECT CourseID, CourseName FROM Courses";
                        $courseResult = $conn->query($courseQuery);
                        while ($courseRow = $courseResult->fetch_assoc()) {
                            echo "<option value='" . $courseRow['CourseID'] . "'>" . $courseRow['CourseName'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    
                    <select name="instructor_id" required>
                        <option value="">Select Instructor</option>
                        <?php
                        // Mevcut eğitmenleri veritabanından al
                        $instructorQuery = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) as FullName FROM Employee WHERE Title = 'Assistant'";
                        $instructorResult = $conn->query($instructorQuery);
                        if ($instructorResult && $instructorResult->num_rows > 0) {
                            while ($instructorRow = $instructorResult->fetch_assoc()) {
                                echo "<option value='" . $instructorRow['EmployeeID'] . "'>" . $instructorRow['FullName'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No Assistants Available</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <button type="submit">Submit</button>
                </form>
            </div>

            <div class="form-container" id="insertCourse" style="display: none;">
                <h2>Insert Course</h2>
                <form action="insert_course.php" method="post">
                    <label for="courseName">Course Name:</label>
                    <input type="text" id="courseName" name="courseName" required>

                    <label for="departmentID">Department:</label>
                    <select id="departmentID" name="departmentID" required>
                        <!-- Veritabanından departmanları çek ve seçenekleri oluştur -->
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
                        <!-- Veritabanından sadece Assistant olanları çek ve seçenekleri oluştur -->
                        <?php
                        $assistant_query = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) as FullName FROM Employee WHERE Title = 'Assistant'";
                        $assistant_result = $conn->query($assistant_query);
                        if ($assistant_result && $assistant_result->num_rows > 0) {
                            while ($row = $assistant_result->fetch_assoc()):
                        ?>
                        <option value="<?php echo $row['EmployeeID']; ?>"><?php echo $row['FullName']; ?></option>
                        <?php
                            endwhile;
                        }
                        ?>
                    </select>

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
