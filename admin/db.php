<?php

#  https://www.w3schools.com/php/php_mysql_select.asp

define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('db', 'dbagm');

// $host = 'localhost'; // tên mysql server
// $user = 'root';
// $pass = '';
// $db = 'dbagm'; // tên databse

function open_database()
{
    $conn = new mysqli(host, user, pass, db);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die('Không thể kết nối database: ' . $conn->connect_error);
    }

    return $conn;
}

// echo "Kết nối thành công tới database<br><br>";

// $sql = "SELECT * from account";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
// 	while($row = $result->fetch_assoc()) 
// 	{
// 		echo json_encode($row);
// 		echo "<br>";
// 	}
// }
// else {
// 	echo "Bảng chưa có dữ liệu";
// }

// // Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên
// echo "<br><img src='/images/tdt-logo.png' />";
// echo "<p>Đây là ảnh mẫu, lấy từ thư mục images tại web root.</p>";

function login($user, $pass)
{
    $sql = 'select * from account where username = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute the query');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'user does not exist');
    }

    $data = $result->fetch_assoc();
    // print_r($data);

    $hashed_password = $data['hash_password'];


    if (!password_verify($pass, $hashed_password)) {
        return array('code' => 3, 'error' => 'invalid password');
    }

    if (password_verify($user, $hashed_password)) {
        return array('code' => 100, 'error' => 'reset pass word', 'data' => $data);
    }

    return array('code' => 0, 'error' => '', 'data' => $data);
}


function getEmployee()
{
    $sql = 'select * from account where possition <> "admin"';
    $conn = open_database();


    $result = $conn->query($sql);

    $output = array();

    while (($row = $result->fetch_assoc())) {
        $output[] = $row;
    }
    return $output;
}

function getEmployeeByID($id)
{
    $sql = 'select * from account where username = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);

    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }


    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return $result->fetch_assoc();
}
function updatePassword($username, $password)
{
    $sql = 'update account set hash_password = ? where username = ?';
    $conn = open_database();

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $hash, $username);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {

        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'message' => 'Update successful');
}

function addEmployee($username, $fullname, $hashed_password, $possition, $department, $avatar,$id,$phone,$gender,$birthday,$workday,$address)
{
    $sql = 'insert into account(username, fullname, hash_password, possition, department, avatar, id, phone, gender, birthday, workday, address) values(?,?,?,?,?,?,?,?,?,?,?,?)';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $hash = password_hash($hashed_password, PASSWORD_DEFAULT);
    $stm->bind_param('ssssssssssss', $username, $fullname, $hash, $possition, $department, $avatar,$id,$phone,$gender,$birthday,$workday,$address);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'message' => 'Create successful');
}


function get_departments()
{
    $sql = 'select * from department';
    $conn = open_database();

    $stm = $conn->prepare($sql);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'data' => $result);
}

function get_department($id)
{
    $sql = 'select * from department where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return $result->fetch_assoc();
}

function get_user()
{
    $sql = 'select * from account where possition <> "admin"';
    $conn = open_database();

    $stm = $conn->prepare($sql);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'data' => $result);
}

//dangtrinh
function update_avatar($username, $avatar)
{
    $sql = 'update account set avatar = ? where username = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $avatar, $username);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'error' => 'Update successful');
}

function add_department($id, $name, $room, $detail)
{
    $sql = 'insert into department(id, name, room, detail) values(?,?,?,?)';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ssss', $id, $name, $room, $detail);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'error' => 'Create successful');
}

function get_users($id)
{
    $sql = 'select * from account where username = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return $result->fetch_assoc();
}

function update_department($id, $name, $room, $detail)
{
    $sql = 'update department set name = ?, room = ?, detail = ? where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ssss', $name, $room, $detail, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'error' => 'Update successful');
}

function delete_department($id)
{
    $sql = 'delete from department where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'error' => 'Delete successful');
}

function addTask($accountID, $deadline, $departmentID, $detail, $id, $startDay, $status, $tagFile, $title)
{
    $sql = 'INSERT INTO task(id, title, detail, start_day, deadline, account_id, status, tag_file, department_id) VALUES (?,?,?,?,?,?,?,?,?)';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('sssssssss', $id, $title, $detail, $startDay, $deadline, $accountID, $status, $tagFile, $departmentID);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {

        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'message' => 'Create successful');
}


function getEmployeebyDepartment($departmentID)
{
    $sql = 'select * from account where department = ? and possition <> "leader"';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $departmentID);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }



    return array('code' => 0, 'data' => $result);
}

function get_department_user($id)
{
    $sql = 'select department from account where username = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return $result->fetch_assoc()['department'];
}

