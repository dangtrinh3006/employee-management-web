<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include_once "../views/navbar_admin.php";
if ($_SESSION['possition'] != "admin") {
    header('Location: unknown.php');
    exit();
}


require_once('../admin/db.php');
$data = get_dayoff_leader();

?>
    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách sách yêu cầu</h2>
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Trưởng phòng</th>
                <th>Phòng Ban</th>
                <th>Ngày bắt đầu</th>
                <th>Số ngày muốn nghỉ</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
            </tr>
            <tbody>
                <?php
                    if ($data['code'] === 0) {
                        while ($row = $data['data']->fetch_assoc()) {
                            $username = $row['employeeId'];
                            $data2 = getEmployeeByID($username);
                            $data1 = get_department($data2['department']);
                    ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= getEmployeeByID($row['employeeId'])['fullname'] ?></td>
                                <td><?= $data1['name'] ?></td>
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
                    else {
                        ?>
                        <tr><td class="text-center" colspan="7">Chưa có dữ liệu</td></tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
