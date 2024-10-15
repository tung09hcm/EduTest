<?php
include("../include/database.php");
session_start();
$filename = $_SESSION["id"] . ".json";
$updateStmt = $conn->prepare("UPDATE user SET online = 0 WHERE username = ?");
$updateStmt->bind_param("s", $_SESSION["username"]);
$updateStmt->execute();
$updateStmt->close();
$conn->close();

session_unset();
session_destroy(); // Hủy session


if (file_exists($filename)) {
    unlink($filename); // Xóa file
}

$file_user = '../pages/debug.json';
if (file_exists($file_user)) {
    unlink($file_user); // Xóa file
}
header("Location: ../index.php"); // Chuyển hướng đến trang index
exit(); // Dừng thực thi mã sau khi chuyển hướng
?>