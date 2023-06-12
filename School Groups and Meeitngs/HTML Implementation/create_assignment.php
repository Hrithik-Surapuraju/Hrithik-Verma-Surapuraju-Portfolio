<!-- 
    Admins can create assignments and assign scores to student submissions.
 -->
<?php
include 'menu.php';

// Verify that group exists
$group_id = $_POST['group_id'];
$myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysql_error());
$mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');
$group_query = 'SELECT COUNT(*) as count FROM groups WHERE group_id = ' . $group_id;
$group_result = mysqli_query($myconnection, $group_query) or die('Query failed: ' . mysql_error());
$group_count = mysqli_fetch_array($group_result, MYSQLI_ASSOC);

if ($group_count['count'] == 0) {
  die('Group does not exist.');
}

// Generate new assignment_id by finding the max current id and iterating it
$assignment_query = 'SELECT COALESCE(MAX(assignment_id), 0) as max_id FROM assignments';
$assignment_result = mysqli_query($myconnection, $assignment_query) or die('Query failed: ' . mysql_error());
$assignment_id = mysqli_fetch_array($assignment_result, MYSQLI_ASSOC)['max_id'] + 1;

// Assume name and description are input
$name = $_POST['name'];
$description = $_POST['description'];

// Insert new assignment into database
$insert_query = 'INSERT INTO assignments VALUES (' . $group_id . ', ' . $assignment_id . ', "' . $name . '", "' . $description . '")';
mysqli_query($myconnection, $insert_query) or die('Query failed: ' . mysql_error());

create_menu($group_id, 'admin');

mysqli_free_result($group_result);
mysqli_free_result($assignment_result);
//mysqli_free_result($submission_result);
mysqli_close($myconnection);
?>
