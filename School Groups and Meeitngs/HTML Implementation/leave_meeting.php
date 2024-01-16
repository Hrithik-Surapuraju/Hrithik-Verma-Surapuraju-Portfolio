<?php
    include 'menu.php';

    // Get the meeting ID from the URL parameter
    $meeting_id = $_POST['meeting_id'];
    $user_id = $_POST['user_id'];
    $student_id = $user_id;
    $user_type = $_POST['user_type'];
    date_default_timezone_set('America/New_York');

    //$time_query = "SELECT day_of_the_week, start_time, end_time FROM time_slot WHERE time_slot_id = " . $meeting_row["time_slot_id"];
    //$time_result = mysqli_query($myconnection, $time_query) or die('Query failed: ' . mysqli_error());
    //$time_row = mysqli_fetch_array($time_result, MYSQLI_ASSOC);

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    $curr_date = date("Y-m-d");
    $curr_time = date("H:i:s");

    if($user_type == "parent") {
        if($_POST['student'] != NULL) {
            $student = $_POST['student'];

            $is_child_query = "SELECT DISTINCT student_id as s_id FROM child_of WHERE student_id IN(SELECT students.student_id FROM users, students WHERE users.id = students.student_id AND users.email = '".$student."') AND parent_id = $user_id";
            $is_child_result = mysqli_query($myconnection, $is_child_query) or die('Query failed: ' . mysqli_error());
            $is_student = mysqli_fetch_array($is_child_result, MYSQLI_ASSOC);
            if($is_student == NULL) {
                die("User " . $student . " not found, is not a student or is not your child.");
            }
            else $student_id = $is_student['s_id'];
            mysqli_free_result($is_child_result);
        }
    }
    
    if($meeting_id != "") { // Leaving single meeting
        $valid_meeting_query = "SELECT COUNT(*) as count 
                                FROM meetings as m1, time_slot as t1
                                WHERE meeting_id = $meeting_id 
                                    AND meeting_id IN (SELECT meeting_id FROM enroll WHERE student_id = $student_id)
                                    AND DATE(m1.date) >= DATE '" . $curr_date . "'
                                    AND m1.time_slot_id = t1.time_slot_id
                                    AND TIME(t1.start_time) > TIME'".$curr_time."'";

    
        $valid_meeting_result = mysqli_query($myconnection, $valid_meeting_query) or die('Query failed: ' . mysqli_error());
        $valid_meeting = mysqli_fetch_array($valid_meeting_result, MYSQLI_ASSOC);
        if($valid_meeting['count'] == 0) {
            echo "Meeting not found, or you are unable to leave.";
        }
        else {
            $delete_query = "DELETE FROM enroll WHERE meeting_id = $meeting_id AND student_id = $student_id";
            $delete_result = mysqli_query($myconnection, $delete_query) or die('Query failed: ' . mysqli_error());
            echo "Successfully left meeting $meeting_id";
        }
    } else { // Leaving all meetings
            $delete_query = "DELETE FROM enroll WHERE student_id = $student_id 
                                AND meeting_id IN (
                                    SELECT meeting_id
                                    FROM meetings, time_slot
                                    WHERE DATE(meetings.date) >= DATE '".$curr_date."' 
                                        AND meetings.time_slot_id = time_slot.time_slot_id)";
            $delete_result = mysqli_query($myconnection, $delete_query) or die('Query failed: ' . mysqli_error());
            echo "Successfully left all future meetings.";
            echo "<br><br><br>";
            
    }
    
    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>