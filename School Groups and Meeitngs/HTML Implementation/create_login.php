<?php

include 'menu.php';
   
  $name = $_POST['name'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $type = $_POST['usertype'];
  $grade = $_POST['grade'];
 
  $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

  $mydb = mysqli_select_db ($myconnection, 'db2') or die ('Could not select database');

  $query = 'SELECT COUNT(*) as count FROM users WHERE email = ' . "'$email'";
  $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
  $count = mysqli_fetch_array($result, MYSQLI_ASSOC);

  if($count['count'] > 0) {
    die ('Users must have a unique email.' . $count['count']);
  }

  $Uid_query = 'SELECT COALESCE(MAX(id), 0) as count FROM users';
  $Uid_result = mysqli_query($myconnection, $Uid_query) or die('Query failed: ' . mysql_error());
  $Uid = mysqli_fetch_array($Uid_result, MYSQLI_ASSOC);
  $Uid['count'] += 1;

  $insert = 'INSERT INTO users VALUES ('.$Uid['count'].', "'.$email.'", "'.$password.'", "'.$name.'", '.$phone.')';
  mysqli_query($myconnection, $insert) or die('Query failed: ' . mysql_error());

  if($type === 'student') {
    $newStudent = 'INSERT INTO students VALUES ('.$Uid['count'].', '.$grade.')';
    mysqli_query($myconnection, $newStudent) or die('Query failed' . mysql_error());
  } elseif ($type === "parent") {
    $newParent = 'INSERT INTO parents VALUES('.$Uid['count'].')';
    mysqli_query($myconnection, $newParent) or die('Query failed' . mysql_error());
  }

  create_menu($Uid['count'], $type);

  mysqli_free_result($result);
  mysqli_free_result($Uid_result);

  mysqli_close($myconnection);

?>