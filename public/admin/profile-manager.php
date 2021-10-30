<?php
include "./layout/header.php";

if (isset($_POST['email'])) {
    $status = $db->where("id", $user['id'])->update("users", $_POST);
    if ($status) {
        echo "<script>alert('Cập nhật thông tin thành công !')</script>";
    }
    $user = $db->where("id", $user['id'])->limit(1)->get("users");
}

if (isset($_POST['password'])) {
    $isConfirmPasswordError = false;
    $isWrongPassword = false;

    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['password'];

    if ($_POST['password'] !== $_POST['confirm_password']) {
        $isConfirmPasswordError = true;
    }

    if (md5($oldPassword) !== $user['password']) {
        $isWrongPassword = true;
    }

    if (!$isWrongPassword && !$isConfirmPasswordError) {
        $status = $db->where("id", $user['id'])->update("users", [
            "password" => md5($newPassword)
        ]);
    }

    if ($status) {
        echo "<script>alert('Cập nhật thông tin thành công !')</script>";
    }
}
?>
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Chỉnh sửa thông tin cá nhân </h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                        <div class="form-group">
                            <label>Tên tài khoản</label>
                            <input type="text" name="username"
                                   class="form-control"
                                   value="<?= $user['username'] ?>"
                                   required
                                   disabled
                            >
                            <span class="invalid-feedback">
                </span>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email"
                                   class="form-control <?= $isExistEmail ? "is-invalid" : "" ?>"
                                   value="<?= $user['email'] ?>"
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
                                   value="<?= $user['birthday'] ?>"
                                   required>
                            <span class="invalid-feedback"></span>
                        </div>


                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="fullName"
                                   class="form-control" minlength="8"
                                   value="<?= $user['fullName'] ?>"
                                   required>
                            <span class="invalid-feedback"></span>
                        </div>


                        <button class="btn btn-primary" type="submit">Lưu thông tin</button>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Đổi mật khẩu
                    </h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group">
                            <label>Mật khẩu cũ</label>
                            <input type="password" name="oldPassword"
                                   minlength="8"
                                   class="form-control <?= $isWrongPassword ? "is-invalid" : "" ?>"

                                   value="<?= $oldPassword ?>"
                                   required>
                            <span class="invalid-feedback">
                                <?= $isWrongPassword ? "Mật khẩu không chính xác" : "" ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Mật khẩu mới</label>
                            <input type="password" name="password"
                                   class="form-control" minlength="8"
                                   value="<?= $password ?>"
                                   required>
                            <span class="invalid-feedback"></span>
                        </div>


                        <div class="form-group">
                            <label>Xác nhận lại mật khẩu mới</label>
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
                        <button class="btn btn-primary btn-block" type="submit"> Đổi mật khẩu</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


</div>


<?php
include "./layout/footer.php";
?>

