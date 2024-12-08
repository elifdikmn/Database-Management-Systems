<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_name = isset($_POST['exam_name']) ? $_POST['exam_name'] : '';
    $exam_date = isset($_POST['exam_date']) ? $_POST['exam_date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $course_id = isset($_POST['course_id']) ? $_POST['course_id'] : '';
    $instructor_id = isset($_POST['instructor_id']) ? $_POST['instructor_id'] : '';

    if (empty($exam_name)) {
        echo "Exam name is required.";
        exit();
    }

    if (empty($exam_date)) {
        echo "Exam date is required.";
        exit();
    }

    if (empty($time)) {
        echo "Exam time is required.";
        exit();
    }

    if (empty($course_id)) {
        echo "Course ID is required.";
        exit();
    }

    if (empty($instructor_id)) {
        echo "Instructor ID is required.";
        exit();
    }

    $exam_query = "INSERT INTO Exam (ExamName, ExamDate, time, CourseID, InstructorID) VALUES ('$exam_name', '$exam_date', '$time', '$course_id', '$instructor_id')";

    if ($conn->query($exam_query) === TRUE) {
        $exam_id = $conn->insert_id;

        $weekly_plan_query = "INSERT INTO weeklyplan (CourseID, ExamID, AssistantID) VALUES ('$course_id', '$exam_id', '$instructor_id')";

        if ($conn->query($weekly_plan_query) === TRUE) {
            echo "Exam created successfully";
            
        } else {
            echo "Error: " . $weekly_plan_query . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $exam_query . "<br>" . $conn->error;
    }
    header('secretary_page.php');
    exit();
}
            
?>
