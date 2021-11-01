<?php
require("../config.php");
if ($_GET['taskId']) {
    header('Content-Type: application/json; charset=utf-8');

    $input = [
        "{id}" => $_GET['taskId']
    ];

    $query = strtr("SELECT tasks.*, users.fullName as createByUser, groups.*,  assignUser.fullName as assignUserName from tasks
    RIGHT JOIN users ON users.id = tasks.created_by
    LEFT JOIN groups ON tasks.assign_group = groups.group_id
    LEFT JOIN users assignUser ON assignUser.id = tasks.assign_user
    WHERE tasks.id = {id} LIMIT 1",
        $input);
    $task = $db->query($query, true);
    exit(json_encode($task));
}

if ($_POST['delete']) {
    header('Content-Type: application/json; charset=utf-8');
    $id = $_POST['delete'];
    $status = $db->where("id", $id)->delete("tasks");
    exit(json_encode([
        "status" => $status
    ]));
}


if ($_POST['id']) {
    header('Content-Type: application/json; charset=utf-8');


    $isOutOfRange = false;
    //    $datelineTimestamp = strtotime($_POST['inputs']['deadline_at']);
    //
    //    if ($datelineTimestamp <= time()) {
    //        $isOutOfRange = true;
    //    }

    if (!$isOutOfRange) {
        $id = $_POST['id'];
        $_POST['inputs']['updated_at'] = date('Y/m/d H:i:s');
        $status = $db->where("id", $id)->update("tasks", $_POST['inputs']);
        exit(json_encode([
            "status" => $status
        ]));
    } else {
        exit(json_encode([
            "status" => false,
            "message" => "Deadline phải lớn hơn thời gian hiện tại "
        ]));
    }

}

include "./layout/header.php";

//$tasks = $db->where("assign_user", $_SESSION['id'])->or_where("assign_group", $user['groupId'])->get("tasks");

$statusStyle = [
    "Created" => "badge-light",
    "Todo" => "badge-secondary",
    "Doing" => "badge-primary",
    "QA" => "badge-info",
    "Done" => "badge-success"
];

if (isset($_GET['assign_group']) || isset($_GET['assign_user'])) {
    $groupId = isset($_GET['assign_group']) ? $_GET['assign_group'] : -1;
    $userId = isset($_GET['assign_user']) ? $_GET['assign_user'] : -1;

    $input = [
        "{assign_group}" => $groupId,
        "{assign_user}" => $userId
    ];
} else {
    $input = [
        "{assign_group}" => $user['groupId'],
        "{assign_user}" => $user['id']
    ];
}

$query = strtr("SELECT tasks.*, users.fullName as createByUser, groups.*,  assignUser.fullName as assignUserName from tasks
    RIGHT JOIN users ON users.id = tasks.created_by
    LEFT JOIN groups ON tasks.assign_group = groups.group_id
    LEFT JOIN users assignUser ON assignUser.id = tasks.assign_user
    WHERE tasks.assign_user = {assign_user} OR tasks.assign_group = {assign_group}",
    $input);

$tasks = $db->query($query, true);

$todayJobQuery = strtr("SELECT * FROM `tasks` WHERE DATE(`deadline_at`) = CURDATE() AND assign_user = {assign_user} OR assign_group = {assign_group}",
    [
        "{assign_group}" => $user['groupId'],
        "{assign_user}" => $user['id']
    ]);
$todayJobs = $db->query($todayJobQuery, true);

