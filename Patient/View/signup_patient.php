<?php
session_start();

// Check if user came from step 1
if(!isset($_SESSION["signup_user_id"]) || $_SESSION["signup_role"] != "patient"){
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
        <title>Patient Sign Up</title>
        <link rel="stylesheet" href="../public/css/signup_patient.css">
        <script src="../Controller/JS/checkMedicalId.js"></script>
    </head>

<body>
    <div class="container">
        <h2>Patient Registration</h2>
        <p>Welcome, <?php echo $_SESSION["signup_email"] ?? ''; ?></p>
        <form method="post" action="../Controller/SignUp_patientValidation.php">
            <table>
                <tr>
                    <td>Medical ID <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="text" id="medical_id" name="medical_id" value="<?php echo $previousValues['medical_id'] ?? '' ?>" onkeyup="checkMedicalId()" required/></td>
                </tr>
                <tr>
                    <td><div class="error" id="medicalIdError"></div></td>
                    <td><div class="error"><?php echo $errors["medical_id"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Date of Birth <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="date" name="dob" value="<?php echo $previousValues['dob'] ?? '' ?>" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["dob"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Address <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><textarea name="address" rows="3" required><?php echo $previousValues['address'] ?? '' ?></textarea></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["address"] ?? ''; ?></div></td>
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