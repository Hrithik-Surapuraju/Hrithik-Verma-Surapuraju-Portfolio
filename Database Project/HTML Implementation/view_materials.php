<?php

include 'menu.php';

$userId = $_POST['user_id'];
$userType = $_POST['user_type'];

// Connect to the database
$myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
$mydb = mysqli_select_db($myconnection, 'db2') or die('Could not select database');

// Query meetings table to get meeting details for the given year
$meetings_query = "SELECT material_id, meeting_id, title, author, type, url, assigned_date, notes FROM material WHERE meeting_id IN (SELECT meeting_id FROM enroll WHERE student_id = $userId)";
$meetings_result = mysqli_query($myconnection, $meetings_query) or die('Query failed: ' . mysqli_error());


echo "<table>";
// Print table headers
echo '<tr bgcolor="#bbbbbb">
<th>Material ID</th>
<th>Title</th>
<th>Author</th>
<th>Type</th>
<th>URL</th>
<th>Assigned Date</th>
<th>Notes</th>
</tr>';

// Loop through meetings query results and print table rows
while ($meeting_row = mysqli_fetch_array($meetings_result, MYSQLI_ASSOC)) {
  echo '<tr bgcolor="#dddddd">
          <td>'.$meeting_row["material_id"].'</td>
          <td>'.$meeting_row["title"].'</td>
          <td>'.$meeting_row["author"].'</td>
          <td>'.$meeting_row["type"].'</td>
          <td>'.$meeting_row["url"].'</td>
          <td>'.$meeting_row["assigned_date"].'</td>
	  <td>'.$meeting_row["notes"].'</td>
        </tr>';
}
echo "</table>";

create_menu($userId, $userType);

mysqli_close($myconnection);

?>