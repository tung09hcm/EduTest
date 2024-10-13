<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $response = '';

    // Kiểm tra nếu có tải ảnh lên
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        // Di chuyển file tải lên vào thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $response = "Bài viết của bạn đã được đăng thành công!";
            $response .= "<br> Nội dung: " . htmlspecialchars($content);
            $response .= "<br><img src='$uploadFile' style='max-width:300px;'>";
        } else {
            $response = "Có lỗi xảy ra khi tải lên ảnh.";
        }
    } else {
        if (empty(trim($content))) {
            $response = "Nội dung bài viết không được để trống.";
        } else {
            $response = "Bài viết của bạn đã được đăng thành công!<br>Nội dung: " . htmlspecialchars($content);
        }
    }

    echo $response;
}
