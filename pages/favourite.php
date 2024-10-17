<!-- 
<?php
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


    <script>

      function fetchPosts() {
        console.log("Initial fetch Posts stage 2 !!!")

        fetch("../include/fetch_fav_post.php") // Đường dẫn đến file PHP
          .then((response) => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.json(); // Mong đợi phản hồi dưới dạng JSON
          })
          .then((data) => {
            console.log(data); // Xử lý dữ liệu trả về từ PHP
          })
          .catch((error) => {
            console.error("There was a problem with the fetch operation:", error);
          });
      }
      console.log("Initial fetch Posts!!!")
      document.addEventListener('DOMContentLoaded', fetchPosts);

    </script>   
  </head>
  <body class="bg-dark">
    <div class="main_container">
      <!-- LEFT CONTAINER -->
      <div class="left" style="border-right: 1px solid rgb(103, 100, 100); ">
        <div class="item" style=" cursor: pointer" id ="home">
          <i class="fa-solid fa-house"></i>
          <h1>Home</h1>
        </div>

        <!-- <div class="search item">
          <i class="fa-solid fa-magnifying-glass"></i>
          <h1>Explore</h1>
        </div> -->

        <div class="item" style = "cursor: pointer" id="notifications">
          <i class="fa-solid fa-bell"></i>
          <h1>Notifications</h1>
        </div>

        <!-- <div class="message item">
          <i class="fa-solid fa-message"></i>
          <h1>Messages</h1>
        </div> -->

        <!-- <div class="community item">
          <i class="fa-duotone fa-solid fa-user-group"></i>
          <h1>Community</h1>
        </div> -->

        <div class="item" style = "cursor: pointer; color: #22b14c;" id = "favourite">
          <i class="fa-solid fa-heart"></i>
          <h1>Favourite</h1>
        </div>

        <div class="item" style = "cursor: pointer" id="save">
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
    


         
    <script src="../js/redirect.js"></script>
    <script src="../js/favourite.js"></script>
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
