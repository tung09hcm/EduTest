<?php
  session_start();
  include("../include/database.php");

  if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      // Người dùng đã đăng nhập
      header("Location: ../pages/homepage.php");
      exit();
  }
  else if (isset($_POST["register"])) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $targetDir = "../assets/images/user_avatar/";

      // Tạo mã ID hash duy nhất cho tệp tin
      $uniqueId = substr(uniqid(), -8);; // Tạo một ID duy nhất dựa trên thời gian hiện tại
      $imagePath = $targetDir . $uniqueId . '.png'; // Tạo đường dẫn tệp tin với ID

      // Di chuyển tệp đã tải lên đến thư mục đích với tên mới
      move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
      $_SESSION["file_path"] = $imagePath;
    }
    else {
      echo "<script>alert('signal');</script>";
    }
  
    // $_SESSION["password"] = $_POST["password"];
    $sql = "INSERT INTO user (username, name, email, password, file_path) 
            VALUES ('" . $_SESSION["username"] . "', 
                    '" . $_SESSION["name"] . "', 
                    '" . $_SESSION["email"] . "', 
                    '" . $_SESSION["password"] . "', 
                    '" . $imagePath . "')";

    try{
      mysqli_query($conn, $sql);
      // $_SESSION["login"] = true;
      // $updateStmt = $conn->prepare("UPDATE user SET online = 1 WHERE username = ?");
      // $updateStmt->bind_param("s", $_POST["username"]);
      // $updateStmt->execute();
      // $updateStmt->close();
    }
    catch(mysqli_sql_exception)
    {
      echo " cant register !!!";
    }
    $conn->close();



    // Chuyển hướng tới login.php sau khi đăng nhập thành công
    header("Location: ../pages/login.php");
    exit(); // Đảm bảo rằng không có mã nào được thực thi sau chuyển hướng
  }
  else if (isset($_POST["login"])) {
    $_SESSION["username"] = $_POST["username_login"];
    $_SESSION["password"] = $_POST["password_login"];

    // Lấy username và password từ session
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    // Sử dụng prepared statement để truy vấn username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy dòng kết quả
        $row = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu bằng password_verify
        if (password_verify($password, $row['password']) && $row['online'] == 0) {
            // Mật khẩu đúng, lưu thông tin vào session
            $_SESSION["username"] = $username;
            $_SESSION["name"] = $row['name'];
            $_SESSION["id"] = $row['id'];
            $_SESSION["email"] = $row['email'];
            $_SESSION["file_path"] = $row['file_path'];
            $_SESSION["login"] = true;

            $updateStmt = $conn->prepare("UPDATE user SET online = 1 WHERE username = ?");
            $updateStmt->bind_param("s", $username);
            $updateStmt->execute();
            $updateStmt->close();

            // Chuyển hướng tới trang chính
            header("Location: ../pages/homepage.php");
            exit();
        } else {
            // Mật khẩu sai, lưu thông báo vào session
            $_SESSION["login_error"] = "Tên đăng nhập hoặc mật khẩu không chính xác!";
            header("Location: ../pages/login.php"); // Quay lại trang đăng nhập
            exit();
            // echo '<script>alert("sai mật khẩu");</script>';
        }
    } else {
        // Mật khẩu sai, lưu thông báo vào session
        $_SESSION["login_error"] = "Tên đăng nhập hoặc mật khẩu không chính xác!";
        header("Location: ../pages/login.php"); // Quay lại trang đăng nhập
        exit();
    }




    // Đóng kết nối
    $stmt->close();
    $conn->close();

    
  }



?>