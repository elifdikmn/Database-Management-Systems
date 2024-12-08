<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $courseName = $_POST['courseName'];
    $departmentID = $_POST['departmentID'];
    $instructorID = $_POST['instructorID'];

    if (!empty($courseName) && !empty($departmentID) && !empty($instructorID)) {
  
        $insertCourseQuery = "INSERT INTO Courses (CourseName, DepartmentID, InstructorID) 
                        VALUES ('$courseName', '$departmentID', '$instructorID')";

        if ($conn->query($insertCourseQuery) === TRUE) {

            $courseID = $conn->insert_id;

            $insertWeeklyPlanQuery = "INSERT INTO weeklyplan (CourseID, AssistantID) 
                            VALUES ('$courseID', '$instructorID')";
            
        
            if ($conn->query($insertWeeklyPlanQuery) === TRUE) {

                header('Location: secretary_page.php');
                exit();
            } else {
                echo "Error: " . $insertWeeklyPlanQuery . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $insertCourseQuery . "<br>" . $conn->error;
        }
    } else {

        echo "Error: All fields are required.";
    }
}
?>
