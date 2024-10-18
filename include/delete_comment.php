<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include("../include/database.php");
    // Lấy dữ liệu JSON từ request body
    $data = json_decode(file_get_contents('php://input'), true);
    $indexToDelete = $data['index'];  // Chỉ số bài viết cần xóa
    $parent_post_id = $data['parent_post_id'];

    $sql = "UPDATE post SET comment = GREATEST(comment - 1, 0) WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s",$parent_post_id ); 
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $conn->close();

    
    session_start();
    $file = $_SESSION["id"] . "_comment.json";
    // Đọc file JSON chứa các bài viết
    if (file_exists($file)) {
        $posts = json_decode(file_get_contents($file), true);

        // Xóa bài viết theo chỉ số
        if (isset($posts[$indexToDelete])) {


            if($_SESSION["username"] == $posts[$indexToDelete]['username'])
            {
                include 'database.php';
                $sql = "DELETE FROM post WHERE ID = ?";
                try {
                    $stmt = $conn->prepare($sql); // Chuẩn bị câu lệnh
                    if (!$stmt) {
                        throw new Exception("Prepare failed: " . $conn->error);
                    }
        
                    // Gán giá trị cho placeholder
                    $stmt->bind_param("s", $posts[$indexToDelete]['id']); 
        
                    if (!$stmt->execute()) {
                        throw new Exception("Execute failed: " . $stmt->error);
                    }
                    
                    echo "Thêm nội dung vào post thành công."; // Thông báo thành công
                } catch (Exception $e) {
                    echo "Không thể thêm nội dung vào post: " . $e->getMessage(); // In ra lỗi
                }
            }


            array_splice($posts, $indexToDelete, 1);
            // Lưu lại danh sách bài viết sau khi xóa
            file_put_contents($file, json_encode($posts));
            echo "Bài viết đã được xóa.";
        } else {
            echo "Bài viết không tồn tại.";
        }
    } else {
        echo "Không tìm thấy file .json.";
    }




}
?>
