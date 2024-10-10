<?php
    include("../include/database.php");
    session_start();

    // Kiểm tra xem biến kết nối ($conn) đã được khởi tạo hay chưa
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];

            // Sử dụng prepared statement để tránh SQL Injection
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Kiểm tra xem có kết quả trả về không
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['name'];  // Lấy tên người dùng từ cơ sở dữ liệu
                echo "Xin chào, " . htmlspecialchars($name) . "!";
            } else {
                echo "Không tìm thấy thông tin người dùng.";
            }

            // Đóng kết nối
            $stmt->close();
            $conn->close();
        } else {
            header("Location: error.html");
            exit();
        }
    } 
    else {  
      header("Location: error.html");
      exit();
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
        <a class="navbar-brand" href="#">
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
              <a class="nav-link active" aria-current="page" href="#"
                >EduTest</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="./pages/login.php"
                >Flashcard</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="./pages/login.php"
                >Class</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="./pages/login.php"
                >Test</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="./pages/login.php"
                >Notification</a
              >
            </li>
          </ul>
          <h1>
            <?php
              echo '
                <div style="display: inline-block;">
                  <button class="btn btn-outline-success">Xin chào, ' . htmlspecialchars($name) . '!</button>
                  <form action="logout.php" method="POST" style="display: inline;">
                    <button type="submit" class="btn btn-outline-danger">Đăng xuất</button>
                  </form>
                </div>
              ';
            ?>
          </h1>
        </div>
      </div>
    </nav>

    <main class="bg-dark container"></main>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
