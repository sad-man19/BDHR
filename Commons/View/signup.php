<?php
session_start();
$isLoggedIn = false;

$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;

if($isLoggedIn){
    Header("Location: ../dashboard.php");
}

$previousValues = $_SESSION["previousValues"] ?? [];
$signupErr = $_SESSION["signupErr"] ?? "";
$errors = $_SESSION["errors"] ?? [];

unset($_SESSION['errors']);
unset($_SESSION['previousValues']);
unset($_SESSION["signupErr"]);
?>

<html>
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" href="../public/css/signup.css">
    </head>

<body>
    <div class="container">
        <h2>BDHR User Registration</h2>
        
        <form method="post" action="../Controller/SignUpValidation.php">
            <table>
                <tr>
                    <td>Full Name <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="text" name="name" value="<?php echo $previousValues['name'] ?? '' ?>" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["name"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Gender <span class="required">*</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="radiobtn">
                            <label><input type="radio" name="gender" value="male" <?php echo ($previousValues['gender'] ?? '') == 'male' ? 'checked' : ''; ?> required> Male</label>
                            <label><input type="radio" name="gender" value="female" <?php echo ($previousValues['gender'] ?? '') == 'female' ? 'checked' : ''; ?>> Female</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["gender"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Email <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="email" name="email" value="<?php echo $previousValues['email'] ?? '' ?>" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["email"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Phone<span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="text" name="phone" value="<?php echo $previousValues['phone'] ?? '' ?>" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["phone"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Role <span class="required">*</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="radiobtn">
                            <label><input type="radio" name="role" value="patient" <?php echo ($previousValues['role'] ?? '') == 'patient' ? 'checked' : ''; ?> required> Patient</label>
                            <label><input type="radio" name="role" value="doctor" <?php echo ($previousValues['role'] ?? '') == 'doctor' ? 'checked' : ''; ?>> Doctor</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["role"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Password <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["password"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td>Confirm Password <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="password" name="confirmPassword" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["confirmPassword"] ?? ''; ?></div></td>
                </tr>

                <tr>
                    <td><div class="error"><?php echo $signupErr; ?></div></td>
                </tr>

                <tr>
                    <td><input type="submit" name="signup" value="Continue" class="submit-btn"/></td>
                </tr>
                
                <tr>
                    <td class="login-link">
                        Already have an account? <a href="login.php">Login here</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>