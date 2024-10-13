<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";

        // Tạo mã ID hash duy nhất cho tệp tin
        $uniqueId = uniqid(); // Tạo một ID duy nhất dựa trên thời gian hiện tại
        $imagePath = $targetDir . $uniqueId . '.png'; // Tạo đường dẫn tệp tin với ID

        // Hoặc bạn có thể tạo một hash bằng cách sử dụng md5 hoặc hash
        $imageHash = md5($uniqueId . time()); // Tạo hash duy nhất bằng cách kết hợp ID với thời gian
        $imagePathWithHash = $targetDir . $imageHash . '.png'; // Tạo đường dẫn tệp tin với hash

        // Di chuyển tệp đã tải lên đến thư mục đích với tên mới
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Lưu bài viết vào file JSON
    $post = [
        'content' => $content,
        'image' => $imagePath,
    ];

    $posts = [];
    if (file_exists('posts.json')) {
        $posts = json_decode(file_get_contents('posts.json'), true);
    }
    $posts[] = $post;
    file_put_contents('posts.json', json_encode($posts));
}

?>
