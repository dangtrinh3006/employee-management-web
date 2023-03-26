<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}

if ($_SESSION['possition'] == "admin") {
    header('Location: unknown.php');
    exit();
}

$user_id = $_SESSION['user'];
if ($_SESSION['possition'] == "employee") {
    include_once "../views/navbar_employee.php";
} else if ($_SESSION['possition'] == "leader") {
    include_once "../views/navbar_leader.php";
}

require_once('../admin/db.php');




$department = get_department_user($_SESSION['user']);
$account = getEmployeebyDepartment($department);
// $idtask = $_GET['id'];
date_default_timezone_set('Asia/Ho_Chi_Minh');

if (isset($_GET['id'])) {
    $submit = get_submit($_GET['id']);
    if (!$submit['data']){
        header('Location: unknown.php');
    }


    $data = $submit['data']->fetch_assoc();
    

    if ($data['tag_file'] == "" || $data['tag_file'] == " " || is_null($data['tag_file'])) {
        $namefile = '';

    } else {
        
        $file = explode("/", $data['tag_file']);
        if (isset($file['2'])) {
            $namefile = $file['2'];
        }
    }

    if ($data['tag_file_response'] == "" || $data['tag_file_response'] == " " || is_null($data['tag_file_response'])) {
        $namefile1 = '';

    } else {
        
        $file1 = explode("/", $data['tag_file_response']);
        if (isset($file1['2'])) {
            $namefile1 = $file1['2'];
        }
    } 
}
else {
    header('Location: unknown.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($data['submit_id'] != $id  || $id === ""){
        header('Location: unknown.php');
    }
}
// addTask($accountID, $deadline, $departmentID, $detail, $id, $startDay, $status, $tagFile, $title)
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <h3 class="text-center text-secondary mt-5 mb-3">Thông tin submit</h3>
            <form method="post" action="" enctype="multipart/form-data" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Mã nhiệm vụ:</label>
                        <input disabled value='<?php echo $data['task_id'] ?>' class="form-control " name="id" id="id" type="text" placeholder="Chưa có mã nhiệm vụ">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Mã submit</label>
                        <input disabled value='<?php echo $data['submit_id'] ?>' class="form-control" name="department" id="department" type="text" placeholder="Chưa có phòng ban">
                    </div>
                </div>
                <div class="form-group">
                    <label>Ngày nộp</label>
                    <input disabled value="<?php echo $data['submit_date'] ?>" class="form-control" name="startDay" id="startDay" type="text" placeholder="Ngày giao">
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea disabled class="form-control" name="detail" id="detail" cols="20" rows="10" style="height:100px" placeholder="Mô tả về nhiệm vụ"><?php echo $data['deatail'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="">File đính kèm của nhân viên: <a href="../file/<?= $data['tag_file'] ?>" download=""><?= $namefile ?></a></label>
                </div>
                <div class="form-group">
                    <label>Phản hồi</label>
                    <textarea disabled class="form-control" name="detail" id="detail" cols="20" rows="10" style="height:100px" placeholder="Mô tả về nhiệm vụ"><?php echo $data['detail_response'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="">File yêu cầu đính kèm: <a href="../file/<?= $data['tag_file_response'] ?>"><?= $namefile1 ?></a></label>
                </div>

                <div class="form-group text-center">
                    <div class="form-group">
                        <p class="text-center" style="margin:15px">
                            <a href="submitlist.php?id=<?= $data['task_id'] ?>" class="btn btn-success px-5 h-5">Return</a></span>
                        </p>
                    </div>
            </form>
        </div>
    </div>
</div>