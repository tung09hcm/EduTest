<?php
echo "upload.php";
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
    $post = [
        'username' => $_SESSION["username"],
        'name' => $_SESSION["name"],
        'content' => $content,
        'image' => $imagePath,
        'time' => $currentTime,
    ];
    $_SESSION["content"] = $content;
    $posts = [];
    if (file_exists('posts.json')) {
        $posts = json_decode(file_get_contents('posts.json'), true);
    }
    $posts[] = $post;
    file_put_contents('posts.json', json_encode($posts, JSON_PRETTY_PRINT));
    
    
    
    session_start();
    include("../include/database.php");
        
    $sql = "INSERT INTO post (username, name, content, date_and_time, image_path, react, comment, bookmark, share) 
    VALUES (?, ?, ?, ?, ?, 0, 0, 0, 0)"; // Sử dụng placeholder cho câu lệnh    

    try {
        $stmt = $conn->prepare($sql); // Chuẩn bị câu lệnh
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Gán giá trị cho placeholder
        $stmt->bind_param("sssss", $_SESSION["username"], $_SESSION["name"], 
                            $content, $currentTime, $imagePath); 

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        echo "Thêm nội dung vào post thành công."; // Thông báo thành công
    } catch (Exception $e) {
        echo "Không thể thêm nội dung vào post: " . $e->getMessage(); // In ra lỗi
    }

    $conn->close();
    $debug = [
        'username' => $_SESSION["username"],
        'name' => $_SESSION["name"],
        'content' => $content,
        'image' => $imagePath,
        'time' => $currentTime,
    ];
    $_SESSION["content"] = $content;
    $debugs = [];
    // ghi thêm vào file debugs.json
    // if (file_exists('debugs.json')) {
    //     $debugs = json_decode(file_get_contents('debugs.json'), true);
    // }
    $debugs[] = $debug;
    file_put_contents('debugs.json', json_encode($debugs, JSON_PRETTY_PRINT));

}

?>
