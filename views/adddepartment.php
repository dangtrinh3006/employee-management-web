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
require_once('../admin/db.php');
?>
<?php

$error = '';
$id = uniqid();
$name = '';
$room = '';
$detail = '';
if (isset($_POST['name']) && isset($_POST['room']) && isset($_POST['detail'])) {
    $name = $_POST['name'];
    $room = $_POST['room'];
    $detail = $_POST['detail'];


    if (empty($id)) {
        $error = 'Hãy nhập mã phòng ban';
    } else if (empty($name)) {
        $error = 'Hãy nhập tên phòng ban';
    } else if (empty($room)) {
        $error = 'Hãy nhập số phòng ban';
    } else if (empty($detail)) {
        $error = 'Hãy nhập mô tả phòng ban';
    } else {
        add_department($id, $name, $room, $detail);
        header('Location: ../views/department_management.php');
    }
}
?>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Thêm phòng ban</h3>
                <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Mã phòng ban</label>
                            <input value="<?= $id ?>" disabled class="form-control " name="id" id="id" type="text" placeholder="Mã phòng ban">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Số phòng</label>
                            <input class="form-control" name="room" id="room" type="text" placeholder="Nhập số phòng">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tên phòng ban</label>
                        <input class="form-control" name="name" id="name" type="text" placeholder="Tên phòng ban">
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" name="detail" id="detail" cols="20" rows="10" style="height:100px" placeholder="Thêm mô tả về phòng ban"></textarea>
                    </div>
                    <div class="form-group">
                        <p class="text-center" style="margin:15px">
                            <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            ?>
                            <button type="submit" class="btn btn-success px-5 h-5">Thêm</button></span>
                            <a href="../views/department_management.php" class="btn btn-danger px-5 h-5">Huỷ bỏ</a></span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
