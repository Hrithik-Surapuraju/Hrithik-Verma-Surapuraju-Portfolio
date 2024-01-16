<?php
    include "menu.php";
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $group_id = $_POST['group_id'];

    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

    $mydb = mysqli_select_db ($myconnection, 'db2') or die ('Could not select database');

    $group_exists_query = 'SELECT COUNT(*) as count FROM groups WHERE group_id  = ' . "'$group_id'";
    $group_exists_result = mysqli_query($myconnection, $group_exists_query) or die ('Query failed: ' . mysql_error());
    $group_exists = mysqli_fetch_array($group_exists_result, MYSQLI_ASSOC);
    if($group_exists['count'] == 0) {
        die("group '".$group_id."' not found.");
    }

    $already_member_query = 'SELECT COUNT(*) as count FROM member_of WHERE group_id = '."$group_id".' AND student_id = '."$user_id".'';
    $already_member_result = mysqli_query($myconnection, $already_member_query) or die ('Query failed: ' . mysql_error());
    $already_member = mysqli_fetch_array($already_member_result, MYSQLI_ASSOC);
    if($already_member["count"] > 0) {
        die("You are already a member of group "."'$group_id'");
    }

    $grade_req_query = 'SELECT grade_req FROM groups WHERE group_id = '."$group_id";
    $grade_req_result = mysqli_query($myconnection, $grade_req_query) or die ('Query failed: ' . mysql_error());
    $grade_req = mysqli_fetch_array($grade_req_result, MYSQLI_ASSOC);

    $grade_query = 'SELECT grade FROM students WHERE student_id = '."$user_id";
    $grade_result = mysqli_query($myconnection, $grade_query) or die ('Query failed: ' . mysql_error());
    $grade = mysqli_fetch_array($grade_result, MYSQLI_ASSOC)['grade'];

    $grade_req_upper = $grade_req['grade_req'] + 1;

    if($grade == $grade_req['grade_req'] || $grade == $grade_req_upper) {
        $insert = 'INSERT INTO member_of VALUES ('.$group_id.', '.$user_id.')';
        mysqli_query($myconnection, $insert) or die('Query failed: ' . mysql_error());
        echo("Joined group '$group_id'");
    }
    else echo("You do not meet the grade requirements for this group. Members must be in grades '".$grade_req['grade_req']."-".$grade_req_upper."'");

    create_menu($user_id, $user_type);

    mysqli_free_result($group_exists_result);
    mysqli_free_result($already_member_result);
    mysqli_free_result($grade_req_result);
    mysqli_free_result($grade_result);
    mysqli_close($myconnection);
?>