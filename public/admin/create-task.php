<?php
include "./layout/header.php";
require_once('../config.php');

if (isset($_POST['title'])) {
    $data = [
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "deadline_at" => $_POST['deadline_at'],
        "status" => $_POST['status'],
        "created_by" => $_SESSION['id']
    ];

    $status = $db->insert("tasks", $data);
    if ($status) {
        echo "<script>alert('Đã tạo kế hoạch')</script>";
    }
}

?>
<div class="container" style="margin-top: 50px;">
    <div class="card">
        <div class="card-header">Tạo mới kế hoạch</div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <div class="form-group">
                    <label for="title">Tiêu đề:</label>
                    <input type="title" required="" class="form-control" id="title" name="title"
                           placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                    <label for="description">Miêu tả :</label>
                    <textarea class="form-control" name="description" rows="3"
                              placeholder="Miêu tả công việc"></textarea>
                </div>

                <div class="form-group">
                    <label for="deadline_at">Deadline:</label>
                    <input type="text" class="form-control datepicker" name="deadline_at" placeholder="Deadline at"
                           required>
                </div>


                <div class="form-group">
                    <label for="sel1">Trạng thái:</label>
                    <select class="form-control" id="sel1" name="status" required>
                        <option>Created</option>
                        <option>Todo</option>
                        <option>Doing</option>
                        <option>QA</option>
                        <option>Done</option>
                    </select>
                </div>

                <div class="button-groups">
                    <button type="submit" class="btn btn-primary">Tạo</button>
                    <a href="index.php" class="btn btn-default">Quay lại</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
include "./layout/footer.php";
?>
