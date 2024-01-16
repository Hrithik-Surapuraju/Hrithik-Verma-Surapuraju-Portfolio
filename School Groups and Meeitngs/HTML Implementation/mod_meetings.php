<?php
    include "menu.php";
    $user_id = $_POST["user_id"];
    $user_type = $_POST["user_type"];
    $meeting = $_POST["meeting_id"];
    $name = $_POST["new_name"];
    $announcement = $_POST["new_announcement"];
    $date = $_POST["new_date"];
    $start_time = $_POST["new_start"];
    $end_time = $_POST["new_end"];
    date_default_timezone_set('America/New_York');

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    $valid_meet_query = "SELECT COUNT(*) as count, meetings.date, meetings.time_slot_id FROM meetings WHERE meeting_id = $meeting";
    $valid_meet_result = mysqli_query($myconnection, $valid_meet_query) or die('Query failed: ' . mysqli_error());
    $valid_meet = mysqli_fetch_array($valid_meet_result, MYSQLI_ASSOC);
    $startdate = $valid_meet["date"];
    $day_of_week = "Saturday";

    $time_query = "SELECT start_time, end_time, day_of_the_week FROM time_slot WHERE time_slot_id = ". $valid_meet["time_slot_id"];
    $time_result = mysqli_query($myconnection, $time_query) or die('Query failed: ' . mysqli_error());
    $time = mysqli_fetch_array($time_result, MYSQLI_ASSOC);

    if($valid_meet["count"] == 0) {
        echo "Could not find meeting $meeting";
    } else {
        // Doing seperate queries for this is inefficient but I didn't think of another way until I implemented all of them.
        if($name != "") {
            $update_query = "UPDATE meetings SET meeting_name = '".$name."' WHERE meeting_id = $meeting";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
        if($announcement != "") {
            $update_query = "UPDATE meetings SET announcement = '".$announcement."' WHERE meeting_id = $meeting";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
        if($date != "") {
            $day_of_week = date("l", strtotime($date));
            if($day_of_week == "Saturday" || $day_of_week == "Sunday") {
                $update_query = "UPDATE meetings SET meetings.date = DATE '".$date."' WHERE meeting_id = $meeting";
                mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
            }
            else echo "Could not change date: Invalid day of the week.";
        }
        if($date != "" || $start_time != "" || $end_time != "") {
            if($start_time == "") {
                $start_time = $time["start_time"];
            }
            if($end_time == "") {
                $end_time = $time["end_time"];
            }
            if($date == "" && ($day_of_week != "Saturday" || $day_of_week != "Sunday")) {
                $day_of_week = $time["day_of_the_week"];
            } else {
                $day_of_week = date("l", strtotime($date));
            }
            $new_time_query = "SELECT time_slot_id FROM time_slot WHERE day_of_the_week = '".$day_of_week."' AND TIME(start_time) = TIME '".$start_time."' AND TIME(end_time) = TIME '".$end_time."'";
            $new_time_result = mysqli_query($myconnection, $new_time_query) or die('Query failed: ' . mysqli_error());
            $new_time = mysqli_fetch_array($new_time_result, MYSQLI_ASSOC);
            

            if($new_time == NULL) {
                // Get the new id
                $new_id_query = "SELECT COALESCE(MAX(time_slot_id), 0) as max FROM time_slot";
                $new_id_result = mysqli_query($myconnection, $new_id_query) or die('Query failed: ' . mysqli_error());
                $new_id = mysqli_fetch_array($new_id_result, MYSQLI_ASSOC);
                $time_id = $new_id["max"] + 1;

                // Insert new time_slot
                $insert_time_query = "INSERT INTO time_slot VALUES($time_id, '".$day_of_week."', TIME '".$start_time."', TIME '".$end_time."')";
                mysqli_query($myconnection, $insert_time_query) or die('Query failed: ' . mysqli_error());
            } else {
                $time_id = $new_time["time_slot_id"];
            }
                // Update time_slot in meeting
                $update_query = "UPDATE meetings SET time_slot_id = $time_id WHERE meeting_id = $meeting";
                mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
    }

    mysqli_free_result($valid_meet_result);
    mysqli_free_result($time_result);

    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>