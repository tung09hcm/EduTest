<?php

include("../include/database.php");
session_start();
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$filename = $_SESSION["id"] . ".json";
if (file_exists($filename)) {
    unlink($filename); // Xóa file
}
// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT post_id
        FROM post_action 
        WHERE user_id = " . $_SESSION["id"] . " AND type_action = 'react'";


$result = $conn->query($sql);

$posts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Khởi tạo biến action mặc định
        $react_action = 0;
        $bookmark_action = 0;
        // Chuẩn bị câu truy vấn với prepared statement
        $sql_post_table = "SELECT * FROM post WHERE ID = ?";
        $stmt = $conn->prepare($sql_post_table);
        $stmt->bind_param("s", $row['post_id']); // Sử dụng prepared statement để tránh SQL injection
        $stmt->execute();
        $post_result = $stmt->get_result();
        // Chuẩn bị câu truy vấn với prepared statement
        $sql_action_table = "SELECT * FROM post_action WHERE post_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql_action_table);
        $stmt->bind_param("si", $row['post_id'], $_SESSION["id"]); // Sử dụng prepared statement để tránh SQL injection
        $stmt->execute();
        $action_result = $stmt->get_result();
        while($action_result_row = $action_result->fetch_assoc()) {
            if($action_result_row['type_action'] == "react") {
                $react_action = 1;
            }
            if($action_result_row['type_action'] == "bookmark") {
                $bookmark_action = 1;
            }
        }

        // Duyệt qua kết quả của bảng post_action
        while($post_result_row = $post_result->fetch_assoc()) {

            // Xây dựng mảng post
            $post = [
                'id' => $post_result_row['ID'],
                'username' => $post_result_row['username'],
                'name' => $post_result_row['name'],
                'user_img_path' => $post_result_row['user_img_path'],
                'content' => $post_result_row['content'],
                'image' => $post_result_row['image_path'],
                'time' => $post_result_row['date_and_time'],
                'react' => $post_result_row['react'],
                'comment' => $post_result_row['comment'],
                'bookmark' => $post_result_row['bookmark'],
                'share' => $post_result_row['share'],
                'react_action' => $react_action,
                'bookmark_action' => $bookmark_action,
            ];
            // Thêm bài viết vào mảng
            $posts[] = $post;

        }
        // Đóng prepared statement
        $stmt->close();

        
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
