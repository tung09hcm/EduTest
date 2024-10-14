<!-- 
<?php
    include("../include/database.php");
    session_start();

    // Kiểm tra xem biến kết nối ($conn) đã được khởi tạo hay chưa
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
            $name = $_SESSION["name"];
            $id = $_SESSION["id"];
            $email = $_SESSION["email"];
            $file_path = $_SESSION["file_path"];

            // $post = [
            //   'username' => $_SESSION["username"],
            //   'name' => $_SESSION["name"],
            //   'id' => $_SESSION["id"],
            //   'email' => $_SESSION["email"],
            //   'file_path' => $_SESSION["file_path"],
            // ];
            
            // $posts = [];
            // if (file_exists('user.json')) {
            //     $posts = json_decode(file_get_contents('user.json'), true);
            // }
            // $posts[] = $post;
            // file_put_contents('user.json', json_encode($posts));

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
            <img src="<?php echo $_SESSION['file_path']; ?>" alt="user_avatar" />
            <h1><?php echo $_SESSION['name']; ?></h1>
          </a>
          <button type="submit" class="btn logout">Logout</button>
        </form>
      </div>
      <!-- CENTER CONTAINER -->

      <div class="center">
        <div class="create bg-dark">
          <div class="create-header">
            <img
              src="<?php echo $_SESSION['file_path']; ?>"
              alt="user_avatar"
              class="avatar"
            />
            <!-- <span style="color: rgb(103, 100, 100)">What is happening ?</span> -->
            <form
              id="postForm"
              method="post"
              enctype="multipart/form-data"
              class="create_post_form"
            >
            <textarea
              id="content_"
              name="content"
              placeholder="What is happening..."
              required
              class="bg-dark"
              style="border: none; width: 100%; color: white; outline: none; resize: none; overflow: hidden; white-space: pre-wrap;"
            ></textarea>

              <script>
                const textarea = document.getElementById('content_');
                textarea.addEventListener('input', function () {
                  this.style.height = 'auto';
                  this.style.height = this.scrollHeight + 'px'; // Mở rộng chiều cao theo nội dung
                });
              </script>

              <label for="image" class="custom-file-upload">
                <i class="fa-solid fa-image" style="font-size: 20px"></i>
              </label>
              <input
                class="choose_img"
                type="file"
                id="image"
                name="image"
                accept="image/*"
              />

              <!-- </div> -->
              <button type="submit" class="btn btn-success">Post</button>
            </form>
          </div>
        </div>
        <div class="postsContainer" id = "postsContainer">

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
    
    <script src="../js/homepage.js"></script>
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
