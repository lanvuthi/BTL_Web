<?php
include "../layout/header.php";

if ($_POST['notification_title']) {
    $status = $db->insert("notifications", $_POST);
    if ($status) {
        echo "<script>alert('Thêm thông báo thành công !!! .');</script>";
    } else {
        echo "<script>alert('Đã xảy ra lỗi khi gửi thông báo! .');</script>";
    }
}

?>

<div class="container" style="margin-top: 50px;">
    <div class="card">
        <div class="card-header">Gửi thông báo</div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <div class="form-group">
                    <label for="title">Tiêu đề thông báo:</label>
                    <input type="text" required="" class="form-control" id="title" name="notification_title"
                           placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                    <label for="description">Nội dung chi tiết :</label>
                    <textarea class="form-control" name="notification_detail" rows="3"
                              placeholder="Miêu tả công việc"></textarea>
                </div>

                <input type="hidden" name="notification_type" value="1" />
                <?php
                if ($user['role'] == 1) {
                    ?>

                    <div class="form-group">
                        <label for="sel1">Gửi cho nhóm:</label>
                        <select class="form-control" id="sel1" name="send_group">
                            <option value="">----------</option>
                            <?php
                            $groups = $db->get("groups");
                            foreach ($groups as $group):
                                echo "<option value='{$group['group_id']}'>{$group['group_name']}</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sel1">Gửi cho cá nhân:</label>
                        <select class="form-control" id="sel1" name="send_user">
                            <option value="">----------</option>
                            <?php
                            $users = $db->get("users");
                            foreach ($users as $assignUser):
                                echo "<option value='{$assignUser['id']}'>{$assignUser['fullName']} - {$assignUser['username']}</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <?php
                }
                ?>

                <div class="alert alert-secondary" role="alert">
                    <b>Tips:</b> Bạn có thể để trống để gửi thông báo cho tất cả người dùng.
                </div>


                <div class="button-groups">
                    <button type="submit" class="btn btn-primary">Gửi</button>
                    <a href="./group.php" class="btn btn-default">Quay lại</a>
                </div>

            </form>
        </div>
    </div>


    <div class="card" style="margin-top: 50px;">
        <div class="card-header">Thông báo đã gửi</div>
        <div class="card-body">
            <ul class="list-group">

                <?php
                $notifications = $db->where("notification_type", 1)->get("notifications");
                foreach ($notifications as $notification):
                    ?>
                    <li class="list-group-item">
                        <strong><?=$notification['notification_title']?>: </strong>
                        <span class="text-muted"><?=$notification['notification_detail']?></span>
                        <div class="notification-info">
                            <hr />
                            <div class="sendTo">
                                <i class="fa fa-clock-o" aria-hidden="true"></i> <?=$notification['created_at']?> |
<!--                                <i class="fa fa-user" aria-hidden="true"></i> <span>asjdkasdj</span> |-->
<!--                                <i class="fa fa-users" aria-hidden="true"></i> <span>asjdkasdj</span><br />-->
                            </div>

                        </div>
                    </li>
                <?php
                endforeach;

                ?>


            </ul>
        </div>
    </div>


</div>


<?php
include "../layout/footer.php";
?>