function get_task_department($id)
{
    $sql = "select * from task where department_id = ?  ORDER BY start_day DESC";
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 3, 'data' => $result);
}

function get_dayoff_department($id, $user)
{
    $sql = "select * from day_off where department_id = ? and employeeId <> ? ORDER BY date_request DESC";
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $id, $user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}

function get_dayoff_leader()
{
    $sql = 'select day_off.* from day_off inner join account on employeeId = username and possition = "leader" ORDER BY date_request DESC';
    $conn = open_database();

    $stm = $conn->prepare($sql);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'data' => $result);
}

function get_task_id($id)
{
    $sql = 'select * from task where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return $result->fetch_assoc();
}

function update_task_status($id, $status)
{
    $sql = 'update task set status = ? where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $status, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'error' => 'Update successful');
}

function get_department_leader($departmentID)
{
    $sql = 'select * from account where department = ? and possition = "leader"';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $departmentID);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'data' => $result);
}

function update_manager($id, $departmentID)
{
    $sql = 'update account set possition = "leader" where username = ? and department = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $id, $departmentID);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'error' => 'Update successful');
}

function down_manager($id, $departmentID)
{
    $sql = 'update account set possition = "employee" where username = ? and department = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $id, $departmentID);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'error' => 'Update successful');
}

function sum_dayoff($id)
{
    $sql = 'select sum(convert(num_day_off, int)) as "sumd" from day_off where employeeId = ?';

    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }


    return $result->fetch_assoc();
}

function get_dayoff_request($id)
{
    $sql = 'select * from day_off where employeeId = ? ORDER BY date_request DESC';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'data' => $result);
}

function add_request_dayoff($id, $employeeId, $current_date, $day_start, $reason, $result, $departId, $day_off_request, $tag_file)
{
    $sql = 'INSERT INTO day_off(id, employeeId,date_request, day_start, reason, result, department_id, day_off_request, tag_file) VALUES (?,?,?,?,?,?,?,?,?)';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('sssssssss', $id, $employeeId, $current_date, $day_start, $reason, $result, $departId, $day_off_request, $tag_file);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {

        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'message' => 'Create successful');
}

function submit_task($id, $taskid, $date, $file, $detail, $status)
{
    $sql = 'INSERT INTO submit(submit_id, task_id, submit_date, tag_file, deatail, status) VALUES (?,?,?,?,?,?)';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ssssss', $id, $taskid, $date, $file, $detail, $status);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    if ($stm->affected_rows == 0) {

        return array('code' => 2, 'error' => 'An error occured');
    }

    return array('code' => 0, 'message' => 'Create successful');
}

function get_user_task($id, $user)
{
    $sql = 'select * from task where department_id = ? and account_id = ? and status <> "Canceled" ORDER BY start_day DESC';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $id, $user);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 3, 'data' => $result);
}

function update_status_dayoff($status, $id, $date)
{
    $sql = 'update day_off set result = ?, day_off_response = ? where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('sss', $status, $date, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}

function get_current_dayoff($id)
{
    $sql = 'SELECT * FROM `day_off` where employeeId = ? ORDER BY date_request DESC';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return $result->fetch_assoc();
}

function get_detail_dayoff($id)
{
    $sql = 'SELECT * FROM `day_off` where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return $result->fetch_assoc();
}

function update_num_dayoff($id, $num)
{
    $sql = 'update day_off set num_day_off = ? where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $num, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}

function get_submit_task($id)
{
    $sql = 'select * from submit where task_id = ? ORDER BY submit_date DESC';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}


function update_task_complete($id, $review)
{
    $sql = 'update task set review = ?, status = "Completed" where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $review, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}

function update_status_submit($id, $status)
{
    $sql = 'update submit set status = ? where submit_id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $status, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}

function update_task_process($id, $proc)
{
    $sql = 'update task set process = ? where id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $proc, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}

function update_deadline($id, $date)
{
    $sql = "update task set deadline = ? where id = ?";
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('ss', $date, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    return array('code' => 0, 'error' => 'Update successful');
}

function update_response_submit($tag_file, $detail, $id)
{
    $sql = 'update submit set tag_file_response = ?, detail_response = ? where submit_id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('sss', $tag_file, $detail, $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'error' => 'Update successful');
}

function get_submit($id)
{
    $sql = 'select * from submit where submit_id = ?';
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $id);

    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'Can not execute command');
    }

    $result = $stm->get_result();
    if ($result->num_rows == 0) {
        return array('code' => 2, 'error' => 'ID not exist');
    }

    return array('code' => 0, 'data' => $result);
}
