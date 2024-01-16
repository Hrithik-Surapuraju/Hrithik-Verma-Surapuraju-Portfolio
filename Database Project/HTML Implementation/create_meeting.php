<?php
    include 'menu.php';

    // Get the meeting ID from the URL parameter
    $group_id = $_POST['group'];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $date = $_POST['date'];
    $start_time = $_POST['start'];
    $end_time = $_POST['end'];
    $name = $_POST['name'];
    $announcement = $_POST['announcement'];

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    $day_of_week = date("l", strtotime($date));


    // Make sure the meeting is on the weekend.
    if($day_of_week != "Saturday" && $day_of_week != "Sunday") {
        die("Invalid Date: Meeting must be on a Saturday or Sunday.");
    }

    $timediff = strtotime($end_time) - strtotime($start_time);

    // Make sure the meeting is an hour.
    if($timediff != 3600) {
        die("Meetings must be an hour long.");
    }

    // Make sure the group exists.
    $group_exists_query = "SELECT COUNT(*) as count FROM groups WHERE group_id = $group_id";
    $group_exists_result = mysqli_query($myconnection, $group_exists_query) or die('Query failed: ' . mysqli_error());
    $group_exists = mysqli_fetch_array($group_exists_result, MYSQLI_ASSOC);

    if($group_exists["count"] == 0) {
        die("Group does not exist.");
    }

    // Generate a meeting ID
    $meeting_id_query = "SELECT COALESCE(MAX(meeting_id), 0) as max FROM meetings";
    $meeting_id_result = mysqli_query($myconnection, $meeting_id_query) or die('Query failed: ' . mysqli_error());
    $meeting_id = mysqli_fetch_array($meeting_id_result, MYSQLI_ASSOC)["max"] + 1;

    // Find or make a new time_slot
    $time_query = "SELECT time_slot_id FROM time_slot WHERE day_of_the_week = '".$day_of_week."' AND TIME(start_time) = TIME '".$start_time."' AND TIME(end_time) = TIME '".$end_time."'";
    $time_result = mysqli_query($myconnection, $time_query) or die('Query failed: ' . mysqli_error());
    $time = mysqli_fetch_array($time_result, MYSQLI_ASSOC);


    if($time == NULL) {
        // Get the new id
        $new_id_query = "SELECT COALESCE(MAX(time_slot_id), 0) as max FROM time_slot";
        $new_id_result = mysqli_query($myconnection, $new_id_query) or die('Query failed: ' . mysqli_error());
        $new_id = mysqli_fetch_array($new_id_result, MYSQLI_ASSOC);
        $time_id = $new_id["max"] + 1;

        // Insert new time_slot
        $insert_time_query = "INSERT INTO time_slot VALUES($time_id, '".$day_of_week."', TIME '".$start_time."', TIME '".$end_time."')";
        mysqli_query($myconnection, $insert_time_query) or die('Query failed: ' . mysqli_error());
    } else {
            $time_id = $time["time_slot_id"];
    }

    $insert_query = "INSERT INTO meetings VALUES($meeting_id, '$name', DATE '$date', $time_id, 6, $group_id, \"".$announcement."\")";
    mysqli_query($myconnection, $insert_query) or die('Query failed: ' . mysqli_error());
    
    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>