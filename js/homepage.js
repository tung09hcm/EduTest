// function to get post data and write it in posts.json
function fetchPosts() {
  fetch("../include/fetch_post.php") // Đường dẫn đến file PHP
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json(); // Mong đợi phản hồi dưới dạng JSON
    })
    .then((data) => {
      console.log(data); // Xử lý dữ liệu trả về từ PHP
      displayPosts(data); // Gọi hàm để hiển thị bài viết
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
}

// Variables
let username_; // Lưu giá trị username
let name_;
let email_;
let id_;
let file_path_;
window.onload = async function () {
  await getUserInfo(); // Đợi lấy thông tin người dùng
  loadPosts(); // Sau đó tải bài viết
};

// Lấy username từ server
// -> lí do là ko bt cách lấy biến session nên phải chuyển về json r gửi thông qua get_user_in4.php

async function getUserInfo() {
  try {
    const response = await fetch("../include/get_user_in4.php");
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    const data = await response.json();
    const userInfo = {
      username: data.username, // Lưu giá trị username
      name: data.name,
      email: data.email,
      id: data.id,
      file_path: data.file_path,
    };
    return userInfo;
  } catch (error) {
    console.error("Error fetching user info:", error);
    throw error; // Ném lại lỗi nếu có
  }
}

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
async function loadPosts() {
  try {
    const userInfo = await getUserInfo(); // Đợi cho userInfo được lấy
    id_ = userInfo.id; // Gán id_ sau khi đã lấy được userInfo
    console.log("loadPosts: " + id_ + ".json\n");

    const response = await fetch(
      `../include/${id_}.json?t=${new Date().getTime()}`
    );
    const posts = await response.json();

    const postsContainer = document.getElementById("postsContainer");
    postsContainer.innerHTML = ""; // Xóa nội dung cũ

    // Đảo ngược mảng để bài đăng mới nằm ở đầu
    posts.reverse().forEach((post, index) => {
      const postDiv = document.createElement("div");
      postDiv.classList.add("post", "bg-dark");

      // Tạo nội dung cho bài viết
      postDiv.innerHTML = `
        <div class="post-header">
          <img src="${post.user_img_path}" alt="user_avatar" class="avatar" />
          <div class="post-info">
            <h3 class="post-author">${post.name}</h3>
            <p class="post-tag">@${post.username}</p>
          </div>
          <div class="action">
            <button class="btn" data-index="${posts.length - 1 - index}">
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

    // Xử lý css cho textarea tạo bảng
    const textarea = document.getElementById("content_");
    textarea.style.height = "auto"; // Đặt lại chiều cao về auto
  } catch (error) {
    console.error("Error loading posts:", error);
  }
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
