<?php
session_start();

// Tạo một mảng chứa các giá trị
$user_data = [
    'username' => $_SESSION["username"],
    'name' => $_SESSION["name"],
    'id' => $_SESSION["id"],
    'email' => $_SESSION["email"],
    'file_path' => $_SESSION["file_path"]
];

// Trả về JSON hợp lệ
echo json_encode($user_data);
?>
