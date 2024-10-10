<?php
  session_start();

  if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    // Người dùng đã đăng nhập
    header("Location: ./homepage.php");
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
    <link
      rel="icon"
      type="image/png"
      href="./assets/images/Thumbnails-11.png"
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
    <link rel="stylesheet" href="./assets/css/reset.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/responsive.css" />
  </head>
  <body class="bg-dark">
    <nav
      class="navbar navbar-expand-lg bg-dark navbar-dark py-3"
      data-bs-theme="dark"
    >
      <div class="container">
        <a class="navbar-brand" href="#">
          <img
            src="./assets/images/Thumbnails-11.png"
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
              <a class="nav-link " aria-current="page" href="./pages/login.php"
                >Flashcard</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="./pages/login.php"
                >Class</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="./pages/login.php"
                >Test</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="./pages/login.php"
                >Notification</a
              >
            </li>
          </ul>
          <a
            href="./pages/login.php"
            class="btn btn-outline-success"
            id="join_for_free"
          >
            Join for free
          </a>
        </div>
      </div>
    </nav>

    <main class="bg-dark container">
      <section
        class="hero d-flex align-items-center text-center bg-dark container"
        style="height: 80vh"
      >
        <div class="container left text-start">
          <h1 class="display-4 fw-bold">Welcome to EduTest</h1>
          <p class="lead mb-4">
            Empower your learning experience with tools for teachers and
            students. Create classes, add students, and design custom quizzes to
            share with others.
          </p>
          <a href="./pages/login.php" class="btn btn-success btn-lg"
            >Explore Now</a
          >
        </div>
        <div class="container right">
          <img src="./assets/images/hero.jpg" alt="hero image" />
        </div>
      </section>
    </main>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
