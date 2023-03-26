<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}
if ($_SESSION['possition'] == "leader") {
    include_once "../views/navbar_leader.php";
} else if ($_SESSION['possition'] == "employee") {
    include_once "../views/navbar_employee.php";
} else {
    header('Location: unknown.php');
}
require_once('../admin/db.php');
$user_id = $_SESSION['user'];
$dayoff = sum_dayoff($user_id);

if ($_SESSION['possition'] === "leader") {
    $dayleff = 15 - $dayoff['sumd'];
} else {
    $dayleff = 12 - $dayoff['sumd'];
}

$data = get_dayoff_request($user_id);


?>


    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Thông tin nghỉ phép</h2>
        <table class="table table-bordered text-center">
            <tr>
                <th>Tổng số ngày nghỉ phép</th>
                <th>Số ngày đã nghỉ</th>
                <th>Số ngày còn lại</th>
                <th>Tạo đơn</th>
            </tr>
            <?php
            if ($_SESSION['possition'] == "employee") {
            ?>
                <tr>
                    <td>12</td>
                    <td><?= $dayoff['sumd'] ?></td>
                    <td><?= $dayleff ?></td>
                    <td><a href="create_form_dayoff.php" class="btn btn-primary">Tạo đơn mới</a></td>
                </tr>
            <?php
            } else {
            ?>
                <tr>
                    <td>15</td>
                    <td><?= $dayoff['sumd'] ?></td>
                    <td><?= $dayleff ?></td>
                    <td><a href="create_form_dayoff.php" class="btn btn-primary">Tạo đơn mới</a></td>
                <?php
            }
                ?>
        </table>
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách yêu cầu</h2>
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Ngày bắt đầu nghỉ</th>
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

 