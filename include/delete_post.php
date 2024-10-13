<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu JSON từ request body
    $data = json_decode(file_get_contents('php://input'), true);
    $indexToDelete = $data['index'];  // Chỉ số bài viết cần xóa

    // Đọc file JSON chứa các bài viết
    if (file_exists('posts.json')) {
        $posts = json_decode(file_get_contents('posts.json'), true);

        // Xóa bài viết theo chỉ số
        if (isset($posts[$indexToDelete])) {
            array_splice($posts, $indexToDelete, 1);
            // Lưu lại danh sách bài viết sau khi xóa
            file_put_contents('posts.json', json_encode($posts));
            echo "Bài viết đã được xóa.";
        } else {
            echo "Bài viết không tồn tại.";
        }
    } else {
        echo "Không tìm thấy file posts.json.";
    }
}
?>
