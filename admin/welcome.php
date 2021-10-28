<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng tới đây</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Chào, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Chào mừng đến với trang web của chúng tôi.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Đặt lại mật khẩu của bạn.</a>
        <a href="logout.php" class="btn btn-danger ml-3">Thoát tài khoản.</a>
    </p>
</body>
</html>