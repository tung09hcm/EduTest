<?php

include("../include/database.php");
session_start();
$data = json_decode(file_get_contents("php://input"), true);
$postid = isset($data['id']) ? ($data['id']) : null;
$filename = $postid . ".json";
if (file_exists($filename)) {
    unlink($filename); // Xóa file
}


// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT * 
        FROM post 
        WHERE ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $postid);  // Sử dụng prepared statement để tránh SQL injection
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();




if ($result === false) {
    // Xử lý lỗi nếu truy vấn thất bại
    echo json_encode(['error' => 'Failed to fetch post data']);
    exit();
}



if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Khởi tạo biến action mặc định
        $react_action = 0;
        $bookmark_action = 0;

        // Chuẩn bị câu truy vấn với prepared statement
        $sql_action_table = "SELECT * FROM post_action WHERE post_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql_action_table);
        $stmt->bind_param("ss", $postid, $_SESSION["id"]); // Sử dụng prepared statement để tránh SQL injection
        $stmt->execute();
        $action_result = $stmt->get_result();

        // Duyệt qua kết quả của bảng post_action
        while($action_result_row = $action_result->fetch_assoc()) {
            if($action_result_row['type_action'] == "react") {
                $react_action = 1;
            }
            if($action_result_row['type_action'] == "bookmark") {
                $bookmark_action = 1;
            }
        }

        // Đóng prepared statement
        $stmt->close();

        // Xây dựng mảng post
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
            'react_action' => $react_action,
            'bookmark_action' => $bookmark_action,
        ];
        if (!empty($post)) {
            file_put_contents($filename, json_encode($post, JSON_PRETTY_PRINT));
        }

    }
}


// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($post);

$conn->close();
?>
