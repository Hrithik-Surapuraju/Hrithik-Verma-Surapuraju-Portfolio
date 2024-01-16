<?php
    include 'menu.php';
    include 'display_meeting_members.php';

    // Get the meeting ID from the URL parameter
    $meeting_id = $_GET['meeting_id'];
    $user_id = $_GET['user_id'];
    $user_type = $_GET['user_type'];

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    $enrolled_in_query = "SELECT COUNT(*) as count FROM enroll WHERE meeting_id = $meeting_id AND student_id = $user_id";
    $enrolled_in_result = mysqli_query($myconnection, $enrolled_in_query) or die('Query failed: ' . mysqli_error());
    $enrolled_in = mysqli_fetch_array($enrolled_in_result, MYSQLI_ASSOC);

    if($enrolled_in["count"] > 0) {
        displayMembers($meeting_id, $myconnection);
    } else {
        echo "You are not enrolled in meeting $meeting_id";
    }
    
    
    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>