<?php
include "../layout/header.php";
$id = $_GET['id'];
$user = $db->where("id", $id)->limit(1)->get("users");
if (!isset($user['id'])) {
    echo "<script>alert('Người dùng ko tồn tại'); window.location = '/admin/manager/user.php';</script>";
}


if (isset($_POST['email'])) {
    $status = $db->where("id", $user['id'])->update("users", $_POST);
    if ($status) {
        echo "<script>alert('Cập nhật thông tin thành công !'); window.location = '/admin/manager/user.php';</script>";
    }
    $user = $db->where("id", $user['id'])->limit(1)->get("users");
}

$groups = $db->get("groups");

?>

<div class="row">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Quản lý thành viên</h3>
                <form action="" method="post">


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

                    <div class="form-group">
                        <label>Quyền</label>
                        <select class="form-control" name="role" value="<?= $user['role'] ?>">
                            <option value="0">Người dùng</option>
                            <option value="1" <?= $user['role'] == 1 ? "selected" : "" ?>>Quản lý
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nhóm: </label>
                        <select class="form-control" name="groupId" value="<?= $user['groupId'] ?>">
                            <option value="">Cá nhân (Ko xếp nhóm )</option>
                            <?php
                            foreach ($groups as $group):
                                ?>
                                <option value="<?= $group['group_id'] ?>" <?php
                                if ($user['groupId'] === $group['group_id']) {
                                    echo "selected";
                                }
                                ?>>
                                    <?= $group['group_name'] ?>
                                </option>
                            <?php
                            endforeach;
                            ?>

                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit"> Cập nhật thông tin</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "../layout/footer.php";
?>
