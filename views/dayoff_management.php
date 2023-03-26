<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['possition'] != "leader") {
    header('Location: unknown.php');
    exit();
}

$user_id = $_SESSION['user'];
include_once "../views/navbar_leader.php";
require_once('../admin/db.php');
$user_id = $_SESSION['user'];
$id = get_department_user($user_id);
$data = get_dayoff_department($id, $user_id);
?>

    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách sách yêu cầu</h2>
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Nhân viên</th>
                <th>Ngày bắt đầu</th>
                <th>Số ngày muốn nghỉ</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
            </tr>
            <tbody>
                <?php
                if ($data['code'] == 0) {
                    while ($row = $data['data']->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= getEmployeeByID($row['employeeId'])['fullname'] ?></td>
                            <td><?= $row['day_start'] ?></td>
                            <td><?= $row['day_off_request'] ?></td>
                            <td><?= $row['result'] ?></td>
                            <td>
                                <?php
                                if ($row['result'] == "Waiting") {
                                ?>
                                    <a class="btn btn-primary" href="../views/dayoff_detail.php?id=<?= $row['id'] ?>">Xem chi tiết</a>
                                <?php
                                } else {
                                ?>
                                    <a class="btn btn-primary" href="../views/dayoff_detail.php?id=<?= $row['id'] ?>">Xem chi tiết</a>
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
