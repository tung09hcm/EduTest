<?php

include("../include/database.php");
session_start();
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$filename = $_SESSION["id"] . ".json";
// // ================================================== //
// echo "\n";
// if(isset($data['offset'])) 
// {
//     echo "\n data['offset']: " . $data['offset'] . "\n";
// }
// else echo "data['offset'] is null" . "\n";
// if(isset($data['limit'])) 
// {
//     echo "\n data['limit']: " . $data['limit'] . "\n";
// }
// else echo "data['limit'] is null" . "\n";
// // ================================================== //

// // Cập nhật giá trị offset và limit trong session
// if (isset($data['offset']) && isset($data['limit'])) {
//     $_SESSION['offset'] = $data['offset'];
//     $_SESSION['limit'] = $data['limit'];
// }

// echo "\n";
// if(isset($_SESSION['offset'])) 
// {
//     echo "\n offset: " . $_SESSION['offset'] . "\n";
// }
// else echo "offset is null" . "\n";
// if(isset($_SESSION['limit'])) 
// {
//     echo "\n limit: " . $_SESSION['limit'] . "\n";
// }
// else echo "limit is null" . "\n";

// // Lấy giá trị offset và limit từ session (hoặc mặc định)
// $offset = isset($_SESSION['offset']) ? $_SESSION['offset'] : 0;
// $limit = isset($_SESSION['limit']) ? $_SESSION['limit'] : 5;

// echo "\n";
// echo "Limit: " . $limit . "\n";
// echo "Offset: " . $offset . "\n";


// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT ID, username, name, content, image_path, date_and_time, user_img_path, react, comment, bookmark, share 
        FROM post 
        ORDER BY RAND() "; 

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
