<?php
    include "menu.php";

    $user_type = $_POST['user_type'];
    $user_id = $_POST['user_id'];
    $id = $user_id;
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_phone = $_POST['new_phone'];
    $new_password = $_POST['new_password'];

    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

    $mydb = mysqli_select_db ($myconnection, 'db2') or die ('Could not select database');

    // if the user is a parent, use the id of the
    if($user_type === 'parent') {
        if($_POST['student'] != NULL) {
            $student = $_POST['student'];

            $sid_query = 'SELECT id FROM users WHERE email = ' . "'$student'";
            $sid_result = mysqli_query($myconnection, $sid_query) or die ('Query failed: ' . mysql_error());
            $id_r = mysqli_fetch_array($sid_result, MYSQLI_ASSOC);
            if($id_r == NULL) {
                die("User '".$student."' not found.");
            }

            $ischildof_query = 'SELECT COUNT(*) as count FROM child_of WHERE student_id = "'.$id_r['id'].'" AND parent_id = "'.$user_id.'"';
            $ischildof_result = mysqli_query($myconnection, $ischildof_query) or die ('Query failed: ' . mysql_error());
            $ischildof = mysqli_fetch_array($ischildof_result, MYSQLI_ASSOC);
            if($ischildof['count'] == 0) {
                die("User '".$student."' is not your child.");
            }

            $id = $id_r['id'];
            mysqli_free_result($sid_result);
            mysqli_free_result($ischildof_result);
        }
    }

    $num_vals = 0;

    // Updating the values
    if($new_email !== '') {
        $check_taken = "SELECT COUNT(*) as count FROM users WHERE email='".$new_email."'";
        $taken_result = mysqli_query($myconnection, $check_taken) or die('Query failed' . mysql_error());
        $isTaken = mysqli_fetch_array($taken_result, MYSQLI_ASSOC);
        if($isTaken['count'] > 0) {
            die('New Email is already associated with another user.');
        }

        $email_query = "UPDATE users SET email='".$new_email."' WHERE id='".$id."'";
        mysqli_query($myconnection, $email_query) or die('Query failed' . mysql_error());
        mysqli_free_result($taken_result);
        $num_vals += 1;
    }
    if($new_name !== '') {
        $name_query = "UPDATE users SET name='".$new_name."' WHERE id='".$id."'";
        mysqli_query($myconnection, $name_query) or die('Query failed' . mysql_error());
        $num_vals += 1;
    }
    if($new_phone !== '') {
        $phone_query = "UPDATE users SET phone='".$new_phone."' WHERE id='".$id."'";
        mysqli_query($myconnection, $phone_query) or die('Query failed' . mysql_error());
        $num_vals += 1;
    }
    if($new_password !== '') {
        $password_query = "UPDATE users SET password='".$new_password."' WHERE id='".$id."'";
        mysqli_query($myconnection, $password_query) or die('Query failed' . mysql_error());
        $num_vals += 1;
    }

    echo "Successfully Updated User Info.";
    if($num_vals === 1) {
        echo " 1 value changed.";
    }
    else echo " $num_vals values have changed.";
    create_menu($user_id, $user_type);
    
    mysqli_close($myconnection);

?>