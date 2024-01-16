<?php
    include 'menu.php';
    include 'display_meeting_members.php';

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

    $curr_week_day = date('l');

    $curr_date = date("Y-m-d");

    if($curr_week_day == "Friday" || $curr_week_day == "Saturday" || $curr_week_day == "Sunday") {
        die("Users may only join meetings before Friday.");
    }
    if($user_type == "admin") {
        if($_POST['student'] != NULL) {
            $student = $_POST['student'];

            $is_student_query = "SELECT DISTINCT students.student_id as s_id FROM users, students WHERE users.id = students.student_id AND users.email = '$student'";
            $is_student_result = mysqli_query($myconnection, $is_student_query) or die('Query failed: ' . mysqli_error());
            $is_student = mysqli_fetch_array($is_student_result, MYSQLI_ASSOC);
            if($is_student == NULL) {
                die("User " . $student . " not found or is not a student.");
            }
            else $student_id = $is_student['s_id'];
            mysqli_free_result($is_student_result);
        }
    }
    else if($user_type == "parent") {
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
    
    if($meeting_id != "") {
        $valid_meeting_query = "SELECT COUNT(*) as count 
                                FROM meetings as m1 
                                WHERE meeting_id = $meeting_id 
                                    AND group_id IN (SELECT group_id FROM member_of WHERE student_id = $student_id)
                                    AND meeting_id NOT IN (SELECT meeting_id FROM enroll WHERE student_id = $student_id)
                                    AND capacity NOT IN (SELECT COUNT(*) FROM enroll WHERE meeting_id = $meeting_id)
                                    AND DATE(m1.date) > DATE '" . $curr_date . "'";
    
        $valid_meeting_result = mysqli_query($myconnection, $valid_meeting_query) or die('Query failed: ' . mysqli_error());
        $valid_meeting = mysqli_fetch_array($valid_meeting_result, MYSQLI_ASSOC);
        if($valid_meeting['count'] == 0) {
            echo "Meeting not found, or you are unable to join.";
        }
        else {
            $insert_query = "INSERT INTO enroll VALUES($meeting_id, $student_id)";
            $insert_result = mysqli_query($myconnection, $insert_query) or die('Query failed: ' . mysqli_error());
            displayMembers($meeting_id, $myconnection);
        }
        mysqli_free_result($valid_meeting_result);
    } else {
        $find_meetings_query = "SELECT meeting_id
                                FROM meetings as m1
                                WHERE group_id IN (SELECT group_id FROM member_of WHERE student_id = $student_id)
                                    AND meeting_id NOT IN (SELECT meeting_id FROM enroll WHERE student_id = $student_id)
                                    AND capacity NOT IN (SELECT COUNT(*) FROM enroll WHERE meeting_id = m1.meeting_id)
                                    AND DATE(m1.date) > DATE '" . $curr_date . "'";
    
        $find_meetings_result = mysqli_query($myconnection, $find_meetings_query) or die('Query failed: ' . mysqli_error());
        
        while($find_meetings = mysqli_fetch_array($find_meetings_result, MYSQLI_ASSOC)) {
            $meeting_id = $find_meetings["meeting_id"];
            $insert_query = "INSERT INTO enroll VALUES($meeting_id, $student_id)";
            $insert_result = mysqli_query($myconnection, $insert_query) or die('Query failed: ' . mysqli_error());
            displayMembers($meeting_id, $myconnection);
            echo "<br><br><br>";
        }
        mysqli_free_result($find_meetings_result);
            
    }
    
    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>