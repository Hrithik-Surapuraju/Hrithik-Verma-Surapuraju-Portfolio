<?php
    include "menu.php";
    $user_id = $_POST["user_id"];
    $user_type = $_POST["user_type"];
    $material = $_POST["material"];
    $meeting = $_POST["new_meeting"];
    $name = $_POST["new_name"];
    $author = $_POST["new_author"];
    $type = $_POST["new_type"];
    $url = $_POST["new_url"];
    $notes = $_POST["new_notes"];
    $date = $_POST["new_date"];

    // Connect to the database
    $myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');
    $valid_mat_query = "SELECT COUNT(*) as count FROM material WHERE material_id = $material";
    $valid_mat_result = mysqli_query($myconnection, $valid_mat_query) or die('Query failed: ' . mysqli_error());
    $valid_mat = mysqli_fetch_array($valid_mat_result, MYSQLI_ASSOC);

    if($valid_mat["count"] == 0) {
        echo "Could not find material $material";
    } else {
        if($meeting != "") {
            $valid_meet_query = "SELECT COUNT(*) as count FROM meetings WHERE meeting_id = $meeting";
            $valid_meet_result = mysqli_query($myconnection, $valid_meet_query) or die('Query failed: ' . mysqli_error());
            $valid_meet = mysqli_fetch_array($valid_meet_result, MYSQLI_ASSOC);

            if($valid_meet["count"] == 0) {
                echo "Could not find meeting $meeting";
            } else {
                $update_query = "UPDATE material SET meeting_id = $meeting WHERE material_id = $material";
                mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
            }
            mysqli_free_result($valid_meet_result);

        }
        if($name != "") {
            $update_query = "UPDATE material SET material.title = '".$name."' WHERE material_id = $material";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
        if($author != "") {
            $update_query = "UPDATE material SET author = '".$author."' WHERE material_id = $material";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
        if($type != "") {
            $update_query = "UPDATE material SET material.type = '".$type."' WHERE material_id = $material";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
        if($url != "") {
            $update_query = "UPDATE material SET material.url = '".$url."' WHERE material_id = $material";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
        if($notes != "") {
            $update_query = "UPDATE material SET notes = '".$notes."' WHERE material_id = $material";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
        if($date != "") {
            $update_query = "UPDATE material SET assigned_date = DATE '".$date."' WHERE material_id = $material";
            mysqli_query($myconnection, $update_query) or die('Query failed: ' . mysqli_error());
        }
    }

    mysqli_free_result($valid_mat_result);

    create_menu($user_id, $user_type);

    mysqli_close($myconnection);
?>