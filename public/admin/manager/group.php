<?php
require "../../config.php";
if ($_POST['delete']) {
    header('Content-Type: application/json; charset=utf-8');
    $id = $_POST['delete'];
    $status = $db->where("group_id", $id)->delete("groups");
    exit(json_encode([
        "status" => $status
    ]));
}
include "../layout/header.php";
$groups = $db->get("groups");

function getGroupMemberCount($db, $groupId)
{
    $db->where("groupId", $groupId)->get("users");
    return $db->num_rows();
}

?>

<div class="row">
    <div class="container">
        <a href="/admin/manager/create-group.php" class="btn btn-primary">Tạo nhóm</a>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Quản lý nhóm</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên nhóm</th>
                        <th scope="col">Miêu tả</th>
                        <th scope="col">Số lượng thành viên</th>
                        <th scope="col">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($groups as $index => $group):
                        ?>
                        <tr>
                            <td><?= ++$index ?></td>
                            <td><?= $group['group_name'] ?></td>
                            <td><?= $group['group_description'] ?></td>
                            <td><?= getGroupMemberCount($db, $group['group_id']) ?></td>
                            <td>
                                <a class="btn btn-xs btn-info"
                                   href="/admin/manager/edit-group.php?id=<?= $group['group_id'] ?>">Sửa
                                </a>
                                <button class="btn btn-xs btn-danger" onclick="deleteGroup(<?= $group['group_id'] ?>)">
                                    Xóa
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
    </div>
</div>
<script>

    function deleteGroup(id) {
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
</script>
<?php
include "../layout/footer.php";
?>
