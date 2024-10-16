<?php
// Kết nối với database
include 'database.php'; // File này chứa kết nối đến CSDL

// Nhận dữ liệu từ yêu cầu POST
$data = json_decode(file_get_contents("php://input"), true);
$index = isset($data['index']) ? intval($data['index']) : null; // Đảm bảo index là số nguyên
$type = isset($data['type']) ? $data['type'] : null;   // Loại tương tác (heart, comment, bookmark, share)
$action = isset($data['increase']) ? boolval($data['increase']) : null; // Chuyển về kiểu boolean

// Kiểm tra các giá trị hợp lệ
if ($index === null || $type === null || $action === null) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit();
}

// Đọc nội dung file JSON
session_start();
$filename = $_SESSION["id"] . ".json";
$jsonData = file_get_contents($filename);
$posts = json_decode($jsonData, true); // Giải mã nội dung file JSON thành mảng

// Kiểm tra nếu index nằm trong phạm vi
if ($index < 0 || $index >= count($posts)) {
    echo json_encode(['success' => false, 'message' => 'Index không hợp lệ']);
    exit();
}

// Lấy ID thực của bài viết từ file JSON
$post = $posts[$index]; // Lấy bài viết theo index
$postId = $post['id']; // Lấy ID của bài viết

// Chuyển đổi loại tương tác thành cột trong CSDL
$columns = [
    'heart' => 'react',
    'comment' => 'comment',
    'bookmark' => 'bookmark',
    'share' => 'share'
];

$column = isset($columns[$type]) ? $columns[$type] : null;

if ($column) {
    // Tạo truy vấn SQL
    if ($action) {
        // Tăng giá trị cột
        $sql = "UPDATE post SET $column = $column + 1 WHERE id = ?";
    } else {
        // Giảm giá trị cột và đảm bảo không giảm xuống dưới 0
        $sql = "UPDATE post SET $column = GREATEST($column - 1, 0) WHERE id = ?";
    }

    // Chuẩn bị và thực hiện truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $postId); // Sử dụng ID bài viết (kiểu string)

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Loại tương tác không hợp lệ']);
}

$conn->close();
?>