?>
<main class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-12">
            <a href="./create-task.php" type="button" class="btn btn-primary">Tạo mới kế hoạch</a>
            <br />
            <hr />

            <?php
            if ($user['role'] == 1) {
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sel1">Nhóm được giao:</label>
                            <select class="form-control" id="filter_assign_group">
                                <option value=""></option>
                                <?php
                                $groups = $db->get("groups");
                                foreach ($groups as $group):
                                    ?>
                                    <option value='<?= $group['group_id'] ?>' <?= ($group["group_id"] === $_GET['assign_group']) ? "selected" : "" ?>><?= $group['group_name'] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sel1">Cá nhân được giao:</label>
                            <select class="form-control" id="filter_assign_user">
                                <option value=""></option>
                                <?php
                                $users = $db->get("users");
                                foreach ($users as $assignUser):
                                    ?>
                                    <option value='<?= $assignUser['id'] ?>' <?= ($assignUser["id"] === $_GET['assign_user']) ? "selected" : "" ?>><?= $assignUser['username'] ?></option>
                                <?php

                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>


            <?php
            foreach ($todayJobs as $job):
                ?>
                <div class="alert alert-warning" role="alert">
                    <li>Công việc <a href="javascript:void(0)"
                                     onclick="editTask(<?= $job['id'] ?>)"><?= $job['title'] ?>
                        </a> cần phải hoàn thành vào lúc: <b><?= $job['deadline_at'] ?></b>
                    </li>
                </div>
            <?php
            endforeach;
            ?>


            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Miêu tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Nguời tạo</th>
                    <?php
                    if ($user['role'] == 1) {
                        echo "<th scope='col'>Giao cho</th>";
                    }
                    ?>
                    <th scope="col">Hành động</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($tasks as $index => $status):
                    ?>
                    <tr>
                        <th scope="row"><?= ++$index ?></th>
                        <td><a href="javascript:void(0)"
                               onclick="editTask(<?= $status['id'] ?>)"><?= $status['title'] ?>
                            </a></td>

                        <td><?= $status['description'] ?></td>

                        <td>
                            <span class="badge <?= $statusStyle[$status['status']] ?>"><?= $status['status'] ?></span>


                        <td><?= ($status['deadline_at'] == "0000-00-00 00:00:00") ? "<span class='badge badge-info'>Chưa có hạn</span>" : $status['deadline_at'] ?></td>

                        <td><?= $status['created_at'] ?></td>

                        <td><?= $status['createByUser'] ?></td>

                        <?php
                        if ($user['role'] == 1) {
                            ?>
                            <td>

                                <?php
                                if ($status['group_name']):
                                    ?>
                                    <li><b>Nhóm:</b> <?= $status['group_name'] ?></li>
                                <?php
                                endif;
                                ?>


                                <?php
                                if ($status['assignUserName']):
                                    ?>
                                    <li><b>Cá nhân:</b> <?= $status['assignUserName'] ?></li>
                                <?php
                                endif;
                                ?>

                            </td>
                            <?php
                        }
                        ?>
                        <td>
                            <button class="btn btn-xs btn-info"
                                    onclick="editTask(<?= $status['id'] ?>)">Chi tiết
                            </button>
                            <button class="btn btn-xs btn-danger" onclick="deleteTask(<?= $status['id'] ?>)">Xóa
                            </button>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>

                </tbody>
            </table>
        </div>

    </div>

    <div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskId"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateTask" data-taskId="">


                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
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
                                    <input type="text" class="form-control datepicker" name="deadline_at"
                                           placeholder="Deadline at"
                                           autocomplete="off"
                                           id="deadline_at"
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
                            </div>

                            <div class="col-md-4" style="border-left: 1px solid #00000">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <b>Người tạo:</b> <span id="create_by_name"></span>
                                    </li>

                                    <li class="list-group-item">
                                        <b>Giao cho :</b><br /> <span id="assignTo">You</span>
                                    </li>

                                    <li class="list-group-item">
                                        <b>Ngày tạo:</b> <span id="created_at"></span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Cập nhật:</b> <span id="updated_at"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script>

    function editTask(taskId) {
        fetch('?taskId=' + taskId).then(res => res.json()).then(task => {
            const {
                id,
                title,
                description,
                deadline_at,
                status,
                createByUser,
                assignUserName,
                group_name,
                updated_at,
                created_at
            } = task;
            const modal = $('#viewTaskModal');

            modal.find('#updateTask').attr('data-taskId', id);
            modal.find('input[name=\'title\']').val(title);
            modal.find('textarea[name=\'description\']').val(description);
            modal.find('input[name=\'deadline_at\']').val(deadline_at);
            modal.find('select[name=\'status\']').val(status);
            modal.find('#create_by_name').html(createByUser);

            const assignTo = group_name ? '<b>Nhóm:</b> ' + group_name : '<b>Cá Nhân: </b>' + assignUserName;
            modal.find('#assignTo').html(assignTo);

            modal.find('#created_at').html(created_at);

            modal.find('#updated_at').html(updated_at);

            $('#taskId').html('Task: #' + id);

            $('#viewTaskModal').modal('show');

        });
    }

    function deleteTask(id) {
        if (confirm('Bạn có chắc chắn muốn xóa ? ')) {
            $.post('', {
                delete: id
            }).then(res => {
                if (res.status) {
                    alert('Đã xóa!');
                    window.location.reload();
                } else {
                    alert('Đã xảy ra lỗi khi xóa ');
                }
            }).catch(() => {
                alert('Đã xảy ra lỗi khi xóa ');
            });
        }
    }

    const changeParams = (key = '', newValue) => {
        const url = new URL(window.location.href);
        if (newValue !== '') {
            url.searchParams.set(key, newValue);
        } else {
            url.searchParams.delete(key);
            console.log(url.searchParams);
        }

        window.location = url;
    };

    $('#filter_assign_user').change((e) => {
        const newValue = e.target.value;
        changeParams('assign_user', newValue);
    });

    $('#filter_assign_group').change((e) => {
        const newValue = e.target.value;
        changeParams('assign_group', newValue);
    });

    $('#updateTask').submit(e => {
        e.preventDefault();

        const modal = $('#updateTask');

        const id = modal.attr('data-taskId');
        const title = modal.find('input[name=\'title\']').val();
        const description = modal.find('textarea[name=\'description\']').val();
        const deadline_at = modal.find('input[name=\'deadline_at\']').val();
        const status = modal.find('[name=\'status\']').val();

        $.post('', {
            id,
            inputs: {
                title,
                description,
                deadline_at,
                status
            }
        }).then(res => {
            console.log({ res });
            if (res.status) {
                alert('Cập nhật thành công !');
                window.location.reload();
            } else {
                alert((res.message));
            }
        });
    });

</script>
<?php
include "layout/footer.php";
?>
