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
require_once("../admin/db.php");

$user_id = $_SESSION['user'];
$dayoff = sum_dayoff($user_id);

$current_request = get_current_dayoff($user_id);
$current_date = date('Y-m-d');
$check = 1;

if ($_SESSION['possition'] === "leader") {
    $dayleff = 15 - $dayoff['sumd'];
} else {
    $dayleff = 12 - $dayoff['sumd'];
}



$id = uniqid();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$departId = get_department_user($user_id);
$error = '';
$startday = '';
if (isset($current_request['day_off_response'])) {
    $date =  (strtotime($current_date) - strtotime($current_request['day_off_response'])) / (60 * 60 * 24);
    if ($date < 8) {
        $check = 0;
        $error = "Bạn vừa gửi yêu cầu gần đây, không thể tạo thêm";
    }
}
if (isset($current_request['result'])) {
    if ($current_request['result'] == "Waiting") {
        $check = 0;
        $error = "Yêu cầu của bạn đang xử lý, bạn không thể tạo thêm";
    }
}

if (isset($_POST['startday']) && isset($_POST['reason'])) {
    $dayrequest = $_POST['dayoff'];
    $starday = $_POST['startday'];
    $detail = $_POST['reason'];

    if ($dayrequest == 0 || ($dayrequest > $dayleff)) {
        $error = 'Số ngày nghỉ không hợp lệ';
    } else if (empty($starday)) {
        $error = 'Nhập ngày muốn xin nghỉ';
    } else if (empty($detail)) {
        $error = 'Nhập lý do xin nghỉ';
    } else if($starday < $current_date) {
        $error = 'Ngày bạn chọn không hợp lệ';
    } else if ( $_FILES["file"]['name'] == "") {
        $target_file = '';
        $result = add_request_dayoff($id, $user_id, date('Y-m-d\TH:i'), $starday, $detail, "Waiting", $departId, $dayrequest, $target_file);
        if ($result['code'] == 0) {
            header('Location: ../views/employee_dayoff.php');
            exit();
        }
    }
    else {
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
    
    $target_dir    = "../file/";
    $target_file   = $target_dir . basename($_FILES["file"]["name"]);
    $maxfilesize   = 8000000; // <= 8MB

    $allowtypes    = array('bat', 'chm', 'cmd', 'com','cpl','exe','hlp','hta','js','jse','lnk','msi','pif','reg','scr','sct','shb','shs','vb','vbe','vbs','wsc');
    $allowUpload   = true;

    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if ($_FILES["file"]["size"] > $maxfilesize)
    {
        $maxfilesize = $maxfilesize/1000000;
        $error= "Không được upload file có kích thước lớn hơn $maxfilesize (MB).";
        $allowUpload = false;
    }
    if (in_array($imageFileType,$allowtypes ))
    {
        $error = "Không được upload file có định dạng: .".$imageFileType.". Vui lòng upload các file không có khả năng thực thi!";
        $allowUpload = false;
    }

    if ($allowUpload)
    {
        // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        $result = add_request_dayoff($id, $user_id, date('Y-m-d\TH:i'), $starday, $detail, "Waiting", $departId, $dayrequest, $target_file);
        if ($result['code'] == 0) {
            header('Location: ../views/employee_dayoff.php');
            exit();
        }
    }    
        
    }
}

?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Yêu cầu nghỉ phép</h3>
                <form method="post" enctype="multipart/form-data" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="">Ngày bắt đầu</label>
                        <input type="date" name="startday" id="startday" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Số ngày muốn nghỉ</label>
                        <select class="form-control" id="dayoff" name="dayoff">
                            <?php
                            for ($i = 0; $i <= $dayleff; $i++) {
                            ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lý do</label>
                        <input class="form-control" name="reason" id="reason" cols="20" rows="10" style="height:100px" placeholder="Lý do xin nghỉ"></input>
                    </div>
                    <div class="form-group">
                        <label for="">File đính kèm (nếu có)</label>
                        <input type='file' name='file' />
                    </div>
                    <div class="form-group">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }

                        if ($_SESSION['possition'] === "leader") {
                        ?>
                            <p class="text-center" style="margin:15px">
                                <button <?php if ($check == 0) {
                                            echo 'disabled';
                                        } ?> type="submit" class="btn btn-success px-5 h-5">Tạo</button></span>
                                <a href="../views/employee_dayoff.php" class="btn btn-danger px-5 h-5">Huỷ bỏ</a></span>
                            </p>
                        <?php
                        } else { ?>
                            <p class="text-center" style="margin:15px">
                                <button <?php if ($check == 0) {
                                            echo 'disabled';
                                        } ?> type="submit" class="btn btn-success px-5 h-5">Tạo</button></span>
                                <a href="../views/employee_dayoff.php" class="btn btn-danger px-5 h-5">Huỷ bỏ</a></span>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
