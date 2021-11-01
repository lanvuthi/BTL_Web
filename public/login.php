<?php
include "./layout/header.php";
include "./config.php";

if (isset($_SESSION['id'])) {
    exit("<script>window.location = 'admin/index.php';</script>");
}

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $db->where([
        "username" => $username,
        "password" => md5($password)
    ])->limit(1)->get("users");


    if (isset($user['id'])) {
        $_SESSION["id"] = $user['id'];
        $_SESSION["username"] = $user['username'];
        exit("<script>window.location = 'admin/index.php';</script>");

    } else {
        $isWrongPassword = true;
    }
}
?>

<div class="container boxContainer">
    <div>
        <h2>Đăng Nhập</h2>
        <p>Vui lòng điền thông tin đăng nhập của bạn để đăng nhập.</p>

        <?php
        if ($isWrongPassword) {
            echo '<div class="alert alert-danger">
                Tên đăng nhập hoặc mật khẩu không đúng </div>';
        }
        ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Tên tài khoản</label>
                <input type="text" name="username"
                       class="form-control"
                       required
                       value="<?= $username ?>"
                >
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password"
                       class="form-control "
                       required
                >
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Đăng nhập">
            </div>
            <p>Không có tài khoản? <a href="/register.php">Đăng ký tài khoản.</a>.</p>
        </form>
    </div>
</div>

<?php
include "./layout/footer.php";
?>
