// Lắng nghe sự kiện submit của form
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
        loadPosts(); // Tải lại danh sách bài viết
        this.reset(); // Reset form
      })
      .catch((error) => console.error("Error:", error));
  });

// Hàm tải các bài viết từ file JSON
function loadPosts() {
  fetch("../include/posts.json")
    .then((response) => response.json())
    .then((posts) => {
      const postsContainer = document.getElementById("postsContainer");
      postsContainer.innerHTML = ""; // Xóa nội dung cũ

      // Đảo ngược mảng để bài đăng mới nằm ở đầu
      posts.reverse().forEach((post, index) => {
        const postDiv = document.createElement("div");
        postDiv.classList.add("post", "bg-dark");

        // Tạo nội dung cho bài viết
        postDiv.innerHTML = `
              <div class="post-header">
                  <img src="../assets/images/user_avatar/cat.jpg" alt="user_avatar" class="avatar" />
                  <div class="post-info">
                      <h3 class="post-author">Ryo Yamada</h3>
                      <p class="post-tag">@ryo_yamada</p>
                  </div>
                  <div class="action">
                      <button class="btn" data-index="${index}">
                          <i class="fa-solid fa-bookmark" style="color: white"></i>
                      </button>  
                      <button class="btn delete-btn" data-index="${index}">
                          <i class="fa-solid fa-x" style="color: white"></i>
                      </button>  
                  </div>
              </div>

              <div class="post-content">
                  <p>${post.content}</p>
                  ${post.image ? `<img src="${post.image}" alt="post" />` : ""}
                  <p class="post-content-time">${post.time}</p>
              </div>

              <div class="post-bottom">
                  <div class="heart"><i class="fa-solid fa-heart"> 0 </i></div>
                  <div class="comment"><i class="fa-solid fa-comment"> 0 </i></div>
                  <div class="bookmark"><i class="fa-solid fa-bookmark"> 0 </i></div>
                  <div class="share"><i class="fa-solid fa-share"> 0 </i></div>
              </div>
          `;

        postsContainer.appendChild(postDiv);
      });
    })
    .catch((error) => console.error("Error loading posts:", error));
}

// Hàm xóa bài viết dựa trên chỉ số index
function deletePost(index) {
  fetch("../include/delete_post.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ index: index }), // Gửi chỉ số của bài viết để xóa
  })
    .then((response) => response.text())
    .then((data) => {
      console.log(data); // Xử lý kết quả trả về (nếu cần)
      loadPosts(); // Tải lại danh sách bài viết sau khi xóa
    })
    .catch((error) => console.error("Error:", error));
}

// Event delegation để thay đổi màu nút khi nhấn và xóa bài viết
document
  .getElementById("postsContainer")
  .addEventListener("click", function (event) {
    const icon = event.target.closest("i.fa-solid");
    if (icon) {
      // Thay đổi màu biểu tượng
      icon.style.color = icon.style.color === "white" ? "#22B14C" : "white";
    }

    // Kiểm tra nếu nút X được nhấn (nút delete-btn)
    const deleteButton = event.target.closest(".delete-btn");
    if (deleteButton) {
      const postIndex = deleteButton.getAttribute("data-index");
      deletePost(postIndex); // Gọi hàm deletePost với chỉ số của bài viết
    }
  });

// Tải các bài viết khi trang được tải
loadPosts();
