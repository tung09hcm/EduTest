<?php
session_start(); // Bắt đầu session nếu cần

include("../include/database.php"); // Kết nối đến cơ sở dữ liệu

// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT username, name, content, image_path, date_and_time FROM post"; // Câu lệnh SQL để lấy dữ liệu
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Thêm từng bài viết vào mảng với cấu trúc yêu cầu
        $posts[] = [
            'username' => $row['username'],
            'name' => $row['name'],
            'content' => $row['content'],
            'image' => $row['image_path'],
            'time' => $row['date_and_time'],
        ];
    }
}

// Ghi dữ liệu vào file JSON
file_put_contents('posts.json', json_encode($posts, JSON_PRETTY_PRINT));

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($posts);

$conn->close();
?>
