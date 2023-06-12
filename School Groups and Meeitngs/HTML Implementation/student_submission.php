<?php
// Include the menu file to ensure the user is logged in
include 'menu.php';

// Retrieve the user ID and user type from the POST data
$userId = $_POST['user_id'];
$userType = $_POST['user_type'];

// Connect to the database
$myconnection = mysqli_connect('localhost', 'root', '') or die('Could not connect: ' . mysqli_error());
mysqli_select_db($myconnection, 'db2') or die('Could not select database');

// If the form has been submitted, process the submission
if (isset($_POST['assignment_id']) && isset($_POST['contents'])) {
    $assignmentId = $_POST['assignment_id'];
    $contents = $_POST['contents'];

    // Verify that the user is enrolled in the meeting associated with this assignment
    $enrollQuery = "SELECT * FROM member_of WHERE student_id = $userId AND group_id = (SELECT group_id FROM assignments WHERE assignment_id = $assignmentId) AND student_id NOT IN (SELECT student_id FROM submissions WHERE assignment_id = $assignmentId)";
    $enrollResult = mysqli_query($myconnection, $enrollQuery);

    if (mysqli_num_rows($enrollResult) > 0) {
        // Verify that the assignment ID exists in the assignments table
        $assignmentQuery = "SELECT * FROM assignments WHERE assignment_id = $assignmentId";
        $assignmentResult = mysqli_query($myconnection, $assignmentQuery);

        if (mysqli_num_rows($assignmentResult) > 0) {
            // Insert the submission into the submissions table with a default score of null
            $submissionQuery = "INSERT INTO submissions (assignment_id, student_id, contents, score) VALUES ($assignmentId, $userId, '$contents', null)";
            mysqli_query($myconnection, $submissionQuery);

            // Display a success message to the user
            echo "<p>Your submission has been saved.</p>";
        } else {
            // Display an error message if the assignment ID does not exist
            echo "<p>Invalid assignment ID.</p>";
        }
    } else {
        // Display an error message if the user is not enrolled in the meeting
        echo "<p>Unable to submit assignment: You are either not a member of the group, or you've already submitted it.</p>";
    }
}

// Get list of meetings that the student is enrolled in
$enrollQuery = "SELECT group_id FROM member_of WHERE student_id = $userId";
$enrollResult = mysqli_query($myconnection, $enrollQuery);

// Loop through each meeting
while ($enrollRow = mysqli_fetch_array($enrollResult)) {
    $groupId = $enrollRow['group_id'];

    // Get list of assignments for this meeting
    $assignmentQuery = "SELECT assignment_id, assignments.name, assignments.description FROM assignments WHERE group_id = $groupId";
    $assignmentResult = mysqli_query($myconnection, $assignmentQuery);

    // Display list of assignments
    if(mysqli_num_rows($assignmentResult) > 0) {
            echo "<h2>Assignments for Group $groupId:</h2>";
    }
    while ($assignmentRow = mysqli_fetch_array($assignmentResult)) {
        $assignmentId = $assignmentRow['assignment_id'];
        $name = $assignmentRow['name'];
        $description = $assignmentRow['description'];
        echo "<h3>$name</h3>";

        // Check if student has already submitted a response for this assignment
        $submissionQuery = "SELECT contents FROM submissions WHERE assignment_id = $assignmentId AND student_id = $userId";
        $submissionResult = mysqli_query($myconnection, $submissionQuery);
        $submissionRow = mysqli_fetch_array($submissionResult);

        // If student has not submitted a response, display form
        if (!$submissionRow) {
            echo "<form method='POST'>";
            echo "<input type='hidden' name='assignment_id' value='$assignmentId'>";
            echo "<input type='hidden' name='user_id' value='$userId'>";
            echo "<input type='hidden' name='user_type' value='$userType'>";
            echo "<p>$description</p>";
            echo "<label for='contents'>Enter your response:</label><br>";
            echo "<textarea name='contents'></textarea><br>";
            echo "<input type='submit' value='Submit'>";
            echo "</form>";
        }
        // If student has submitted a response, display the response
        else {
            $contents = $submissionRow['contents'];
            echo "<p>Your response for assignment $assignmentId: $contents</p>";
        }
    }
}
create_menu($userId, $userType);

// Close database connection
mysqli_close($myconnection);
?>
