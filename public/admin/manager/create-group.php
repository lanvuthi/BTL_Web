<?php
include "../layout/header.php";

if ($_POST['group_name']) {
    $status = $db->insert("groups", $_POST);
    if ($status) {
        echo "<script>alert('Tạo nhóm thành công !.'); window.location = '/admin/manager/group.php';</script>";
    } else {
        echo "<script>alert('Xảy ra lỗi khi tạo nhóm. Thử lại sau.')</script>";
    }
}
?>

<div class="container" style="margin-top: 50px;">
    <div class="card">
        <div class="card-header">Tạo nhóm mới</div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <div class="form-group">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" required="" class="form-control" id="title" name="group_name"
                           placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                    <label for="description">Miêu tả :</label>
                    <textarea class="form-control" name="group_description" rows="3"
                              placeholder="Miêu tả công việc"></textarea>
                </div>

                <div class="button-groups">
                    <button type="submit" class="btn btn-primary">Tạo</button>
                    <a href="./group.php" class="btn btn-default">Quay lại</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
include "../layout/footer.php";
?>
