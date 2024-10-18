<?php

include("../include/database.php");
session_start();
$json = file_get_contents('php://input');
$data = json_decode(file_get_contents("php://input"), true);
$parent_post_id = isset($data['id']) ? ($data['id']) : null;
$filename = $_SESSION["id"] . "_comment.json";

///////////////////////////////////////////////////////////////////
// Tạo một mảng để lưu dữ liệu cần debug
$debug_data = array(
    "parent_post_id" => $parent_post_id
);

// Chuyển đổi mảng sang định dạng JSON
$json_data = json_encode($debug_data, JSON_PRETTY_PRINT);

// Ghi dữ liệu JSON vào tệp debug.json
file_put_contents('debug.json', $json_data);
///////////////////////////////////////////////////////////////////
// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT ID, username, name, content, image_path, date_and_time, user_img_path, react, comment, bookmark, share 
        FROM post 
        WHERE parent_post_id = ?";

try {
    $stmt = $conn->prepare($sql); // Chuẩn bị câu lệnh
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Gán giá trị cho placeholder với kiểu dữ liệu số nguyên
    $stmt->bind_param("i", $parent_post_id); // "i" cho kiểu integer

    // Thực thi câu lệnh
    $stmt->execute();

    // Lấy kết quả trả về
    $result = $stmt->get_result();

    $posts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Khởi tạo biến action mặc định
            $react_action = 0;
            $bookmark_action = 0;

            // Chuẩn bị câu truy vấn với prepared statement
            $sql_action_table = "SELECT * FROM post_action WHERE post_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql_action_table);
            $stmt->bind_param("si", $row['ID'], $_SESSION["id"]); // Sử dụng prepared statement để tránh SQL injection
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
            else{
                $debug_data = array(
                    "result" => "none"
                );
                $json_data = json_encode($debug_data, JSON_PRETTY_PRINT);

                // Ghi dữ liệu JSON vào tệp debug.json
                file_put_contents($filename, $json_data);
            }
            // Thêm bài viết vào mảng
            $posts[] = $post;
        }
    }
    else{
        $debug_data = array(
            "result_x" => "first sql query dont have data"
        );
        $json_data = json_encode($debug_data, JSON_PRETTY_PRINT);

        // Ghi dữ liệu JSON vào tệp debug.json
        file_put_contents($filename, $json_data);
    }

    // Ghi dữ liệu vào file JSON (nếu cần)
    if (!empty($posts)) {
        file_put_contents($filename, json_encode($posts, JSON_PRETTY_PRINT));
    }

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($posts);

    $conn->close();
} catch (Exception $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
}






?>
