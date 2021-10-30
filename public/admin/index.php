<?php
require("../config.php");
if ($_GET['taskId']) {
    header('Content-Type: application/json; charset=utf-8');
    $task = $db->where("id", $_GET['taskId'])->limit(1)->get("tasks");
    exit(json_encode($task));
}
if ($_POST['id']) {
    header('Content-Type: application/json; charset=utf-8');
    $id = $_POST['id'];
    $status = $db->where("id", $id)->update("tasks", $_POST['inputs']);
    exit(json_encode([
        "status" => $status
    ]));
}
include "./layout/header.php";
$tasks = $db->where("created_by", $_SESSION['id'])->get("tasks");

$statusStyle = [
    "Created" => "badge-light",
    "Todo" => "badge-secondary",
    "Doing" => "badge-primary",
    "QA" => "badge-info",
    "Done" => "badge-success"
]
?>
<main class="container" style="margin-top: 50px;">
    <div class="row">

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Lọc kế hoạch:</div>
                <div class="card-body">

                    <form class="form-group ">
                        <b>Tìm kiếm :</b> <br />
                        <input class="form-control " type="search" placeholder="Cụm từ cần tìm">
                    </form>
                    <div class="from-group date">
                        <b>Từ</b> <br />
                        <input class="form-control datepicker" data-date-format="dd-mm-yyyy" readonly=""
                               type="text">
                        <span class="input-group-addon"><i
                                    class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <br />
                    <div class="from-group date" data-date-format="dd-mm-yyyy">
                        <b>Tới:</b> <br />
                        <input class="form-control datepicker" data-date-format="dd-mm-yyyy" readonly=""
                               type="text">
                        <span class="input-group-addon"><i
                                    class="glyphicon glyphicon-calendar"></i></span>
                    </div>

                    <br />
                    <hr />
                    <button class="btn btn-info btn-block">Tìm kiếm</button>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <a href="./create-task.php" type="button" class="btn btn-primary">Tạo mới kế hoạch</a>
            <br />
            <hr />

            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Miêu tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Ngày tạo</th>
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


                        <td><?= $status['deadline_at'] ?></td>

                        <td><?= $status['created_at'] ?></td>

                        <td>
                            <button class="btn btn-xs btn-info"
                                    onclick="editTask(<?= $status['id'] ?>)">Chi tiết
                            </button>
                            <button class="btn btn-xs btn-danger">Xóa</button>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskId"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateTask" data-taskId="">

                    <div class="modal-body">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script>

    function editTask(taskId) {
        fetch('?taskId=' + taskId).then(res => res.json()).then(task => {
            const { id, title, description, deadline_at, status } = task;
            const modal = $('#viewTaskModal');

            modal.find('#updateTask').attr('data-taskId', id);
            modal.find('input[name=\'title\']').val(title);
            modal.find('textarea[name=\'description\']').val(description);
            modal.find('input[name=\'deadline_at\']').val(deadline_at);
            modal.find('select[name=\'status\']').val(status);

            $('#taskId').html('Task: #' + id);

            $('#viewTaskModal').modal('show');

        });
    }

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
            }
        });
    });

</script>
<?php
include "layout/footer.php";
?>
