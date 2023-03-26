<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}

if ($_SESSION['possition'] != "leader") {
    header('Location: unknown.php');
    exit();
}

$user_id = $_SESSION['user'];
include_once "../views/navbar_leader.php";
require_once('../admin/db.php');
$department = get_department_user($_SESSION['user']);
$account = getEmployeebyDepartment($department);
$idtask = uniqid();
$error = '';
date_default_timezone_set('Asia/Ho_Chi_Minh');
$deadline = '';
$startDay = date("Y-m-d\TH:i");

// addTask($accountID, $deadline, $departmentID, $detail, $id, $startDay, $status, $tagFile, $title)
if (isset($_POST['deadline']) && isset($_POST['title']) && isset($_POST['detail']) && isset($_POST['deadline']) && $_POST['accountID']
) {
    
    
    if ( $_FILES["file"]['name'] == "")
    {
        $target_file = '';
        if (empty($_POST['deadline'])) {
            $error = 'Hãy chọn deadline';
        } else if (empty($_POST['title'])) {
            $error = 'Hãy nhập tiêu đề';
        } else if (empty($_POST['detail'])) {
            $error = 'Hãy nhập mô tả';
        } 
        else if($_POST['deadline'] < $startDay) {
            $error = 'Hạn nộp không được bé hơn ngày giao';
        } else {
            $re = addTask(
                $_POST['accountID'],
                $_POST['deadline'],
                $department,
                $_POST['detail'],
                $idtask,
                $startDay,
                "New",
                $target_file,
                $_POST['title']);
            if ($re['code'] == 0) {
                header('Location: ../views/leader_index.php');
            }
        }
        
    } else {
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
        if (empty($_POST['deadline'])) {
            $error = 'Hãy chọn deadline';
        } else if (empty($_POST['title'])) {
            $error = 'Hãy nhập tiêu đề';
        } else if (empty($_POST['detail'])) {
            $error = 'Hãy nhập mô tả';
        } 
        else if($_POST['deadline'] < $startDay) {
            $error = 'Hạn nộp không được bé hơn ngày giao';
        } else {
            if ($allowUpload)
            {
                // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
                {
                    
                    $re = addTask(
                        $_POST['accountID'],
                        $_POST['deadline'],
                        $department,
                        $_POST['detail'],
                        $idtask,
                        $startDay,
                        "New",
                        $target_file,
                        $_POST['title']
                    );
            
                    if ($re['code'] == 0) {
                        header('Location: ../views/leader_index.php');
                    }
                    
                }
                else {
                    $error = 'Lỗi upload File!';
                }
                
            }
        }
        
    }

    

}
?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Thêm nhiệm vụ</h3>
                <form method="post" action="" enctype="multipart/form-data" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Mã nhiệm vụ:</label>
                            <input disabled value='<?php echo $idtask ?>' class="form-control " name="id" id="id" type="text" placeholder="Chưa có mã nhiệm vụ">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Mã phòng ban</label>
                            <input disabled value='<?php echo $department ?>' class="form-control" name="department" id="department" type="text" placeholder="Chưa có phòng ban">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ngày giao</label>
                        <input disabled value="<?php echo $startDay ?>" class="form-control" name="startDay" id="startDay" type="datetime-local" placeholder="Ngày giao">
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <input class="form-control" name="deadline" id="deadline" type="datetime-local" placeholder="Ngày giao">
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="hidden" value="Waiting" name="status" id="status">
                        <input class="form-control" name="title" id="title" type="text" placeholder="Chưa có tiêu đề">
                    </div>
                    <div class="form-group">
                        <label>Nhân viên</label>
                        <select class="form-control" name="accountID" id="accountID">'
                            <?php
                                if ($account['code'] == 0) {
                                    while ($row = $account['data']->fetch_assoc()) {
                                        ?>
                                            <option value='<?php echo $employee = $row["username"] ?>'><?php echo $row['fullname'] ?></option>
                                        <?php
                                        }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" name="detail" id="detail" cols="20" rows="10" style="height:100px" placeholder="Mô tả về nhiệm vụ"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">File đính kèm (nếu có)</label>
                        <input type='file' id="file" name="file" />
                    </div>
                    <div class="form-group text-center">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                        <div class="form-group">
                            <p class="text-center" style="margin:15px">
                                <button type="submit" onclick="submitTask()" class="btn btn-success px-5 h-5">Thêm</button></span>
                                <a href="../views/leader_index.php" class="btn btn-danger px-5 h-5">Huỷ bỏ</a></span>
                            </p>
                        </div>
                </form>
            </div>
        </div>
    </div>
