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
$department = get_departments();
$error = '';
$avt ='';
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['department'])) {
    $check = getEmployeeByID($_POST['id']);
    if (isset($check['username'])) {
        $error = "This username is exist";
    } else if (strlen($_POST['id']) < 7) {
        $error = "Your username should be more than 6 character";
    } else {
        $result = addEmployee($_POST['id'], $_POST['name'], $_POST['id'], "employee", $_POST['department'], $avt,$_POST['id'],$_POST['phone'],$_POST['gender'],$_POST['workday'],$_POST['birthday'],$_POST['address']);
        header('Location: ../views/admin_index.php');
    }
}
?>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Thêm nhân viên</h3>
                <form method="post" action="addemployee.php" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="text-center">
                        <img class="avatar" src="../images/avt.png" alt="test">
                    </div>
                    
                    <div class="form-group">
                        <label>Tên tài khoản</label>
                        <input required class="form-control " name="id" id="ID" type="text" placeholder="Tên tài khoản">
                    </div>
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input required class="form-control" name="name" id="name" type="text" placeholder="Nhập họ và tên">
                    </div>
                    <div class="form-group">
                    <label for="gender">Giới tính</label>
                    <select name="gender" id="gender">
                        <option value=1 selected>Nam</option>
                        <option value=0>Nữ</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="birthday">Ngày sinh</label>
                    <input required class="form-control" id="birthday" type="date" name="birthday" class="form-control" pattern="\d{1,2}/\d{1,2}/\d{4}">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input required class="form-control" name="phone" id="phone" type="text" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input required class="form-control" name="address" id="address" type="text" placeholder="Nhập địa chỉ">
                    </div>
                    <div class="form-group">
                    <label for="workday">Ngày vào làm</label>
                    <input required class="form-control" id="workday" type="date" name="workday" class="form-control" pattern="\d{1,2}/\d{1,2}/\d{4}">
                    </div>
                    <div class="form-group">
                        <label>Phòng ban</label>
                        <select class="form-control" name="department" id="department">
                            <?php
                            while ($row = $department['data']->fetch_assoc()) {
                            ?>
                                <option value='<?php echo $row["id"] ?>'><?php echo $row['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                        <p class="text-center" style="margin:15px">
                            <button type="submit" class="btn btn-success px-5 h-5">Thêm</button></span>
                            <a href="../views/admin_index.php" class="btn btn-danger px-5 h-5">Huỷ bỏ</a></span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
