<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
include_once "../views/navbar_employee.php";
require_once('../admin/db.php');

if (($_SESSION['possition'] != "employee") && ($_SESSION['possition'] != "leader")) {
    header('Location: unknown.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = get_task_id($id);
    if ($data['id'] != $id  || $id === ""){
        header('Location: unknown.php');
    }


    if ($data['tag_file'] == "" || is_null($data['tag_file'])) {
        $namefile = '';
    } else {
        $file = explode("/", $data['tag_file']);
        if (isset($file['2'])) {
            $namefile = $file['2'];
        }
    }

    if ($data['status'] != "In progress") {
        $dataTmp = get_submit_task($id);
        $data1 = $dataTmp['data']->fetch_assoc();

        if ($data1['tag_file_response'] == "" || is_null($data1['tag_file_response'])) {
            $namefile1 = '';
        } else {
            $file1 = explode("/", $data1['tag_file_response']);
            if (isset($file1['2'])) {
                $namefile1 = $file1['2'];
            }
        }

        if ($data1['tag_file'] == "" || is_null($data1['tag_file'])) {
            $namefile2 = '';
        } else {
            $file2 = explode("/", $data1['tag_file']);
            if (isset($file2['2'])) {
                $namefile2 = $file2['2'];
            }
        }
    }
} else {
    header('Location: unknown.php');
    exit();
}

$submitId = uniqid();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$error = '';
$dateSubmit = date('Y-m-d\TH:i');
$proc = '';

if (isset($_POST['detail'])) {
    $detail = $_POST['detail'];
    $id = $data['id'];

    
    if ($dateSubmit > $data['deadline']) {
        $proc = "Hoàn thành trễ hạn";
    } else {
        $proc = "Hoàn thành đúng hạn";
    }

    if (empty($detail)) {
        $error = "Hãy nhập mô tả";
    } else if (empty($id)) {
        $error = "Không lấy được id task";
    } else if (empty($submitId)) {
        $error = "Không lấy được id submit";
    } else {
        $file = $_FILES['file'];
        $fileName = $file["name"];
        if ($fileName == null) {
            $target_file = "";
        } else {
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

                    $result = submit_task($submitId, $id, $dateSubmit, $target_file, $detail, "Waiting");
                    $result1 = update_task_status($id, "Waiting");
                    $result2 = update_task_process($id, $proc);

                    if ($result['code'] == 0 && $result1['code'] == 0) {
                        header('Location: ../views/employee_index.php');
                        exit();
                    }
                }    
        }

    }
}


?>

    <div class="container">
        <!-- <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8"> -->
        <!-- <h2 class="text-center text-dark mt-2 mb-3">Nhiệm vụ</h2> -->
        <form action="" enctype="multipart/form-data" method="post" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <h2 class="text-center text-dark mt-2 mb-3">Chi tiết nhiệm vụ</h2>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Ngày giao</label>
                            <input type="text" name="ngaygiao" id="ngaygiao" value="<?= $data['start_day'] ?>" class="form-control" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id">Hạn chót</label>
                            <input type="text" name="hanchot" id="hanchot" value="<?= $data['deadline'] ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Trạng thái</label>
                            <input type="text" name="status" id="status" value="<?= $data['status'] ?>" class="form-control" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Tên nhiệm vụ</label>
                            <input type="text" name="taskName" id="taskname" value="<?php echo $data['title'] ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">File đính kèm: <a href="<?php echo $data['tag_file'] ?>" download><?= $namefile ?></a></label>
                    </div>
                    <div class="form-group">
                        <label for="user">Thông tin chi tiết:</label>
                        <br>
                        <p class="text-center"> <textarea wrap="hard" disabled name="" id="" cols="55" rows="5"><?= $data['detail'] ?></textarea></p>
                    </div>
                    <?php
                    if ($data['status'] == "Rejected") {
                    ?>
                        <div class="form-group">
                            <label for="">Ghi chú của trưởng phòng</label>
                            <br>
                            <p class="text-center"><textarea name="reason" id="reason" cols="55" rows="5" disabled><?= $data1['detail_response'] ?></textarea></p>
                        </div>
                        <div class="form-group">
                            <label for="">File đính kèm thêm: <a href="../file/<?= $data1['tag_file_response'] ?>" download><?= $namefile1 ?></a></label>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="col-lg-6 col-md-8">
                    <h2 class="text-center text-dark mt-2 mb-3">Thông tin submit</h2>
                    <?php
                    if ($data['status'] != "In progess") {
                    ?>
                        <div class="form-group">
                            <label for="">Tiến độ hoàn thành</label>
                            <input type="text" name="status" id="status" value="<?= $data['process'] ?>" class="form-control" disabled>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <a href="../views/submitlist.php?id=<?= $data['id'] ?>">
                            <p>Lịch sử phản hồi nhiệm vụ</p>
                        </a>
                    </div>
                    <?php 
                        if ($data['status'] == "Completed") {
                            ?>
                                <div class="form-group">
                                    <label for="">Mức độ hoàn thành</label>
                                    <input type="text" name="" id="" value="<?= $data['review'] ?>" class="form-control" disabled>
                                </div>
                            <?php
                        }
                    ?>
                    <div class="form-group">
                        <label for="">Mô tả thông tin:</label>
                        <br>
                        <?php
                        if ($data['status'] != "In progress") {
                        ?>
                            <p class="text-center"> <textarea name="detail" id="detail" cols="55" rows="5"><?= $data1['deatail'] ?></textarea></p>
                        <?php
                        } else {
                        ?>
                            <p class="text-center"> <textarea name="detail" id="detail" cols="55" rows="5"></textarea></p>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if ($data['status'] != "In progress") {
                    ?>
                        <div class="form-group">
                            <label for="">File đã nộp trước đó: <a href="../file/<?= $data1['tag_file'] ?>" download><?= $namefile2 ?></a></label>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($data['status'] != "Completed" && $data['status'] != "Waiting") {
                    ?>
                        <div class="form-group">
                            <label for="">Thêm tệp đính kèm</label>
                            <br>
                            <input required type='file' id="file" name="file" />
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-group text-center">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>

                        <?php
                        if ($data['status'] == "Waiting" || $data['status'] == "Completed") {
                        ?>
                            <a href="../views/employee_index.php" class="btn btn-success px-5 h-5">Return</a>
                        <?php
                        } else {
                        ?>
                            <button type="submit" class="btn btn-success px-5 h-5">Submit</button>
                            <a href="../views/employee_index.php" class="btn btn-danger px-5 h-5">Return</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>
   
    </div>
 