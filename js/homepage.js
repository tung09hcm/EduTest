document
  .getElementById("postForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("../include/upload.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        loadPosts();
        this.reset();
      })
      .catch((error) => console.error("Error:", error));
  });

function loadPosts() {
  fetch("../include/posts.json")
    .then((response) => response.json())
    .then((posts) => {
      console.log(posts);
      const postsContainer = document.getElementById("postsContainer");
      postsContainer.innerHTML = "";
      // Đảo ngược mảng để bài đăng mới nằm ở đầu

      posts.reverse().forEach((post, index) => {
        // print_data
        console.log(post.image);
        const postDiv = document.createElement("div");
        postDiv.classList.add("post");
        postDiv.classList.add("bg-dark");
        // Thêm nội dung bài viết
        if (post.image) {
          postDiv.innerHTML = `
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
              ${post.content}
              </p>

              <img src="${post.image}" alt="post" />

              <p class="post-content-time">
                3:45 AM - Oct 12, 2024 - 59.1M Views
              </p>
            </div>

            <div class="post-bottom">
              <div class="heart"><i class="fa-solid fa-heart"> 100 </i></div>
              <div class="comment">
                <i class="fa-solid fa-comment"> 1000 </i>
              </div>
              <div class="bookmark">
                <i class="fa-solid fa-bookmark"> 5000 </i>
              </div>
              <div class="share"><i class="fa-solid fa-share"> 50 </i></div>
            </div>
        `;
        } else {
          postDiv.innerHTML = `
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
              ${post.content}
              </p>


              <p class="post-content-time">
                3:45 AM - Oct 12, 2024 - 59.1M Views
              </p>
            </div>

            <div class="post-bottom">
              <div class="heart"><i class="fa-solid fa-heart"> 100 </i></div>
              <div class="comment">
                <i class="fa-solid fa-comment"> 1000 </i>
              </div>
              <div class="bookmark">
                <i class="fa-solid fa-bookmark"> 5000 </i>
              </div>
              <div class="share"><i class="fa-solid fa-share"> 50 </i></div>
            </div>
        `;
        }
        postsContainer.appendChild(postDiv);
      });
    });
}

// Tải các bài viết khi trang được tải
loadPosts();
