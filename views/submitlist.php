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
    require_once('../admin/db.php');
    
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = get_task_id($id);
    if ($data['id'] != $id  || $id === ""){
        header('Location: unknown.php');
    }
}


    $user_id = $_SESSION['user'];
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $data = get_submit_task($id);
    }
    else {
        header('Location: ../views/unknown.php');
        exit();
    }

?>




    <div class="container">
        <h2 class="text-center" style="margin:30px 30px 30px 30px">Danh sách phản hồi</h2>
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Tên nhiệm vụ</th>
                <th>Ngày nộp</th>
                <th>Trạng thái</th>
                <th>Ghi chú</th>
                <th>Chi tiết</th>
            </tr>
            <tbody>
                <?php
                if ($data['code'] == 0) {
                    while ($row = $data['data']->fetch_assoc()) {
                        $task = get_task_id($row['task_id']);
                       
                ?>

                        <tr>
                            <td><?= $row['task_id'] ?></td>
                            <td><?= $task['title'] ?></td>
                            <td><?= $row['submit_date'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <?= $row['detail_response'] ?>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="../views/detail_submit.php?id=<?= $row['submit_id'] ?>">Xem chi tiết</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Chưa có dữ liệu</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

