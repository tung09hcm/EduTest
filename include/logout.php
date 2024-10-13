<?php
session_start();
session_unset();
session_destroy(); // Hủy session

$file = '../include/posts.json';
if (file_exists($file)) {
    unlink($file); // Xóa file
}
header("Location: ../index.php"); // Chuyển hướng đến trang index
exit(); // Dừng thực thi mã sau khi chuyển hướng
?>
