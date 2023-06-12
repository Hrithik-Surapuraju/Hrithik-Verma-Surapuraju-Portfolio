<?php
  include "menu.php";
  $password = $_POST['password'];
  $email = $_POST['email'];

  $myconnection = mysqli_connect('localhost', 'root', '') 
  or die ('Could not connect: ' . mysql_error());

  $mydb = mysqli_select_db ($myconnection, 'db2') or die ('Could not select database');

  $query = 'SELECT id FROM users WHERE email = "'.$email.'" AND password = "'.$password.'"';
  $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
  $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

  if($user === NULL) {
    die('Invalid credentials');
  }

  $is_student = 'SELECT COUNT(*) as count FROM students WHERE student_id='.$user['id'].'';
  $is_student_result = mysqli_query($myconnection, $is_student) or die ('Query failed: ' . mysql_error());
  $student = mysqli_fetch_array($is_student_result, MYSQLI_ASSOC);
  
  $is_parent = 'SELECT COUNT(*) as count FROM parents WHERE parent_id='.$user['id'].'';
  $is_parent_result = mysqli_query($myconnection, $is_parent) or die ('Query failed: ' . mysql_error());
  $parent = mysqli_fetch_array($is_parent_result, MYSQLI_ASSOC);

  $is_admin = 'SELECT COUNT(*) as count FROM admins WHERE admin_id='.$user['id'].'';
  $is_admin_result = mysqli_query($myconnection, $is_admin) or die ('Query failed: ' . mysql_error());
  $admin = mysqli_fetch_array($is_admin_result, MYSQLI_ASSOC);

  $usertype = "";

  if($user['id'] === false) {
    die('Invalid user info.');
  }
  else {
    if($admin['count'] > 0) {
        $usertype = "admin";
    }
    elseif($student['count'] > 0) {
        $usertype = "student";
    }
    elseif($parent['count'] > 0) {
        $usertype = "parent";
    }

    create_menu($user['id'], $usertype);

    mysqli_close($myconnection);
  }
?>