<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}
if ($_SESSION['possition'] != "admin") {
    header('Location: unknown.php');
    exit();
}

include_once "../views/navbar_admin.php";
require_once("../admin/db.php");
$data = get_departments();
?>

<!doctype html>
<html lang="en">


    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách phòng ban</h2>
        <div class="form-group">
            <a href="../views/adddepartment.php" class="btn btn-primary">Thêm phòng ban</a>
        </div>
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Tên phòng ban</th>
                <th>Vị trí</th>
                <th>Mô tả</th>
                <th>Chi tiết</th>
            </tr>
            <tbody id="department-body">
                <?php
                    if ($data['code'] === 0) {
                        while ($row = $data['data']->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['room'] ?></td>
                                    <td><?= $row['detail'] ?></td>
                                    <td><a href="phongban.php?id=<?= $row['id'] ?>" class="btn btn-primary">Xem chi tiết</a></td>
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
