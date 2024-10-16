<?php
// Xóa cache của trình duyệt
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); // Ngày hết hạn trong quá khứ
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Ngày sửa đổi cuối cùng (hiện tại)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // Không lưu trữ bộ nhớ đệm
header("Cache-Control: post-check=0, pre-check=0", false); // Bổ sung kiểm tra cache
header("Pragma: no-cache"); // Hỗ trợ cho các trình duyệt cũ
?>
