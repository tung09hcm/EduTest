<?php
session_start();
?>
<?php if (isset($_SESSION["login_error"])): ?>
  <div class="alert alert-danger">
    <?php 
      echo $_SESSION["login_error"]; 
      unset($_SESSION["login_error"]); // Clear the error after displaying it
    ?>
  </div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EduTest</title>
    <!-- EMBED fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="icon"
      type="image/png"
      href="../assets/images/Thumbnails-11.png?v=1"
    />

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
    <style>
      /* General styles */
      body {
        background-color: #343a40; /* bg-dark */
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        font-family: 'Arial', sans-serif;
        margin: 0;
      }

      form {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
      }

      /* Form fields */
      .form-label {
        font-weight: bold;
        color: white;
      }

      input[type="text"],
      input[type="email"],
      input[type="password"],
      input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        box-sizing: border-box;
      }

      input[type="text"]:focus,
      input[type="email"]:focus,
      input[type="password"]:focus {
        outline: none;
        border-color: #28a745;
      }

      /* File upload */
      .custom-file-upload {
        display: block;
        margin-bottom: 10px;
        color: white;
        cursor: pointer;
      }

      input.choose_img {
        display: none;
      }

      .custom-file-upload i {
        font-size: 16px;
        color: white;
        margin-right: 5px;
      }

      /* Action buttons */
      .action {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .register_hyperlink {
        text-decoration: none;
        font-size: 14px;
      }

      .register_hyperlink:hover {
        text-decoration: underline;
      }


    </style>
  </head>
  <body class="bg-dark" 
  style="display: flex; align-items: center; justify-content: center; height: 100vh;">

    <main class="bg-dark">
      <section
        class="hero d-flex align-items-center text-center bg-dark"
        style="height: 80vh">
        <div class="container right">
          <img src="../assets/images/login_img.jpg" alt="hero image" />
        </div>

        <div class="container left text-center mt-5 register">
          <h2 class="mb-4">Đăng Ký Tài Khoản</h2>

          <form action="../include/log.php" method="post" class = "bg-dark" enctype="multipart/form-data">
            <div class="mb-3 text-start">
              <label for="fullname" class="form-label">Tên đăng nhập</label>
              <input
                type="text"
                class="form-control"
                id="fullname"
                placeholder="Nhập tên đăng nhập"
                name="username"
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
                name="name"
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
                name="email"
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
                name="password"
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
            <label for="image" class="custom-file-upload btn btn-outline-secondary">
                <i class="fa-solid fa-image">Upload your image</i>
            </label>
            <input
              class="choose_img"
              type="file"
              id="image"
              name="image"
              accept="image/*"
            />
            <div class="action">
              <a href="#" class="register_hyperlink" id="login_x"
                >Already have an account? Login ?</a
              >


              <input
                type="submit"
                class="btn btn-success"
                name="register"
                value="Đăng ký"
                id="register_action"
              />
              <!-- <button type="submit" class="btn btn-success"></button> -->
            </div>
          </form>
        </div>

        <div class="container left text-center mt-5 login" >
          <h2 class="mb-4">Đăng Nhập</h2>

          <form action="../include/log.php" method="post" class = "bg-dark">
            <div class="mb-3 text-start">
              <label for="username" class="form-label">Tên người dùng</label>
              <input
                type="text"
                class="form-control"
                id="username_login"
                placeholder="Nhập tên người dùng"
                name="username_login"
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
                name="password_login"
                required
              />
            </div>
            <div class="action">
              <a href="#" class="register_hyperlink" id="register_x"
                >New to EduTest? Register ?</a
              >
              <input
                type="submit"
                class="btn btn-success"
                name="login"
                value="Đăng nhập"
                id="register_action"
              />
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
