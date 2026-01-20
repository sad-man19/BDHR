<?php
session_start();

if(!isset($_SESSION["isLoggedIn"])||$_SESSION["isLoggedIn"] !== true || $_SESSION["role"]!="patient"){
    header("Location: ../../Commons/View/login.php");
    exit();

} 
if(!isset($_SESSION["profile_data"])){
    header("Location: ../Controller/profile_viewer.php");
    exit();

}
//getting data
$patient=$_SESSION["profile_data"];
$errors =$_SESSION["errors"] ?? [];
$previousValues =$_SESSION["previousValues"] ?? [];

$phone =$previousValues["phone"] ?? $patient["phone"] ?? "";
$address =$previousValues["address"] ?? $patient["address"] ??"";

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
                        <td class="label">Medical ID:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($patient["medical_id"] ?? ''); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="label">Name:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($patient["name"] ?? ''); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="label">Gender:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($patient["gender"] ?? ''); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="label">Date of Birth:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($patient["dob"] ?? ''); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="label">Email:</td>
                        <td class="value"><strong><?php echo htmlspecialchars($patient["email"] ?? ''); ?></strong></td>
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
                        <td>Address: <span class="required">*</span></td>
                        <td><textarea id="address" name="address" rows="3" ><?php echo htmlspecialchars($address); ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div class="error" id="addressErr"><?php echo $errors["address"] ?? ""; ?></div></td>
                    </tr>

                    <tr>
                        <td colspan="2"><h3>Change Password</h3></td>

                    </tr>

                    <tr>
                        <td>Current Password:</td>
                        <td><input type="password" id= "current_password" name="current_password" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div class="error" id="currentPassErr"><?php echo $errors["current_password"] ?? ""; ?></div></td>
                    </tr>
                    <tr>
                        <td>New Password:</td>
                        <td><input type="password" id="new_password" name="new_password"/></td>
                    </tr>
                    <tr>
                    <td></td>
                    <td><div class="error" id="newPassErr"></div></td>
                    </tr>

                    <tr>
                        <td>Confirm New Password:</td>
                        <td><input type="password" id="confirm_password" name="confirm_password"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><div class="error" id="confirmPassErr"></div></td>
                    </tr>
                    <tr>
                    <td>
                        <input type="submit" name="update" value="Save Changes" class="submit-btn"/>
                    </td>
                    <td>
                        <a href="profile.php" class="cancel-btn">Cancel</a>
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