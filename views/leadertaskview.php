<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['possition'] != "leader") {
    header('Location: unknown.php');
    exit();
}
include_once "../views/navbar_leader.php";
require_once('../admin/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = get_task_id($id);
    if ($data['id'] != $id  || $id === ""){
        header('Location: unknown.php');
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = get_task_id($id);

    if ($data['tag_file'] == "" || is_null($data['tag_file'])) {
        $namefile = '';
    } else {
        $file = explode("/", $data['tag_file']);
        if (isset($file['2'])) {
            $namefile = $file['2'];
        }
    }

    $name = getEmployeeByID($data['account_id'])['fullname'];

    if ($data['status'] != "In progress" && $data['status'] != "New" && $data['status'] != "Canceled") {

        $dataTmp = get_submit_task($id);
        $data1 = $dataTmp['data']->fetch_assoc();

        if ($data1['tag_file'] == "" || is_null($data1['tag_file'])) {
            $namefile1 = '';
        } else {
            $file1 = explode("/", $data1['tag_file']);
            if (isset($file1['2'])) {
                $namefile1 = $file1['2'];
            }
        }
    }
} else {
    header('Location: unknown.php');
    exit();
}

if (isset($_POST['accept'])) {

    $id = $_GET['id'];
    $submitId = $data1['submit_id'];

    $result = update_task_complete($id, $_POST['review']);
    $result1 = update_status_submit($submitId, "Completed");

    header('Location: ../views/leader_index.php');
    exit();
}

if (isset($_POST['canceled'])) {

    $id = $_GET['id'];
    $cancel = update_task_status($id, "Canceled");

    header('Location: ../views/leader_index.php');
    exit();
}

if (isset($_POST['giahan'])) {
    if ($_POST['newdeadline'] < $data['deadline']) {
        $error = "Ngày gia hạn không hợp lệ";
    }
    else {
        update_deadline($_GET['id'], $_POST['newdeadline']);
        $error = "Đã gia hạn thành công";
    }
}

if (isset($_POST['reject'])) {
    $id = $data1['submit_id'];

    $file = $_FILES['file'];
    $fileName = $file["name"];
    
    
    
    if (isset($_POST['reason'])) {

        $detail = $_POST['reason'];

        if (empty($detail)) {
            $error = "Nhập ghi chú";
        }
        else 
        {
            if ($fileName == null) {
                $target_file = "";
                update_status_submit($id, "Rejected");
                update_task_status($_GET['id'], "Rejected");
                update_response_submit($target_file, $detail, $id);
                header("Location: ../views/leader_index.php");
                exit();
                
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
                    update_status_submit($id, "Rejected");
                    update_task_status($_GET['id'], "Rejected");
                    update_response_submit($target_file, $detail, $id);
                    header("Location: ../views/leader_index.php");
                    exit();
                   
                }    
            }
            
        }
    }
}

?>


    <div class="container">

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
                            <label for="">Nhân viên thực hiện</label>
                            <input type="text" name="" id="" value="<?= $name ?>" class="form-control" disabled>
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
                    <div class="form-group">
                        <a href="../views/submitlist.php?id=<?= $data['id'] ?>"><p>Lịch sử phản hồi nhiệm vụ</p></a>
                    </div>
                    <?php
                    if ($data['status'] === "Waiting") {
                    ?>
                        <div class="form-group">
                            <label for="id">Gia hạn</label>
                            <input type="datetime-local" name="newdeadline" id="newdeadline" class="form-control">
                        </div>
                        <div class="form-group">
                            <button name="giahan" value="giahan" class="btn btn-primary px-5 h-5">Extend Deadline</button>
                        </div>
                        <div class="form-group">
                            <label for="">Ghi chú:</label>
                            <br>
                            <p class="text-center"><textarea name="reason" id="reason" cols="55" rows="5"></textarea></p>
                        </div>
                        <div class="form-group">
                            <label for="">File đính kèm thêm</label>
                            <input type='file' id="file" name="file" />
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="col-lg-6 col-md-8">
                    <h2 class="text-center text-dark mt-2 mb-3">Thông tin phản hồi của nhân viên</h2>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Trạng thái</label>
                            <input type="text" name="status" id="status" value="<?= $data['status'] ?>" class="form-control" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Tiến độ hoàn thành</label>
                            <input type="text" name="" id="" value="<?= $data['process'] ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <?php
                    if ($data['status'] != "In progress" && $data['status'] != "New" && $data['status'] != "Canceled") {
                    ?>
                        <div class="form-group">
                            <label for="name">Ngày nộp</label>
                            <input type="text" name="" id="" value="<?= $data1['submit_date'] ?>" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Mô tả thông tin:</label>
                            <br>
                            <p class="text-center"><textarea disabled name="detail" id="detail" cols="55" rows="5"><?= $data1['deatail'] ?></textarea></p>
                        </div>
                        <div class="form-group">
                            <label for="">File đính kèm (Nhân viên nộp): <a href="<?php echo $data1['tag_file'] ?>" download><?= $namefile1 ?></a></label>
                        </div>
                        <div class="form-group">
                            <label>Mức độ hoàn thành</label>
                            <?php
                            if ($data['status'] == "Completed") {
                            ?>
                                <input type="text" name="" id="" value="<?= $data['review'] ?>" class="form-control" disabled>
                            <?php
                            } else {
                            ?>
                                <select class="form-control" name="review" id="review">
                                    <?php
                                    if ($data1['submit_date'] > $data['deadline']) {
                                    ?>
                                        <!-- <option value="GOOD">GOOD</option> -->
                                        <option value="OK">OK</option>
                                        <option value="BAD">BAD</option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="GOOD">GOOD</option>
                                        <option value="OK">OK</option>
                                        <option value="BAD">BAD</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="form-group text-center">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }

                        if ($data['status'] == "In progress" || $data['status'] == "Completed") {
                        ?>
                            <a href="../views/leader_index.php" class="btn btn-success px-5 h-5">Return</a>
                        <?php
                        } else if ($data['status'] == "Canceled" || $data['status'] == "Rejected") {
                        ?>
                            <a href="../views/leader_index.php" class="btn btn-success px-5 h-5">Return</a>
                        <?php
                        } else if ($data['status'] == "New") {
                        ?>
                            <button class="btn btn-danger" name="canceled">Canceled</button>
                            <a href="../views/leader_index.php" class="btn btn-success px-5 h-5">Return</a>
                        <?php
                        } else {
                        ?>
                            <button name="accept" class="btn btn-success px-5 h-5">Accept</button>
                            <button name="reject" value="reject" class="btn btn-danger px-5 h-5">Reject</button>
                            <a href="../views/leader_index.php" class="btn btn-primary px-5 h-5">Return</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>
        <!-- </div> -->
        <!-- </div> -->
    </div>
