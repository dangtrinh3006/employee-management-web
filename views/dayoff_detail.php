<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}
if ($_SESSION['possition'] == "admin") {
    include_once "../views/navbar_admin.php";
} else if ($_SESSION['possition'] == "leader") {
    include_once "../views/navbar_leader.php";
} else if ($_SESSION['possition'] == "employee"){
    include_once "../views/navbar_employee.php";
} else {
    header('Location: unknown.php');
}
require_once("../admin/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = get_detail_dayoff($id);
    if ($data['id'] != $id  ){
        header('Location: unknown.php');
    }
}


$user_id = $_SESSION['user'];

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $data = get_detail_dayoff($id);
    $data1 = get_users($data['employeeId']);
    $data2 = get_department($data1['department']);

    $employeeName = $data1['fullname'];

    if ($data['tag_file'] == "" || $data['tag_file'] == " " || is_null($data['tag_file'])) {
        $namefile = '';

    } else {
        
        $file = explode("/", $data['tag_file']);
        if (isset($file['2'])) {
            $namefile = $file['2'];
        }
    }
    
} else {
    header('Location: ../views/unknown.php');
    exit();
}

if (isset($_POST['accept'])) {

    $id = $_GET['id'];
    $date = date('Y-m-d');
    $result = update_num_dayoff($id, $data['day_off_request']);
    $result2 = update_status_dayoff("Accept", $id, $date);
    if ($_SESSION['possition'] == "admin") {
        header('Location: ../views/dayoff_admin.php');
    } else {
        header('Location: ../views/dayoff_management.php');
    }
    exit();
}

if (isset($_POST['reject'])) {

    $id = $_GET['id'];
    $date = date('Y-m-d');
    $result2 = update_status_dayoff("Reject", $id, $date);
    if ($_SESSION['possition'] == "admin") {
        header('Location: ../views/dayoff_admin.php');
    } else {
        header('Location: ../views/dayoff_management.php');
    }
    exit();
}

?>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Yêu cầu nghỉ phép</h3>
                <form method="post" enctype="multipart/form-data" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <?php if ($data1['possition'] == 'leader') { ?>
                            <label for="">Mã trưởng phòng</label>
                            <?php
                            } else { ?>
                            <label for="">Mã nhân viên</label> <?php
                            } ?>
                            <input disabled class="form-control" type="text" value="<?= $data['employeeId'] ?>" name="" id=""> 
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Số ngày nghỉ</label>
                            <input disabled class="form-control" type="text" value="<?= $data['day_off_request'] ?>" name="" id="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Ngày bắt đầu</label>
                            <input disabled class="form-control" type="date" value="<?= $data['day_start'] ?>" name="" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Trạng thái</label>
                            <input disabled class="form-control" type="text" value="<?= $data['result'] ?>" name="" id="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Họ tên nhân viên</label>
                            <input disabled class="form-control" type="tex" value="<?= $employeeName ?>" name="" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phòng ban</label>
                            <input disabled class="form-control" type="text" value="<?= $data2['name'] ?>" name="" id="">
                        </div>
                    </div>
                 
                    <div class="form-group">
                        <label>Lý do</label>
                        <input disabled class="form-control" name="reason" id="reason" cols="20" rows="10" style="height:100px" placeholder="Lý do xin nghỉ" value="<?= $data['reason'] ?>"></input>
                    </div>
                    <div class="form-group">
                        <label for="">File đính kèm: <a href="<?php echo $data['tag_file'] ?>" download><?= $namefile ?></a></label>
                    </div>
                    <div class="form-group">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                        <?php
                        if ($data['result'] == "Waiting" && ($_SESSION['user'] != $data['employeeId'])) {
                            ?>
                            <p class="text-center" style="margin:15px">
                            <button name="accept" class="btn btn-success px-5 h-5">Accept</button></span>
                            <button name="reject" class="btn btn-danger px-5 h-5">Reject</button></span>
                        </p> <?php
                        } 
                        ?>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
