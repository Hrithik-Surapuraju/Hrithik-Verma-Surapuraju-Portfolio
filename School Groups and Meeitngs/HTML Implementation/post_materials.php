<?php
    include 'menu.php';
    include 'display_meeting_members.php';

    // Get the meeting ID from the URL parameter
    $meeting_id = $_POST['meeting_id'];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $title = $_POST['name'];
    $author = $_POST['author'];
    $type = $_POST['type'];
    $url = $_POST['url'];
    $notes = $_POST['notes'];
    date_default_timezone_set('America/New_York');

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    $day_of_week = date("l");
    if($day_of_week != "Friday") {
        die("You may only post materials on friday for the following week.");
    }
    $curr_date = date("Y-m-d");
    $next_sunday = date("Y-m-d", time() + 86400 * 9);

    $valid_meeting_query = "SELECT COUNT(*) as count FROM meetings WHERE DATE(meetings.date) BETWEEN DATE '$curr_date' AND '$next_sunday'";
    $valid_meeting_result = mysqli_query($myconnection, $valid_meeting_query) or die('Query failed: ' . mysqli_error());
    $valid_meeting = mysqli_fetch_assoc($valid_meeting_result);

    if($valid_meeting["count"] == 0) {
        die("Invalid Meeting: must select a meeting scheduled within the next week.");
    }

    $material_id_query = "SELECT COALESCE(MAX(material_id), 0) as max FROM material";
    $material_id_result = mysqli_query($myconnection, $material_id_query) or die('Query failed: ' . mysqli_error());
    $material_id = mysqli_fetch_array($material_id_result, MYSQLI_ASSOC)["max"] + 1;

    $insert_query = "INSERT INTO material VALUES($material_id, $meeting_id, '$title', '$author', '$type', '$url', '$notes', DATE '$curr_date')";
    $insert_result = mysqli_query($myconnection, $insert_query) or die('Query failed: ' . mysqli_error());

    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>