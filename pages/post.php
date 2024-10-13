<!-- 
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
?> -->
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
    <link rel="stylesheet" href="../assets/css/flashcard_item.css" />
  </head>
  <body class="bg-dark">
    <div class="main_container">
      <!-- LEFT CONTAINER -->
      <div class="left" style="border-right: 1px solid rgb(103, 100, 100)">
        <div class="home item" style="color: #22b14c">
          <i class="fa-solid fa-house"></i>
          <h1>Home</h1>
        </div>

        <div class="search item">
          <i class="fa-solid fa-magnifying-glass"></i>
          <h1>Explore</h1>
        </div>

        <div class="notifications item">
          <i class="fa-solid fa-bell"></i>
          <h1>Notifications</h1>
        </div>

        <div class="message item">
          <i class="fa-solid fa-message"></i>
          <h1>Messages</h1>
        </div>

        <div class="community item">
          <i class="fa-duotone fa-solid fa-user-group"></i>
          <h1>Community</h1>
        </div>

        <div class="save item">
          <i class="fa-solid fa-bookmark"></i>
          <h1>Save</h1>
        </div>

        <form
          action="../include/logout.php"
          method="POST"
          style="display: inline; margin-left: 8px"
          class="d-flex logout_homepage"
        >
          <a class="communication_item self">
            <img src="../assets/images/user_avatar/cat.jpg" alt="user_avatar" />
            <h1>ryo_yamada</h1>
          </a>
          <button type="submit" class="btn logout">Logout</button>
        </form>
      </div>
      <!-- CENTER CONTAINER -->

      <div class="center">
        <div class="go_back">
          <i class="fa-solid fa-arrow-left"></i>
        </div>
        <div class="post bg-dark">
          <div class="post-header">
            <img
              src="../assets/images/user_avatar/cat.jpg"
              alt="user_avatar"
              class="avatar"
            />
            <div class="post-info">
              <h3 class="post-author">Ryo Yamada</h3>
              <p class="post-tag">@ryo_yamada</p>
            </div>
            <div class="action">
              <i class="fa-solid fa-bookmark"></i>
              <i class="fa-solid fa-x"></i>
            </div>
          </div>

          <div class="post-content">
            <p>
              This is a sample post content. It can be a status update, photo,
              or link shared by the user.
            </p>

            <img src="../assets/images/background.jpg" alt="post" />

            <p class="post-content-time">
              3:45 AM - Oct 12, 2024 - 59.1M Views
            </p>
          </div>

          <div class="post-bottom">
            <div class="heart"><i class="fa-solid fa-heart"> 100 </i></div>
            <div class="comment"><i class="fa-solid fa-comment"> 1000 </i></div>
            <div class="bookmark">
              <i class="fa-solid fa-bookmark"> 5000 </i>
            </div>
            <div class="share"><i class="fa-solid fa-share"> 50 </i></div>
          </div>
          <br />
          <div class="post-comment" style="width: 100%">
            <div class="user_comment self">
              <img
                src="../assets/images/user_avatar/cat.jpg"
                alt="your_avatar"
                style="
                  width: 40px;
                  height: 40px;
                  object-fit: cover;
                  border-radius: 100%;
                "
              />
              <h1 style="color: gray">Post your reply</h1>
              <button class="btn btn-success reply" style="border-radius: 30px">
                Reply
              </button>
            </div>
            <div class="user_comment other">
              <div class="post-header">
                <img
                  src="../assets/images/user_avatar/hecker-base.png"
                  alt="user_avatar"
                  class="avatar"
                />
                <div class="post-info">
                  <h3 class="post-author">Bùi Thanh Tùng</h3>
                  <p class="post-tag">@tung0.9</p>
                </div>
              </div>
              <div class="post-content" style="border: none">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos sit
                explicabo expedita laudantium consectetur laborum molestias
                tenetur odio autem facilis, consequatur perspiciatis quae quidem
                reiciendis dolor et obcaecati est magni!
              </div>
              <div class="post-bottom" style="width: 70%">
                <div class="heart"><i class="fa-solid fa-heart"> 100 </i></div>
                <div class="comment">
                  <i class="fa-solid fa-comment"> 1000 </i>
                </div>
                <div class="bookmark">
                  <i class="fa-solid fa-bookmark"> 5000 </i>
                </div>
                <div class="share"><i class="fa-solid fa-share"> 50 </i></div>
              </div>
            </div>
            <div class="user_comment other">
              <div class="post-header">
                <img
                  src="../assets/images/user_avatar/hecker.png"
                  alt="user_avatar"
                  class="avatar"
                />
                <div class="post-info">
                  <h3 class="post-author">Bay Gao</h3>
                  <p class="post-tag">@tung.bui2004lk</p>
                </div>
              </div>
              <div class="post-content" style="border: none">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos sit
                explicabo expedita laudantium consectetur laborum molestias
                tenetur odio autem facilis, consequatur perspiciatis quae quidem
                reiciendis dolor et obcaecati est magni!
              </div>
              <div class="post-bottom" style="width: 70%">
                <div class="heart"><i class="fa-solid fa-heart"> 100 </i></div>
                <div class="comment">
                  <i class="fa-solid fa-comment"> 1000 </i>
                </div>
                <div class="bookmark">
                  <i class="fa-solid fa-bookmark"> 5000 </i>
                </div>
                <div class="share"><i class="fa-solid fa-share"> 50 </i></div>
              </div>
            </div>
            <div class="user_comment other">
              <div class="post-header">
                <img
                  src="../assets/images/user_avatar/ryo.jpg"
                  alt="user_avatar"
                  class="avatar"
                />
                <div class="post-info">
                  <h3 class="post-author">Lê Anh Khoa</h3>
                  <p class="post-tag">@khoa_le</p>
                </div>
              </div>
              <div class="post-content" style="border: none">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos sit
                explicabo expedita laudantium consectetur laborum molestias
                tenetur odio autem facilis, consequatur perspiciatis quae quidem
                reiciendis dolor et obcaecati est magni!
              </div>
              <div class="post-bottom" style="width: 70%">
                <div class="heart"><i class="fa-solid fa-heart"> 100 </i></div>
                <div class="comment">
                  <i class="fa-solid fa-comment"> 1000 </i>
                </div>
                <div class="bookmark">
                  <i class="fa-solid fa-bookmark"> 5000 </i>
                </div>
                <div class="share"><i class="fa-solid fa-share"> 50 </i></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT CONTAINER -->
      <div class="right">
        <form class="d-flex" role="search">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
        </form>
        <a class="communication_item x">
          <img
            src="../assets/images/user_avatar/hecker.png"
            alt="user_avatar"
          />
          <div>
            <h1>Bùi Thanh Tùng</h1>
            <h1 style="color: #22b14c">Online</h1>
          </div>
        </a>
        <a class="communication_item x">
          <img src="../assets/images/user_avatar/ryo.jpg" alt="user_avatar" />
          <div>
            <h1>Bùi Thanh Tùng</h1>
            <h1 style="color: #22b14c">Online</h1>
          </div>
        </a>
        <a class="communication_item x">
          <img
            src="../assets/images/user_avatar/hecker-base.png"
            alt="user_avatar"
          />
          <div>
            <h1>Bùi Thanh Tùng</h1>
            <h1 style="color: #22b14c">Online</h1>
          </div>
        </a>
        <a class="communication_item x">
          <img src="../assets/images/user_avatar/reze.jpg" alt="user_avatar" />
          <div>
            <h1>Bùi Thanh Tùng</h1>
            <h1 style="color: #22b14c">Online</h1>
          </div>
        </a>
      </div>
    </div>
    <script
      src="https://kit.fontawesome.com/55709266d7.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
