<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user'];
if (!isset($_GET['username'])) {
    header('Location: unknown.php');
    exit();
}
if ($_SESSION['possition'] == "admin") {
    include_once "../views/navbar_admin.php";
} else if ($_SESSION['possition'] == "leader") {
    include_once "../views/navbar_leader.php";
} else {
    include_once "../views/navbar_employee.php";
}
require_once('../admin/db.php');

$error = '';
if (isset($_GET['username'])) {
    $id = $_GET['username'];
    $data = getEmployeeByID($id);
    if ($data['username'] != $id || $id === "" || $_SESSION['user'] != $id ){
        header('Location: unknown.php');
    }
    $data1 = get_department($data['department']);
}


if (isset($_POST['submit'])) {
    if ( $_FILES["file"]['name'] == NULL){
        $error = "Không ảnh nào được chọn!";
    } else {
        $allowUpload = true;

        if (!isset($_FILES["file"]))
        {
            $error = "Dữ liệu không đúng cấu trúc";
            die;
        }
        if ($_FILES["file"]['error'] != 0)
        {
            $error = "Dữ liệu upload bị lỗi";
            die;
        }
        
        $target_dir    = "../file/avatar/".$id.'/';
        $target_file   = $target_dir . basename($_FILES["file"]["name"]);
        $maxfilesize   = 8000000; // <= 8MB
    
        $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');
        
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if ($_FILES["file"]["size"] > $maxfilesize)
        {
            $maxfilesize = $maxfilesize/1000000;
            $error= "Không được upload file có kích thước lớn hơn $maxfilesize (MB).";
            $allowUpload = false;
        }
        if (!in_array($imageFileType,$allowtypes ))
        {
            $error = "Không được upload file có định dạng: .".$imageFileType.". Vui lòng upload file ảnh!";
            $allowUpload = false;
        }
    
        
        if ($allowUpload)
        {
            $file_path = '../file/avatar/'.$id;
    
            if (!file_exists($file_path)) {
            
                // Create a new file or direcotry
                mkdir($file_path, 0777, true);
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            }
                
            $avatar_old = $data['avatar'];
            $re = update_avatar($id,$target_file);
            if ($re['code'] == 0) {
                if (!empty($avatar_old) || ($avatar_old != "")){
                    unlink($avatar_old);
                }
                header('Location: ../views/employeeprofile.php?username='.$id);
            }
        }
    }
    

    
}

?>

    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Thông tin tài khoản</h2>
        <div class="row justify-content-center">
                    
            <div class="col-md-8 col-lg-6">
                <form method="post" action="" enctype="multipart/form-data" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
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
                    <div class="form-row">

                    <div style="margin:10px" class="text-center">
                        <label for="img">Cập nhật ảnh đại diện</label>
                        <input type="file" id="file" name="file" accept="image/*">
                        <input type="submit" value="Upload Image" name="submit" class="btn btn-outline-danger">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>

                    </div>
                    </div>

                    <div class="form-group">
                            <label>Mã tài khoản:</label>
                            <input disabled value="<?= $data['username'] ?>" class="form-control " name="manhanvien" id="manhanvien" type="text" placeholder="Chưa có mã nhân viên">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
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
                        <div class="form-group col-md -6">
                            <label>Ngày sinh</label>
                            <input disabled value="<?= $data['birthday'] ?>" class="form-control " name="birthday" id="birthday" type="text" placeholder="Chưa có ngày sinh">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Địa chỉ</label>
                            <input disabled value="<?= $data['address'] ?>" class="form-control" name="address" id="address" type="text" placeholder="Chưa có địa chỉ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Số điện thoại</label>
                            <input disabled value="<?= $data['phone'] ?>" class="form-control " name="phone" id="phone" type="text" placeholder="Chưa có số điện thoại">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ngày vào làm</label>
                            <input disabled value="<?= $data['workday'] ?>" class="form-control" name="workday" id="workday" type="text" placeholder="Chưa có ngày vào làm">
                        </div>
                    </div>
                        <div class="form-group">
                        <?php
                        if ($_SESSION['possition'] === "admin") {
                        ?>

                        <?php
                        } else {
                        ?>
                        <div class="form-group">
                            <label>Phòng ban</label>
                            <input disabled value="<?= $data1['name'] ?>" class="form-control" name="phongban" id="phongban" type="text" placeholder="Phòng ban">
                        </div>
                        <?php
                        }
                        ?>

                        <div class="form-group md-6">
                        <label>Chức vụ</label>

                        <?php
                        if ($data['possition'] === "leader") {
                        ?>
                            <input disabled value="Trưởng phòng" class="form-control" name="chucvu" id="chucvu" type="text" placeholder="Chức vụ">
                        <?php
                        } else if ($data['possition'] === "admin") { ?>
                            <input disabled value="Giám đốc" class="form-control" name="chucvu" id="chucvu" type="text" placeholder="Chức vụ">
                        <?php
                        } else { ?>
                            <input disabled value="Nhân viên" class="form-control" name="chucvu" id="chucvu" type="text" placeholder="Chức vụ">
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php
                        if ($_SESSION['possition'] === "leader") {
                        ?>
                            <p class="text-center" style="margin:15px">
                                <a href="resetpassword.php" class="btn btn-success px-5 h-5">Đổi mật khẩu</a></span>
                                <a href="leader_index.php" class="btn btn-danger px-5 h-5">Huỷ bỏ</a></span>
                            </p>
                        <?php
                        } else {
                        ?>
                            <p class="text-center" style="margin:15px">
                                <a href="resetpassword.php" class="btn btn-success px-5 h-5">Đổi mật khẩu</a></span>
                                <a href="employee_index.php" class="btn btn-danger px-5 h-5">Huỷ bỏ</a></span>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </form>
               
            </div>
        </div>
    </div>

    
    