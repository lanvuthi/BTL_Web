<?php
include "../layout/header.php";

$group = $db->where("group_id", $_GET['id'])->limit(1)->get("groups");

if (!isset($group['group_id'])) {
    echo "<script>alert('Bạn ko thể sửa nhóm này .'); window.location = '/admin/manager/group.php';</script>";
    exit();
}

if (isset($_POST['group_name'])) {
    $status = $db->where("group_id", $_GET['id'])->update("groups", $_POST);
    if ($status) {
        echo "<script>alert('Thông tin đã được cập nhật  .'); </script>";
        $group = $db->where("group_id", $_GET['id'])->limit(1)->get("groups");
    }
}
?>

<div class="container" style="margin-top: 50px;">
    <div class="card">
        <div class="card-header">Sửa nhóm người dùng</div>
        <div class="card-body">
            <form action="" method="POST">

                <div class="form-group">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" required="" class="form-control" id="title" name="group_name"
                           placeholder="Nhập tiêu đề" value="<?= $group['group_name'] ?>">
                </div>

                <div class="form-group">
                    <label for="description">Miêu tả :</label>
                    <textarea class="form-control" name="group_description" rows="3"
                              placeholder="Miêu tả công việc"
                              value="<?= $group['group_description'] ?>"><?= $group['group_description'] ?></textarea>
                </div>

                <div class="button-groups">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="./group.php" class="btn btn-default">Quay lại</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
include "../layout/footer.php";
?>
