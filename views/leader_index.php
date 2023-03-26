<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['possition'] != "leader") {
    header('Location: ../views/unknown.php');
    exit();
}
include_once "../views/navbar_leader.php";
require_once('../admin/db.php');
$user_id = $_SESSION['user'];
$id = get_department_user($user_id);
$data = get_task_department($id);
?>


    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách nhiệm vụ</h2>
        <div class="form-group">
            <a href="../views/addtask.php" class="btn btn-primary">Tạo nhiệm vụ mới</a>
        </div>
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Tên nhiệm vụ</th>
                <th>Nhân viên thực hiện</th>
                <th>Ngày giao</th>
                <th>Hạn nộp</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
            </tr>
            <tbody>
                <?php
                if ($data['code'] == 3) {
                    while ($row = $data['data']->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $data2 = getEmployeeByID($row['account_id'])['fullname'] ?></td>
                            <td><?= $row['start_day'] ?></td>
                            <td><?= $row['deadline'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <?php
                                if ($row['status'] == "Canceled") {
                                ?>
                                    <a class="btn btn-danger" href="../views/leadertaskview.php?id=<?= $row['id'] ?>">Xem chi tiết</a>
                                <?php
                                } else {
                                ?>
                                    <a class="btn btn-primary" href="../views/leadertaskview.php?id=<?= $row['id'] ?>">Xem chi tiết</a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
