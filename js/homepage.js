// Variables
let username_; // Lưu giá trị username
let name_;
let email_;
let id_;
let file_path_;
window.onload = loadPosts;
// Lấy username từ server
// -> lí do là ko bt cách lấy biến session nên phải chuyển về json r gửi thông qua get_user_in4.php
fetch("../include/get_user_in4.php")
  .then((response) => response.json())
  .then((data) => {
    username_ = data.username; // Lưu giá trị username
    name_ = data.name;
    email_ = data.email;
    id_ = data.id;
    file_path_ = data.file_path;

    console.log(username_);
    console.log(name_);
    console.log(email_);
  })
  .catch((error) => console.error("Error fetching username:", error));

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
        setTimeout(() => {
          loadPosts(); // Tải lại danh sách bài viết sau 1 giây
        }, 1000);
        this.reset(); // Reset form
      })
      .catch((error) => console.error("Error:", error));
  });

// Hàm tải các bài viết từ file JSON
function loadPosts() {
  fetch(`../include/posts.json?t=${new Date().getTime()}`)
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
                  <img src="${file_path_}" alt="user_avatar" class="avatar" />
                  <div class="post-info">
                      <h3 class="post-author">${name_}</h3>
                      <p class="post-tag">@${username_}</p>
                  </div>
                  <div class="action">
                      <button class="btn" data-index="${
                        posts.length - 1 - index
                      }">
                          <i class="fa-solid fa-bookmark" style="color: white"></i>
                      </button>  
                      <button class="btn delete-btn" data-index="${
                        posts.length - 1 - index
                      }">
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

  // Xử lý css cho textarea tạo bảng
  const textarea = document.getElementById("content_");
  textarea.style.height = "auto"; // Đặt lại chiều cao về auto
  // textarea.style.height = "0px"; // Hoặc để chiều cao về 0 nếu bạn muốn ẩn nó
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
