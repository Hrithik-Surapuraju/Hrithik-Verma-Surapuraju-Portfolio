<?php

include 'menu.php';

$userId = $_POST['user_id'];
$userType = $_POST['user_type'];

// Connect to the database
$myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
$mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

// Query meetings table to get meeting details for the given year
$meetings_query = "SELECT meeting_id, meeting_name, time_slot_id, capacity, group_id, announcement FROM meetings";
$meetings_result = mysqli_query($myconnection, $meetings_query) or die('Query failed: ' . mysqli_error());

// Query groups table to get group details for the given year
$groups_query = "SELECT group_id, name, description, grade_req FROM groups";
$groups_result = mysqli_query($myconnection, $groups_query) or die('Query failed: ' . mysqli_error());

echo "<table>";
// Print table headers
echo '<tr bgcolor="#bbbbbb">
<th>Meeting ID</th>
<th>Name</th>
<th>Time</th>
<th>Capacity</th>
<th>Group ID</th>
<th>Announcement</th>
</tr>';

// Loop through meetings query results and print table rows
while ($meeting_row = mysqli_fetch_array($meetings_result, MYSQLI_ASSOC)) {
  echo '<tr bgcolor="#dddddd">
          <td>'.$meeting_row["meeting_id"].'</td>
          <td>'.$meeting_row["meeting_name"].'</td>
          <td>'.$meeting_row["time_slot_id"].'</td>
          <td>'.$meeting_row["capacity"].'</td>
          <td>'.$meeting_row["group_id"].'</td>
          <td>'.$meeting_row["announcement"].'</td>
        </tr>';
}
echo "</table>";

echo "<table>";
// Print table headers
echo '<tr bgcolor="#bbbbbb">
        <th>Group ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Grade Requirement</th>
      </tr>';

// Loop through groups query results and print table rows
while ($group_row = mysqli_fetch_array($groups_result, MYSQLI_ASSOC)) {
  echo '<tr bgcolor="#dddddd">
          <td>'.$group_row["group_id"].'</td>
          <td>'.$group_row["name"].'</td>
          <td>'.$group_row["description"].'</td>
          <td>'.$group_row["grade_req"].'</td>
        </tr>';
}
echo "</table>";

create_menu($userId, $userType);

mysqli_close($myconnection);

?>
