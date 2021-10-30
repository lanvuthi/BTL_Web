<?php
include "../layout/header.php";
$users = $db->query("SELECT * FROM `users` INNER JOIN groups ON users.groupId = groups.group_id ", true);
?>
<div class="row">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Quản lý thành viên</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Tên đây đủ</th>
                        <th scope="col">Email</th>
                        <th scope="col">Birthday</th>
                        <th scope="col">Group</th>
                        <th scope="col">Role</th>
                        <th scope="col">Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($users as $index => $user):
                        ?>
                        <tr>
                            <th scope="row"><?= ++$index ?></th>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['fullName'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['birthday'] ?></td>
                            <td><?= $user['group_name'] ?></td>
                            <td><?= $user['role'] == 1 ? "Admin" : "Thành viên " ?></td>
                            <td>
                                <a class="btn btn-xs btn-info"
                                        href="/admin/manager/edit-user.php?id=<?= $user['id'] ?>">Sửa
                                </a>
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
    </div>
</div>
<?php
include "../layout/footer.php";
?>
