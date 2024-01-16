<?php

include 'menu.php';

$userId = $_POST['user_id'];
$userType = $_POST['user_type'];

// Connect to the database
$myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
$mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

// Query meetings table to get meeting details for the given year
$submissions_query = "SELECT assignment_id, student_id, contents, score FROM submissions";
$submissions_result = mysqli_query($myconnection, $submissions_query) or die('Query failed: ' . mysqli_error());

// Query groups table to get group details for the given year
$meetings_query = "SELECT group_id, assignment_id, name, description FROM assignments";
$meetings_result = mysqli_query($myconnection, $meetings_query) or die('Query failed: ' . mysqli_error());

echo "<table>";
// Print table headers
echo '<tr bgcolor="#bbbbbb">
<th>Assignment ID</th>
<th>Student ID</th>
<th>Contents</th>
<th>Score</th>
</tr>';

// Loop through meetings query results and print table rows
while ($submissions_row = mysqli_fetch_array($submissions_result, MYSQLI_ASSOC)) {
  echo '<tr bgcolor="#dddddd">
          <td>'.$submissions_row["assignment_id"].'</td>
          <td>'.$submissions_row["student_id"].'</td>
          <td>'.$submissions_row["contents"].'</td>
          <td>'.$submissions_row["score"].'</td>
        </tr>';
}
echo "</table>";

echo "<table>";
// Print table headers
echo '<tr bgcolor="#bbbbbb">
<th>Group ID</th>
<th>Assignment ID</th>
<th>Name</th>
<th>Description</th>
</tr>';

// Loop through meetings query results and print table rows
while ($meeting_row = mysqli_fetch_array($meetings_result, MYSQLI_ASSOC)) {
  echo '<tr bgcolor="#dddddd">
          <td>'.$meeting_row["group_id"].'</td>
          <td>'.$meeting_row["assignment_id"].'</td>
          <td>'.$meeting_row["name"].'</td>
          <td>'.$meeting_row["description"].'</td>
        </tr>';
}
echo "</table>";

create_menu($userId, $userType);

mysqli_close($myconnection);

?>