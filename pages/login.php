<?php
  session_start();
  include("../include/database.php");

  if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      // Người dùng đã đăng nhập
      header("Location: ./homepage.php");
      exit();
  }
  else if (isset($_POST["register"])) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
    // $_SESSION["password"] = $_POST["password"];
    $sql = "INSERT INTO user (username, name, email, password) 
            VALUES ('" . $_SESSION["username"] . "', 
                    '" . $_SESSION["name"] . "', 
                    '" . $_SESSION["email"] . "', 
                    '" . $_SESSION["password"] . "')";

    try{
      mysqli_query($conn, $sql);
    }
    catch(mysqli_sql_exception)
    {
      echo " cant register !!!";
    }
    $conn->close();
    // Chuyển hướng tới homepage.php sau khi đăng nhập thành công
    header("Location: homepage.php");
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
        if (password_verify($password, $row['password'])) {
            // Mật khẩu đúng, lưu thông tin vào session
            $_SESSION["username"] = $username;
            $_SESSION["login"] = true;
            // Chuyển hướng tới trang chính
            header("Location: homepage.php");
            exit();
        } else {
            // Mật khẩu sai
            echo "
              <div class='notification'>
                  <p>Tên đăng nhập hoặc mật khẩu không chính xác!</p>
              </div>
              <script>
                  // Hiển thị thông báo dạng popup trên nền web
                  const notification = document.querySelector('.notification');
                  notification.style.position = 'fixed';
                  notification.style.top = '20px';
                  notification.style.right = '-300px';
                  notification.style.backgroundColor = '#f44336';
                  notification.style.color = 'white';
                  notification.style.padding = '16px';
                  notification.style.borderRadius = '4px';
                  notification.style.boxShadow = '0px 4px 8px rgba(0, 0, 0, 0.1)';
                  notification.style.zIndex = '1000';
                  notification.style.transition = 'right 0.5s ease, opacity 0.5s ease';
                  setTimeout(() => {
                      notification.style.right = '20px'; // Hiệu ứng trượt vào màn hình
                  }, 10);
                  // Sau 3 giây, trượt ra ngoài và xóa thông báo
                  setTimeout(() => {
                      notification.style.right = '-300px';
                      setTimeout(() => {
                          notification.remove();
                      }, 500); // Đợi hiệu ứng hoàn tất trước khi xóa
                  }, 3000);
              </script>
            ";
            // echo '<script>alert("sai mật khẩu");</script>';
        }
    } else {
        // Username không tồn tại
        echo "
          <div class='notification'>
              <p>Tên đăng nhập hoặc mật khẩu không chính xác!</p>
          </div>
          <script>
              // Hiển thị thông báo dạng popup trên nền web
              const notification = document.querySelector('.notification');
              notification.style.position = 'fixed';
              notification.style.top = '20px';
              notification.style.right = '-300px';
              notification.style.backgroundColor = '#f44336';
              notification.style.color = 'white';
              notification.style.padding = '16px';
              notification.style.borderRadius = '4px';
              notification.style.boxShadow = '0px 4px 8px rgba(0, 0, 0, 0.1)';
              notification.style.zIndex = '1000';
              notification.style.transition = 'right 0.5s ease, opacity 0.5s ease';
              setTimeout(() => {
                  notification.style.right = '20px'; // Hiệu ứng trượt vào màn hình
              }, 10);
              // Sau 3 giây, trượt ra ngoài và xóa thông báo
              setTimeout(() => {
                  notification.style.right = '-300px';
                  setTimeout(() => {
                      notification.remove();
                  }, 500); // Đợi hiệu ứng hoàn tất trước khi xóa
              }, 3000);
          </script>
        ";
    }
    // Đóng kết nối
    $stmt->close();
    $conn->close();

    
  }

  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EduTest</title>
    <!-- EMBED fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" type="image/png" href="../assets/images/Thumbnails-11.png?v=1">

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Sora:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/reset.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
  </head>
  <body class="bg-dark">

    <nav
      class="navbar navbar-expand-lg bg-dark navbar-dark py-3"
      data-bs-theme="dark">
      <div class="container">
        <a class="navbar-brand" href="../index.php">
          <img
            src="../assets/images/Thumbnails-11.png"
            alt="EduTest Logo"
            class="logo_img"
          />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../index.php"
                >EduTest</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#"
                >Flashcard</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#"
                >Class</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#"
                >Test</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#"
                >Notification</a
              >
            </li>
          </ul>
          <a
            href="#"
            class="btn btn-outline-success"
            id="join_for_free"
          >
            Join for free
          </a>
        </div>
      </div>
    </nav>

    <main class="bg-dark">
      <section
        class="hero d-flex align-items-center text-center bg-dark"
        style="height: 80vh"
      >
        <div class="container right">
          <img src="../assets/images/login_img.jpg" alt="hero image" />
        </div>

        <div class="container left text-center mt-5 register">
          <h2 class="mb-4">Đăng Ký Tài Khoản</h2>
          <form action="login.php" method="post">
            <div class="mb-3 text-start">
              <label for="fullname" class="form-label">Tên đăng nhập</label>
              <input
                type="text"
                class="form-control"
                id="fullname"
                placeholder="Nhập tên đăng nhập"
                name = "username"
                required
              />
            </div>
            <div class="mb-3 text-start">
              <label for="username" class="form-label">Họ và Tên</label>
              <input
                type="text"
                class="form-control"
                id="username"
                placeholder="Nhập tên người dùng"
                required
                name = "name"
              />
            </div>
            <div class="mb-3 text-start">
              <label for="email" class="form-label">Địa chỉ Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                placeholder="Nhập địa chỉ email"
                required
                name = "email"
              />
            </div>
            <div class="mb-3 text-start">
              <label for="password" class="form-label">Mật khẩu</label>
              <input
                type="password"
                class="form-control"
                id="password"
                placeholder="Nhập mật khẩu"
                required
                name = "password"
              />
            </div>
            <div class="mb-3 text-start">
              <label for="confirmPassword" class="form-label"
                >Xác nhận mật khẩu</label
              >
              <input
                type="password"
                class="form-control"
                id="confirmPassword"
                placeholder="Xác nhận mật khẩu"
                required
              />
            </div>
            <div class="action">
              <a href="#" class="register_hyperlink" id="login_x"
                >Already have an account? Login ?</a
              >
              <input type="submit" class="btn btn-success" name="register" value = "Đăng ký" id="register_action">
              <!-- <button type="submit" class="btn btn-success"></button> -->
            </div>
          </form>
        </div>

        <div class="container left text-center mt-5 login">
          <h2 class="mb-4">Đăng Nhập</h2>
          <form action="login.php" method="post">
            <div class="mb-3 text-start">
              <label for="username" class="form-label">Tên người dùng</label>
              <input
                type="text"
                class="form-control"
                id="username_login"
                placeholder="Nhập tên người dùng"
                name ="username_login"
                required
              />
            </div>
            <div class="mb-3 text-start">
              <label for="password" class="form-label">Mật khẩu</label>
              <input
                type="password"
                class="form-control"
                id="password_login"
                placeholder="Nhập mật khẩu"
                name ="password_login"
                required
              />
            </div>
            <div class="action">
              <a href="#" class="register_hyperlink" id="register_x"
                >New to EduTest? Register ?</a
              >
              <input type="submit" class="btn btn-success" name="login" value = "Đăng nhập" id="register_action">
            </div>
          </form>
        </div>
      </section>
    </main>
    <script src="../js/login.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
