<?php
session_start();

if(!isset($_SESSION["isLoggedIn"])||$_SESSION["isLoggedIn"] !== true || $_SESSION["role"]!="doctor"){
    header("Location: ../../Commons/View/login.php");
    exit();

} 
if(!isset($_SESSION["profile_data"])){
    header("Location: ../Controller/profile_viewer.php");
    exit();

}
//getting data
$doctor=$_SESSION["profile_data"];
$errors =$_SESSION["errors"] ?? [];
$previousValues =$_SESSION["previousValues"] ?? [];

$phone =$previousValues["phone"] ?? $doctor["phone"] ?? "";
$chamber =$previousValues["chamber"] ?? $doctor["chamber"] ??"";

$available_days = $previousValues["available_days"] ?? $doctor["available_days"] ?? "";
$start_time = $previousValues["start_time"] ?? $doctor["start_time"] ?? "";
$end_time = $previousValues["end_time"] ?? $doctor["end_time"] ?? "";
?>


<html>
    <head>
        <link rel="stylesheet" href="../public/css/edit_profile.css">
        <script src="../Controller/js/edit_profile_validation.js"></script>
    </head>
    <body>
        <div class="container">
            <h2>Edit Profile</h2>

            <form method="post" action="../Controller/UpdateProfileValidation.php" id="editProfileForm" onsubmit="return validateForm()">
                <table>
                    <tr>
                        <td class="label">Name:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($doctor["name"] ?? ''); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="label">License:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($doctor["license_no"] ?? ''); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="label">Specialization:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($doctor["specialization"] ?? ''); ?></strong></td>
                    </tr>
                    
                    <tr>
                        <td class="label">Gender:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($doctor["gender"] ?? ''); ?></strong></td>
                    </tr>
                    
                    <tr>
                        <td class="label">Email:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($doctor["email"] ?? ''); ?></strong></td>
                    </tr>



                    <tr>
                        <td>Phone: <span class="required">*</span></td>
                        <td><input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>"></td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td><div class="error" id="phoneErr"><?php echo $errors["phone"] ?? ""; ?></div></td>
                    </tr>

                    <tr>
                        <td>Chamber: <span class="required">*</span></td>
                        <td><textarea id="chamber" name="chamber" rows="3" ><?php echo htmlspecialchars($chamber); ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div class="error" id="chamberErr"><?php echo $errors["chamber"] ?? ""; ?></div></td>
                    </tr>

                    <tr colspan="2">Edit Appointment Schedule</tr>
                    <tr>
                        <td>Available Days: </td>
                        <td><input type="text" name="avDays" value="<?php echo htmlspecialchars($available_days); ?>" autocomplete="off"></td>
                    </tr>

                    <tr>
                        <td>Start Time </td>
                        <td><input type="text" name="strTime" value="<?php echo htmlspecialchars($start_time);?>"></td>
                    </tr>
                    <tr>
                        <td>End Time: </td>
                        <td><input type="text" name="endTime" value="<?php echo htmlspecialchars($end_time);?>"></td>
                    </tr>

                    <tr>
                        <td colspan="2"><h3>Change Password</h3></td>

                    </tr>

                    <tr>
                        <td>Current Password:</td>
                        <td><input type="password" id= "current_password" name="current_password" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div class="error" id="currentPassErr"><?php echo $errors["current_password"] ?? ""; ?></div></td>
                    </tr>
                    <tr>
                        <td>New Password:</td>
                        <td><input type="password" id="new_password" name="new_password" autocomplete="off"/></td>
                    </tr>
                    <tr>
                    <td></td>
                    <td><div class="error" id="newPassErr"></div></td>
                    </tr>

                    <tr>
                        <td>Confirm New Password:</td>
                        <td><input type="password" id="confirm_password" name="confirm_password" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div class="error" id="confirmPassErr"></div></td>
                    </tr>
                    <tr>
                    <td>
                        <input type="submit" name="update" value="Save Changes" class="submitbtn"/>
                    </td>
                    <td>
                        <a href="profile.php" class="cancelbtn">Cancel</a>
                    </td>
                </tr>
                </table>
            </form>

        </div>
    </body>
</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['previousValues']);
unset($_SESSION["updateError"]);
?>