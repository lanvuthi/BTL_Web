<?php
session_start();
require_once(dirname(__DIR__) . "./../config.php");
$user = $db->where("id", $_SESSION['id'])->limit(1)->get("users");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/vi.min.js"
            integrity="sha512-LvYVj/X6QpABcaqJBqgfOkSjuXv81bLz+rpz0BQoEbamtLkUF2xhPNwtI/xrokAuaNEQAMMA1/YhbeykYzNKWg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="/assets/css/admin.css">

    <script src="https://www.jqueryscript.net/demo/Date-Time-Picker-Bootstrap-4/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet"
          href="https://www.jqueryscript.net/demo/Date-Time-Picker-Bootstrap-4/build/css/bootstrap-datetimepicker.min.css" />

    <title>Quản Lý</title>
</head>
<body>
<div class="header">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/admin/index.php">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/Trello-logo-blue.svg/2560px-Trello-logo-blue.svg.png"
                 height="20px" />
        </a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/index.php">Quản lý công việc<span class="sr-only">(current)</span></a>
                </li>

                <?php
                if ($user['role'] === '1') {
                    ?>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown">Quản lý <i
                                        class="arrow down"></i></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/admin/manager/user.php">Quản lý người dùng</a>
                                <a class="dropdown-item" href="/admin/manager/group.php">Quản lý nhóm người dùng</a>
                                <a class="dropdown-item" href="/admin/manager/notification.php">Gửi thông báo</a>
                            </div>
                        </div>

                    </li>


                    <?php
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="/admin/profile-manager.php">Thông tin cá nhân</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/logout.php">Đăng xuất</a>
                </li>

            </ul>
            <div class="nav-notification">

            </div>

            <?php

            $input = [
                "{send_user}" => $user['id'],
                "{send_group}" => $user['groupId']
            ];

            $query = strtr("SELECT * FROM `notifications` WHERE send_user = {send_user} OR send_group = {send_group} or (send_user =0 and send_group = 0) ORDER BY noti_id DESC",
                $input);

            $notifications = $db->query($query, true);


            ?>
            <div class="my-4 my-lg-0 header-right">
                <div class="badge" id="bell">
                    <img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-bell-512.png" width=""
                         50px />
                    <span><?= count($notifications) ?></span>
                </div>

                <div class="notification" style="max-width: 400px; min-width: 400px;">
                    <ul class="list-group">
                        <?php
                        foreach ($notifications as $notification):
                            ?>
                            <li class="list-group-item">
                                <span><?= $notification['notification_title'] ?>: </span> <br />
                                <span class="text-muted"><?= $notification['notification_detail'] ?></span>
                                <div class="notification-info">
                                    <div class="sendTo" style="font-size: 10px;">
                                        <i class="fa fa-clock-o"
                                           aria-hidden="true"></i> <?= $notification['created_at'] ?>
                                    </div>

                                </div>
                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>

                </div>

                <div class="nav-info">
                    <div class="nav-info__left">
                        <b><?= $user['fullName'] ?></b>
                        <span class="role">
                            <?php
                            if ($user['role'] == '1') {
                                echo '<span class="badge badge-primary">Quản trị viên</span>';
                            }else{
                                echo '<span class="badge badge-default">User</span>';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="nav-info__right">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkfLH-eNQSC_NGgramusia6FMOMLSTirhokA&usqp=CAU"
                             alt="Avatar" class="rounded-circle" width="50px">
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
