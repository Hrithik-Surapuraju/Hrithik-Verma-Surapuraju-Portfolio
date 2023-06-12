<?php
    include 'menu.php';

    // Get the meeting ID from the URL parameter
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    date_default_timezone_set('America/New_York');

    $day_of_week = date("l");

    if($day_of_week != "Friday") {
        die("You may only cancel meetings on Friday");
    }

    $friday = date("Y-m-d");
    $sunday = date("Y-m-d", time() + 86400 * 2);

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

    
    $get_meetings_query =  "SELECT meeting_id, meeting_name as name, meetings.date as date
                            FROM meetings
                            WHERE DATE(meetings.date) BETWEEN DATE '".$friday."' AND DATE'".$sunday."'
                            AND meeting_id IN (
                                SELECT meeting_id 
                                FROM enroll
                                GROUP BY meeting_id
                                HAVING count(*) < 3)";

    $get_meetings_result = mysqli_query($myconnection, $get_meetings_query) or die('Query failed: ' . mysqli_error());
    while ($meetings = mysqli_fetch_array($get_meetings_result, MYSQLI_ASSOC)) {
        $meeting = $meetings['meeting_id'];
        $notif_file = fopen("notifications/meeting_$meeting"."_notif.txt", "w") or die("Unable to open file.");

        fwrite($notif_file, "Your meeting '".$meetings["name"]."' on ".$meetings["date"]." has been cancelled.\n\n");

        $enroll_query = "SELECT users.name, users.email FROM enroll JOIN users ON enroll.student_id = users.id WHERE enroll.meeting_id = $meeting";
        $enroll_result = mysqli_query($myconnection, $enroll_query) or die('Query failed: ' . mysqli_error());

        while ($enroll_row = mysqli_fetch_array($enroll_result, MYSQLI_ASSOC)) {
            fwrite($notif_file, $enroll_row["name"].", ".$enroll_row["email"]."\n");
        }

        mysqli_free_result($enroll_result);

        fclose($notif_file);
    }
    mysqli_free_result($get_meetings_result);
    
    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>