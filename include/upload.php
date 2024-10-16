<?php
session_start();
echo "upload.php";
echo "\nuser id: " . $_SESSION["id"] . "\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    
    $content = trim($content); // Xóa khoảng trắng thừa ở đầu và cuối
    $imagePath = '';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $currentTime = date("g:i A - M j, Y");
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";

        // Tạo mã ID hash duy nhất cho tệp tin
        $uniqueId = uniqid(); // Tạo một ID duy nhất dựa trên thời gian hiện tại
        $imagePath = $targetDir . $uniqueId . '.png'; // Tạo đường dẫn tệp tin với ID
        $_SESSION["imagePath"] = $imagePath;
        // Di chuyển tệp đã tải lên đến thư mục đích với tên mới
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Lưu bài viết vào file JSON
    // react, comment, bookmark, share
    $post_Id = uniqid();
    $post = [
        'id' => $post_Id,
        'username' => $_SESSION["username"],
        'name' => $_SESSION["name"],
        'user_img_path' => $_SESSION["file_path"],
        'content' => $content,
        'image' => $imagePath,
        'time' => $currentTime,
        'react' => 0,
        'comment' => 0,
        'bookmark' => 0,
        'share' => 0,
        'react_action' => 0,
        'bookmark_action' => 0,
    ];
    $_SESSION["content"] = $content;
    $filename = $_SESSION["id"] . ".json";

    $_SESSION["content_filename"] = $filename;
    $posts = [];
    if (file_exists($filename)) {
        $posts = json_decode(file_get_contents($filename), true);
    }
    $posts[] = $post;
    file_put_contents($filename, json_encode($posts, JSON_PRETTY_PRINT));
    
    
    
    
    include("../include/database.php");
        
    $sql = "INSERT INTO post (id, username, name, content, date_and_time, image_path,user_img_path,react, comment, bookmark, share) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 0, 0, 0, 0)"; // Sử dụng placeholder cho câu lệnh    

    try {
        $stmt = $conn->prepare($sql); // Chuẩn bị câu lệnh
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Gán giá trị cho placeholder
        $stmt->bind_param("sssssss", $post_Id, $_SESSION["username"], $_SESSION["name"], 
                            $content, $currentTime, $imagePath, $_SESSION["file_path"]); 

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        echo "Thêm nội dung vào post thành công."; // Thông báo thành công
    } catch (Exception $e) {
        echo "Không thể thêm nội dung vào post: " . $e->getMessage(); // In ra lỗi
    }

    $conn->close();

}

?>
