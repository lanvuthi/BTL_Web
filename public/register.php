<?php
include "./layout/header.php";
include "./config.php";

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $isConfirmPasswordError = true;
    }

    $db->where("username", $username)->get("users");
    $isExistUser = $db->num_rows() > 0;

    $db->where("email", $email)->get("users");
    $isExistEmail = $db->num_rows() > 0;

    if (!$isExistUser) {
        $data = $db->insert("users", [
            "username" => $username,
            "password" => md5($password),
            "email" => $email,
            "birthday" => $_POST['birthday'],
            "fullName" => $_POST['fullName'],
            "role" => 0
        ]);
        if ($data) {
            $isSuccess = true;
        } else {
            $isSuccess = false;
        }
    }
}
?>
<div class="container boxContainer">
    <div>
        <h2>Đăng Ký</h2>
        <p>Vui lòng điền vào biểu mẫu này để tạo một tài khoản.</p>

        <?php
        if ($isSuccess) {
            ?>
            <div class="alert alert-primary" role="alert">
                Đăng ký thành công ! Bây giờ bạn có thể <a href="/login.php">đăng nhập</a>
            </div>
            <?php
        }
        ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Tên tài khoản</label>
                <input type="text" name="username"
                       class="form-control <?= $isExistUser ? "is-invalid" : "" ?>"
                       value="<?= $username ?>"
                       required
                >
                <span class="invalid-feedback">
                    <?= $isExistUser ? "Tài khoản này đã tồn tại. Vui lòng chọn tài khoản khác" : "" ?>
                </span>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                       class="form-control <?= $isExistEmail ? "is-invalid" : "" ?>"
                       value="<?= $_POST['email'] ?>"
                       required
                >
                <span class="invalid-feedback" r
                <?= $isExistEmail ? "Email này đã tồn tại. Vui lòng chọn email khác" : "" ?>
                </span>
            </div>


            <div class="form-group">
                <label>Ngày sinh</label>
                <input type="text" name="birthday"
                       class="form-control" minlength="8"
                       value="<?= $_POST['birthday'] ?>"
                       required>
                <span class="invalid-feedback"></span>
            </div>


            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="fullName"
                       class="form-control" minlength="8"
                       value="<?= $_POST['fullName'] ?>"
                       required>
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password"
                       class="form-control" minlength="8"
                       value="<?= $password ?>"
                       required>
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
                <label>Xác nhận lại mật khẩu</label>
                <input type="password" name="confirm_password"
                       class="form-control <?= $isConfirmPasswordError ? "is-invalid" : "" ?>"
                       value=""
                       minlength="8"
                       required
                >
                <span class="invalid-feedback">
                    <?= $isConfirmPasswordError ? "Nhập lại mật khẩu phải trùng với mật khẩu của bạn" : "" ?>
                </span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Đăng ký">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập ở đây</a>.</p>
        </form>
    </div>
</div>
<?php
include "./layout/footer.php";
?>
