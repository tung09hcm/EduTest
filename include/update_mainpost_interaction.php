<?php
include 'database.php';
session_start();
// user_id
$user_id = $_SESSION["id"];
// Nhận dữ liệu từ yêu cầu POST
$data = json_decode(file_get_contents("php://input"), true);
$postid = isset($data['id']) ? ($data['id']) : null; // Đảm bảo index là số nguyên
$type = isset($data['type']) ? $data['type'] : null;   // Loại tương tác (heart, comment, bookmark, share)
$action = isset($data['increase']) ? boolval($data['increase']) : null; // Chuyển về kiểu boolean


// Kiểm tra các giá trị hợp lệ
if ($postid === null || $type === null || $action === null) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit();
}



// Chuyển đổi loại tương tác thành cột trong CSDL



// Tạo truy vấn SQL
if ($action) {

    // lưu action vào post_action
    $sql_action_table = "INSERT INTO post_action (post_id, user_id, type_action) VALUES (?,?,?)";
    try {
        $stmt = $conn->prepare($sql_action_table); // Chuẩn bị câu lệnh
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Gán giá trị cho placeholder
        $stmt->bind_param("sss", $postid, $user_id, $type); 

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        echo "Thêm nội dung vào post thành công."; // Thông báo thành công
    } catch (Exception $e) {
        echo "Không thể thêm nội dung vào post: " . $e->getMessage(); // In ra lỗi
    }
    // Tăng giá trị cột
    $sql = "UPDATE post SET $type = $type + 1 WHERE id = ?";
    
} else {

    // TO DO : xóa hàng có action
    $sql_action_table = "DELETE FROM post_action WHERE post_id = ? AND user_id = ? AND type_action = ?";
    try {
        $stmt = $conn->prepare($sql_action_table); // Chuẩn bị câu lệnh
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Gán giá trị cho placeholder
        $stmt->bind_param("sss", $postid, $user_id, $type); 

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        echo "Thêm nội dung vào post thành công."; // Thông báo thành công
    } catch (Exception $e) {
        echo "Không thể thêm nội dung vào post: " . $e->getMessage(); // In ra lỗi
    }

    // Giảm giá trị cột và đảm bảo không giảm xuống dưới 0
    $sql = "UPDATE post SET $type = GREATEST($type - 1, 0) WHERE id = ?";
    
}

// Chuẩn bị và thực hiện truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $postid); // Sử dụng ID bài viết (kiểu string)

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
} else {
    echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
}
$stmt->close();


$conn->close();