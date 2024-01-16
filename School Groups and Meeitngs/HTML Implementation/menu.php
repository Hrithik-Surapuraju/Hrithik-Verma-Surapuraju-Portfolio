<?php
// Function for generating the html elements found in the main menu, 
// changing the displayed elements based on the type of user that is signed in.
function create_menu($id, $usertype) {
    echo "<a href='start_page.html'>Log out</a>";
    echo "<h1>User Menu</h1>";
    if($usertype === "student") {
        echo '<form action="update_account.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Update Account</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Empty values will be left unchanged.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>New Name:</td>
            <td align="left"><input type="text" name="new_name" size="30" maxlength="30"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Email:</td>
            <td align="left"><input type="text" name="new_email" size="30" maxlength="100"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Phone:</td>
            <td align="left"><input type="number" name="new_phone" size="30" maxlength="10"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Password:</td>
            <td align="left"><input type="password" name="new_password" size="30" maxlength="20"/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Update Account"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="view_groups_meetings.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <td colspan="2" align="center"><input type="submit" value="View Groups and Meetings"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="view_materials.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <td colspan="2" align="center"><input type="submit" value="View Materials"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="join_meeting.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Join Meeting</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Leave meeting id empty to</p></td>
        </tr>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>join all valid future meetings.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10"/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Join a Meeting"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="join_group.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Join Group</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Group ID:</td>
            <td align="left"><input type="number" name="group_id" size="30" maxlength="10" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Join a Group"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="leave_meeting.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Leave Meeting</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Leave meeting id empty to</p></td>
        </tr>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>leave all valid future meetings.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10"/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Leave a Meeting or All Meetings"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="student_submission.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Submit Assignment</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Assignment ID:</td>
            <td align="left"><input type="number" name="assignment_id" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Contents:</td>
            <td align="left"><input type="textarea" name="contents" size="30" maxlength="200" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Submit Assignment"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="view_meeting_members.php" method="get">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>View Members</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="View Meeting Members"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="view_materials.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <td colspan="2" align="center"><input type="submit" value="View Materials"/></td>
        </tr>
        </table>
        </form>';
    }
    elseif($usertype === "parent") {
        echo '<form action="update_account.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Update Account</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Empty values will be left unchanged.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Student email(optional*):</td>
            <td align="left"><input type="text" name="student" size="30" maxlength="100"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Name:</td>
            <td align="left"><input type="text" name="new_name" size="30" maxlength="30"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Email:</td>
            <td align="left"><input type="text" name="new_email" size="30" maxlength="100"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Phone:</td>
            <td align="left"><input type="number" name="new_phone" size="30" maxlength="10"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Password:</td>
            <td align="left"><input type="password" name="new_password" size="30" maxlength="20"/></td>
        </tr>
        <td align="left"><p>*Enter your child\'s email if editing their account,</p></td>
        <tr></tr>
        <td align="left"><p>Leave empty to edit your own account</p></td>
        <td colspan="2" align="center"><input type="submit" value="Update Account"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="join_meeting.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Enroll Student</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Leave meeting id empty to</p></td>
        </tr>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>join all valid future meetings.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Student email:</td>
            <td align="left"><input type="text" name="student" size="30" maxlength="100" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Enroll Student"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="leave_meeting.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Leave Meeting</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Leave meeting id empty to</p></td>
        </tr>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>leave all valid future meetings.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Student email:</td>
            <td align="left"><input type="text" name="student" size="30" maxlength="100" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Leave a Meeting or All Meetings"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="view_groups_meetings.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <td colspan="2" align="center"><input type="submit" value="View Groups and Meetings"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="claim_child.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Claim Child</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Student email:</td>
            <td align="left"><input type="text" name="student" size="30" maxlength="100" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Claim Child Account"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";
    }
    elseif($usertype === "admin") {
        echo '<form action="join_meeting.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Enroll Student</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Leave meeting id empty to</p></td>
        </tr>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>join all valid future meetings.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Student email:</td>
            <td align="left"><input type="text" name="student" size="30" maxlength="100" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Enroll Student"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="mod_meetings.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Modify Meeting</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Name:</td>
            <td align="left"><input type="text" name="new_name" size="30" maxlength="200"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Announcement:</td>
            <td align="left"><input type="textarea" name="new_announcement" size="30" maxlength="200"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Date:</td>
            <td align="left"><input type="date" name="new_date"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Start Time:</td>
            <td align="left"><input type="time" name="new_start"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New End Time:</td>
            <td align="left"><input type="time" name="new_end"/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Modify Meeting Details"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="mod_materials.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Modify Material</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Material ID:</td>
            <td align="left"><input type="number" name="material" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Meeting ID:</td>
            <td align="left"><input type="number" name="new_meeting" size="30" maxlength="10"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Title:</td>
            <td align="left"><input type="text" name="new_name" size="30" maxlength="200"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Author:</td>
            <td align="left"><input type="text" name="new_author" size="30" maxlength="200"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Type:</td>
            <td align="left"><input type="text" name="new_type" size="30" maxlength="200"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New URL:</td>
            <td align="left"><input type="text" name="new_url" size="30" maxlength="200"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Notes:</td>
            <td align="left"><input type="textarea" name="new_notes" size="30" maxlength="200"/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>New Date:</td>
            <td align="left"><input type="date" name="new_date"/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Modify Material Details"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="post_materials.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Post Material</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Meeting ID:</td>
            <td align="left"><input type="number" name="meeting_id" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Title:</td>
            <td align="left"><input type="text" name="name" size="30" maxlength="200" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Author:</td>
            <td align="left"><input type="text" name="author" size="30" maxlength="200" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Type:</td>
            <td align="left"><input type="text" name="type" size="30" maxlength="200" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>URL:</td>
            <td align="left"><input type="text" name="url" size="30" maxlength="200" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Notes:</td>
            <td align="left"><input type="textarea" name="notes" size="30" maxlength="200" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Post Material"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="create_meeting.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Create Meeting</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Group ID:</td>
            <td align="left"><input type="number" name="group" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Name:</td>
            <td align="left"><input type="text" name="name" size="30" maxlength="200" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Date:</td>
            <td align="left"><input type="date" name="date" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Start Time:</td>
            <td align="left"><input type="time" name="start" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>End Time:</td>
            <td align="left"><input type="time" name="end" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Announcement:</td>
            <td align="left"><input type="text" name="announcement" size="30" maxlength="200" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Create Meeting"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="cancel_meetings.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Cancel Meetings</h2></td>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>Generates cancelation emails</p></td>
        </tr>
        <tr bgcolor="#aaaaff">
            <td align="left"><p>for meetings with too few members.</p></td>
        </tr>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <td colspan="2" align="center"><input type="submit" value="Cancel Meetings"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="view_groups_meetings.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <td colspan="2" align="center"><input type="submit" value="View Groups and Meetings"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="view_assignments_and_submissions.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <td colspan="2" align="center"><input type="submit" value="View Assignments and Submissions"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="create_assignment.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Create Assignment</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Group ID:</td>
            <td align="left"><input type="number" name="group_id" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Name:</td>
            <td align="left"><input type="text" name="name" size="30" maxlength="200" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Description:</td>
            <td align="left"><input type="text" name="description" size="30" maxlength="200" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Create Assignment"/></td>
        </tr>
        </table>
        </form>';

        echo "<br><br><br>";

        echo '<form action="submit_score.php" method="post">
        <table border="0">     
        <tr bgcolor="#cccccc">
        <td align="center"><h2>Submit Score</h2></td>
        <input type="number" name="user_id" value ="'.$id.'" hidden></input>
        <input type="text" name="user_type" value ="'.$usertype.'" hidden></input>
        <tr bgcolor="#cccccc">
            <td>Assignment ID:</td>
            <td align="left"><input type="number" name="assignment_id" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Student ID:</td>
            <td align="left"><input type="number" name="student_id" size="30" maxlength="10" required/></td>
        </tr>
        <tr bgcolor="#cccccc">
            <td>Score:</td>
            <td align="left"><input type="number" name="score" size="30" maxlength="10" min="0" max="100" required/></td>
        </tr>
        <td colspan="2" align="center"><input type="submit" value="Submit Score"/></td>
        </tr>
        </table>
        </form>';
    }
}
?>