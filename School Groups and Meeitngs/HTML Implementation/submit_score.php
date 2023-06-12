<?php
    include 'menu.php';

    // Get the meeting ID from the URL parameter
    $assignment_id = $_POST['assignment_id'];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $student_id = $_POST['student_id'];
    $score = $_POST['score'];

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    $valid_submission_query = "SELECT COUNT(*) as count FROM submissions WHERE assignment_id = $assignment_id AND student_id = $student_id";
    $valid_submission_result = mysqli_query($myconnection, $valid_submission_query) or die('Query failed: ' . mysqli_error());
    $valid_submission = mysqli_fetch_array($valid_submission_result, MYSQLI_ASSOC);

    if($valid_submission["count"] == 0) {
        die("Could not find submission.");
    } else {
        $score_query = "UPDATE submissions SET score = $score WHERE assignment_id = $assignment_id AND student_id = $student_id";
        mysqli_query($myconnection, $score_query) or die('Query failed: ' . mysqli_error());
    }
    
    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>