<?php

include("../include/database.php");
session_start();
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$filename = $_SESSION["id"] . ".json";


// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT ID, username, name, content, image_path, date_and_time, user_img_path, react, comment, bookmark, share 
        FROM post 
        ORDER BY RAND() 
        LIMIT 5"; 

$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Thêm từng bài viết vào mảng với cấu trúc yêu cầu
        $post = [
            'id' => $row['ID'],
            'username' => $row['username'],
            'name' => $row['name'],
            'user_img_path' => $row['user_img_path'],
            'content' => $row['content'],
            'image' => $row['image_path'],
            'time' => $row['date_and_time'],
            'react' => $row['react'],
            'comment' => $row['comment'],
            'bookmark' => $row['bookmark'],
            'share' => $row['share'],
        ];
        // Thêm bài viết vào mảng
        $posts[] = $post;
    }
}

// Ghi dữ liệu vào file JSON (nếu cần)
if (!empty($posts)) {
    file_put_contents($filename, json_encode($posts, JSON_PRETTY_PRINT));
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($posts);

$conn->close();
?>
