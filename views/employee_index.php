<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}
include_once "../views/navbar_employee.php";

if ($_SESSION['possition'] != "employee") {
    header('Location: unknown.php');
    exit();
}
require_once('../admin/db.php');
$user_id = $_SESSION['user'];
$id = get_department_user($user_id);
$data = get_user_task($id, $user_id);
?>



<div class="container">
    <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách nhiệm vụ</h2>
    <table class="table table-bordered text-center">
        <tr>
            <th>ID</th>
            <th>Tên nhiệm vụ</th>
            <th>Ngày giao</th>
            <th>Ngày hoàn thành</th>
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
                        <td><?= $row['start_day'] ?></td>
                        <td><?= $row['deadline'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td>
                            <?php
                            if ($row['status'] == "New") {
                            ?>
                                <a class="btn btn-primary" href="../views/employeetaskdetail.php?id=<?= $row['id'] ?>">Xem chi tiết</a>
                            <?php
                            } else {
                            ?>
                                <a class="btn btn-primary" href="../views/employeetasksubmit.php?id=<?= $row['id'] ?>">Xem chi tiết</a>
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

