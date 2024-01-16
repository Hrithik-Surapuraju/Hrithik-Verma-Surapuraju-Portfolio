<?php
function displayMembers($meeting_id, $myconnection) {
    // Query to get the meeting details
    $meeting_query = "SELECT meeting_id, meeting_name, time_slot_id, capacity, group_id, announcement, date FROM meetings WHERE meeting_id = $meeting_id";
    $meeting_result = mysqli_query($myconnection, $meeting_query) or die('Query failed: ' . mysqli_error());

    // Fetch the meeting details
    $meeting_row = mysqli_fetch_array($meeting_result, MYSQLI_ASSOC);

    // Query to get the list of students joining the meeting
    $enroll_query = "SELECT users.name, users.email FROM enroll JOIN users ON enroll.student_id = users.id WHERE enroll.meeting_id = $meeting_id";
    $enroll_result = mysqli_query($myconnection, $enroll_query) or die('Query failed: ' . mysqli_error());

    $time_query = "SELECT day_of_the_week, start_time, end_time FROM time_slot WHERE time_slot_id = " . $meeting_row["time_slot_id"];
    $time_result = mysqli_query($myconnection, $time_query) or die('Query failed: ' . mysqli_error());
    $time_row = mysqli_fetch_array($time_result, MYSQLI_ASSOC);


    // Print the meeting details
    echo "<h2>" . $meeting_row["meeting_name"] . "</h2>";
    echo "<p><b>Time:</b> " . $time_row["day_of_the_week"] . ", " . $meeting_row["date"] . " from " . $time_row["start_time"] . "-" . $time_row["end_time"] . "</p>";
    echo "<p><b>Capacity:</b> " . $meeting_row["capacity"] . "</p>";
    echo "<p><b>Announcement:</b> " . $meeting_row["announcement"] . "</p>";

    // Print the list of students joining the meeting
    echo "<h3>Students joining this meeting:</h3>";
    echo "<table>";
    echo '<tr bgcolor="#bbbbbb">
    <th>Name</th>
    <th>Email</th>
    </tr>';
    while ($enroll_row = mysqli_fetch_array($enroll_result, MYSQLI_ASSOC)) {
    echo '<tr bgcolor="#dddddd">
            <td>'.$enroll_row["name"].'</td>
            <td>'.$enroll_row["email"].'</td>
            </tr>';
    }
    echo "</table>";

    mysqli_free_result($meeting_result);
    mysqli_free_result($enroll_result);
}
?>