<?php
session_start();
$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;

if($isLoggedIn){
    $role = $_SESSION["role"] ?? "";
    if($role == "patient"){
        Header("Location: ../../Patient/View/dashboard.php");
    } elseif($role == "doctor"){
        Header("Location: ../../Doctor/View/dashboard.php");
    }
    exit();
}

$previousValues = $_SESSION["previousValues"] ?? [];
$loginErr = $_SESSION["loginErr"] ?? "";
$errors = $_SESSION["errors"] ?? [];
$successMsg = $_SESSION["successMsg"] ?? "";

unset($_SESSION['errors']);
unset($_SESSION['previousValues']);
unset($_SESSION["loginErr"]);
unset($_SESSION["successMsg"]);
?>

<html>
    <head>
        <title>Login - BDHR</title>
        <link rel="stylesheet" href="../public/css/login.css">
    </head>

<body>
    <div class="container">
        <h2>Bangladesh Digital Health Registry</h2>
        <div class="logo-container">
            <img src="../public/uploads/logo.png" alt="BDHR Logo" class="logo">
        </div>
        
        <?php if($successMsg): ?>
            <div class="success-msg"><?php echo $successMsg; ?></div>
        <?php endif; ?>
        
        <form method="post" action="../Controller/LoginValidation.php">
            <table>
                <tr>
                    <td>Email or Phone <span class="required">*</span></td>
                </tr>
                <tr>
                    <td><input type="text" name="email_phone" value="<?php echo $previousValues['email_phone'] ?? '' ?>" required/></td>
                </tr>
                <tr>
                    <td><div class="error"><?php echo $errors["email_phone"] ?? ''; ?></div></td>
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
                    <td><div class="error"><?php echo $loginErr; ?></div></td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="login" value="Login" class="submit-btn"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="signup-link">
                        Don't have an account? <a href="signup.php">Sign up here</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>