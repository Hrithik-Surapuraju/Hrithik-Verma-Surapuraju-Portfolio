<?php
    include 'menu.php';

    // Get the meeting ID from the URL parameter
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $student = $_POST['student'];

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    

    $student_query = "SELECT DISTINCT student_id as s_id FROM students, users WHERE student_id = users.id AND users.email = '".$student."' AND student_id NOT IN(SELECT student_id FROM child_of WHERE parent_id = $user_id)";
    $student_result = mysqli_query($myconnection, $student_query) or die('Query failed: ' . mysqli_error());
    $s_id = mysqli_fetch_array($student_result, MYSQLI_ASSOC);
    if($s_id == NULL) {
        die("User " . $student . " not found, is not a student or is already your child.");
    }
    else {
        $student_id = $s_id["s_id"];
        $insert_query = "INSERT INTO child_of VALUES($student_id, $user_id)";
        mysqli_query($myconnection, $insert_query) or die('Query failed: ' . mysqli_error());

    }
    mysqli_free_result($student_result);
    
    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>