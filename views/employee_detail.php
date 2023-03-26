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
if (!isset($_GET['username'])) {
    header('Location: unknown.php');
    exit();
}

include_once "../views/navbar_admin.php";
require_once('../admin/db.php');

if (isset($_GET['username'])) {
    $id = $_GET['username'];
    $data = getEmployeeByID($id);
    if ($data['username'] != $id || $id === ""){
        header('Location: unknown.php');
    }
}

if (isset($_GET['username'])) {
    $id = $_GET['username'];
    $data = getEmployeeByID($id);
    if ($data['username'] != $id  ){
        header('Location: unknown.php');
    }
    $data1 = get_department($data['department']);
}
if (isset($_POST['manhanvien'])) {
    $id = $_POST['manhanvien'];

    updatePassword($id, $id);
    header('Location: ../views/admin_index.php');  
}
if (isset($_GET['username'])) {
    $id = $_GET['username'];
    $data = getEmployeeByID($id);
    $data1 = get_department($data['department']);
}



$error = "";

$username = $_GET['username'];
$data = get_users($username);
?>


    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Thông tin tài khoản</h2>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="text-center">
                    <?php
                        if ($data['avatar'] === "" || is_null($data['avatar'])) {
                        ?>
                            <img class="avatar" src="../images/avt.png" alt="test">
                        <?php
                        } else { ?>
                            <img class="avatar" src="<?= $data['avatar'] ?>" alt="test">
                        <?php
                        }
                    ?>
                    </div>
                    <div class="form-group">
                            <label>Mã nhân viên</label>
                            <input value="<?= $data['username'] ?>" class="form-control " name="manhanvien" id="manhanvien" type="text" placeholder="Chưa có mã nhân viên">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input disabled value="<?= $data['fullname'] ?>" class="form-control" name="hoten" id="hoten" type="text" placeholder="Nhập họ và tên">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Giới tính</label>
                            
                        <?php
                        if ($data['gender'] === 0) {
                        ?>
                            <input disabled value="Nữ" class="form-control" name="gender" id="gender" type="text" placeholder="Chức vụ">
                        <?php
                        } else { ?>
                            <input disabled value="Nam" class="form-control" name="gender" id="gender" type="text" placeholder="Chức vụ">
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input disabled value="<?= $data['birthday'] ?>" class="form-control " name="birthday" id="birthday" type="text" placeholder="Chưa có ngày sinh">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Địa chỉ</label>
                            <input disabled value="<?= $data['address'] ?>" class="form-control" name="address" id="address" type="text" placeholder="Chưa có địa chỉ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input disabled value="<?= $data['phone'] ?>" class="form-control " name="phone" id="phone" type="text" placeholder="Chưa có số điện thoại">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ngày vào làm</label>
                            <input disabled value="<?= $data['workday'] ?>" class="form-control" name="workday" id="workday" type="text" placeholder="Chưa có ngày vào làm">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phòng ban</label>
                            <input disabled value="<?= $data1['name'] ?>" class="form-control" name="phongban" id="phongban" type="text" placeholder="Phòng ban">
                        </div>
                        <div class="form-group col-md-6">
                        <label>Chức vụ</label>

                        <?php
                        if ($data['possition'] === "leader") {
                        ?>
                            <input disabled value="Trưởng phòng" class="form-control" name="chucvu" id="chucvu" type="text" placeholder="Chức vụ">
                        <?php
                        } else { ?>
                            <input disabled value="Nhân viên" class="form-control" name="chucvu" id="chucvu" type="text" placeholder="Chức vụ">
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                   
                    <div class="text-center">
                    <button type="submit" class="btn btn-danger px-5 h-5">Reset Password</button>
                    </div>
                </form>
    
            </div>
            
        </div>
    </div>
