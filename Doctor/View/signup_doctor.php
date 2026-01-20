<?php
session_start();

if(!isset($_SESSION["signup_user_id"]) || $_SESSION["signup_role"] != "doctor"){
    Header("Location: ../../Commons/View/signup.php");
    exit();
}

$previousValues = $_SESSION["previousValues"] ?? [];
$errors = $_SESSION["errors"] ?? [];
$signupErr = $_SESSION["signupErr"] ?? "";



unset($_SESSION['errors']);
unset($_SESSION['previousValues']);
unset($_SESSION["signupErr"]);
?>



<html>
    <head>
        <title>Doctor Sign Up - Step 2</title>
        <link rel="stylesheet" href="../public/css/signup_doctor.css">
        <script src="../Controller/JS/checkLicenseNo.js"></script>
    </head>

<body>
    <div class="container">
        <h2>Doctor Registration - Step 2</h2>
        <p>Welcome, Dr. <?php echo $_SESSION["signup_email"] ?? ''; ?></p>
        <form method="post" action="../Controller/SignUp_doctorValidation.php">
            <table>
            <tr>
                <td>Specialization <span class= "required">*</span></td>
            </tr>
                <tr>
                    <td><input type="text" name ="specialization" value="<?php echo $previousValues['specialization'] ?? '' ?>" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["specialization"] ??''; ?></div></td>
                </tr>

                <tr>
                    <td>License Number <span class = "required">*</span></td>
                </tr>
                <tr>
                    <td><input type = "text" id = "license_no" name = "license_no" value = "<?php echo $previousValues['license_no'] ?? ''?>" onkeyup="checkLicenseNo()" required/></td>
                </tr>
                <tr>
                    <td><div class="error" id="licenseNoError"></div></td>
                    <td><div class="error"><?php echo $errors["license_no"] ?? ''; ?></div> </td>
                </tr>

                <tr>
                    <td>Chamber Address <span class="required">*</span> </td>
                </tr>
                <tr>
                    <td><textarea name = "chamber" rows= "3" required> <?php echo $previousValues['chamber'] ?? '' ?></textarea></td>
                </tr>
                <tr>
                <td><div class="error"><?php echo $errors["chamber"] ?? ''; ?></div> </td>
                </tr>

                <tr>
                    <td colspan="2">Appointment Schedule (Optional)</td>
                </tr>

                <tr>
                    <td>Available Days</td>
                    <td>
                        <div class="checkbox">
                            <label><input type="checkbox" name="avDays[]" value="Sat">Saturday</label>
                            <label><input type="checkbox" name="avDays[]" value="Sun">Sunday</label>
                            <label><input type="checkbox" name="avDays[]" value="Mon">Monday</label>
                            <label><input type="checkbox" name="avDays[]" value="Tue">Tuesday</label>
                            <label><input type="checkbox" name="avDays[]" value="Wed">Wednesday</label>
                            <label><input type="checkbox" name="avDays[]" value="Thu">Thursday</label>
                            <label><input type="checkbox" name="avDays[]" value="Fri">Friday</label>
                            
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Start Time</td>
                    <td><input type="text" name="strTime"></td>
                </tr>
                <tr>
                    <td>End Time</td>
                    <td><input type="text" name="endTime"></td>
                </tr>




                <tr>
                    <td><div class="error"><?php echo $signupErr; ?></div></td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="Complete Registration" class="submit-btn"/>
                    </td>
                </tr>
            </table>
        </form>

    </div>
</body>

</html>