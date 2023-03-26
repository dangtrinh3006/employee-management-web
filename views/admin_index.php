<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['possition'] != "admin") {
    header('Location: unknown.php');
    exit();
}
include_once "../views/navbar_admin.php";
require_once('../admin/db.php');

$data = get_user();
?>


    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách nhân viên</h2>
        <div class="form-group">
            <a href="../views/addemployee.php" class="btn btn-primary">Thêm nhân viên</a>
        </div>
        <table class="table table-bordered text-center">
            <tr>
                <th>Tên tài khoản</th>
                <th>Họ tên</th>
                <th>Chức vụ</th>
                <th>Phòng ban</th>
                <th>Chi tiết</th>
            </tr>
            <tbody id="department-body">
                <?php
                if ($data['code'] === 0) {
                    while ($row = $data['data']->fetch_assoc()) {
                        $username = $row['username'];
                        $data2 = getEmployeeByID($username);
                        $data1 = get_department($data2['department']);
                    ?>
                        <tr>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['fullname'] ?></td>
                            <td>
                            <?php
                            if ($row['possition'] === "leader") {
                            ?>
                                Trưởng phòng
                            <?php
                            } else { ?>
                                Nhân viên
                            <?php
                            }
                            ?>
                            </td>
                            <td><?= $data1['name']?></td>
                            <td><a href="../views/employee_detail.php?username=<?= $row['username'] ?>" class="btn btn-primary">Chi tiết</a></td>
                            
    
                        </tr>
                    <?php
                    }
                }
                else {
                    ?>
                    <tr><td colspan="5" class="text-center">Chưa có dữ liệu</td></tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>



  