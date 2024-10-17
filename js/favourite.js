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
      console.log("index: ", posts.length - 1 - index);
      postDiv.setAttribute("data-id", post.id);
      postDiv.setAttribute("data-username", post.username);
      postDiv.setAttribute("data-name", post.name);
      postDiv.setAttribute("data-user_img_path", post.user_img_path);
      postDiv.setAttribute("data-content", post.content);
      postDiv.setAttribute("data-image", post.image);
      postDiv.setAttribute("data-time", post.time);
      postDiv.setAttribute("data-react", post.react);
      postDiv.setAttribute("data-comment", post.comment);
      postDiv.setAttribute("data-bookmark", post.bookmark);
      postDiv.setAttribute("data-share", post.share);
      postDiv.setAttribute("data-react_action", post.react_action);
      postDiv.setAttribute("data-bookmark_action", post.bookmark_action);
      postDiv.setAttribute("data-index", posts.length - 1 - index);
      postDiv.setAttribute("data-time", post.time); // Thêm thời gian vào thuộc tính data-time
      if (post.image) {
        postDiv.setAttribute("data-img", post.image); // Thêm thuộc tính data-img
      }
      // Tạo nội dung cho bài viết
      postDiv.innerHTML = `
        <div class="post-header">
          <img src="${post.user_img_path}" alt="user_avatar" class="avatar" />
          <div class="post-info">
            <h3 class="post-author">${post.name}</h3>
            <p class="post-tag">@${post.username}</p>
          </div>
          <div class="action">
            <button type="button" class="btn delete-btn" data-index="${
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

          ${
            post.react_action == 1
              ? `<div class="heart"><i class="fa-solid fa-heart" style="font-size: 16px; color: #22B14C"> ${post.react} </i></div>`
              : `<div class="heart"><i class="fa-solid fa-heart"  style = "font-size: 16px; color: white"> ${post.react} </i></div>`
          }

          <div class="comment"><i class="fa-solid fa-comment"  style = "font-size: 16px; color: white"> ${
            post.comment
          } </i></div>

          ${
            post.bookmark_action == 1
              ? `<div class="bookmark"><i class="fa-solid fa-bookmark" style="font-size: 16px; color: #22B14C"> ${post.bookmark} </i></div>`
              : `<div class="bookmark"><i class="fa-solid fa-bookmark"  style = "font-size: 16px; color: white"> ${post.bookmark} </i></div>`
          }

          <div class="share"><i class="fa-solid fa-share"  style = "font-size: 16px; color: white"> ${
            post.share
          } </i></div>

        </div>
      `;

      postsContainer.appendChild(postDiv);
    });

    //
    // Xử lý css cho textarea tạo bảng
    const textarea = document.getElementById("content_");
    textarea.style.height = "auto"; // Đặt lại chiều cao về auto
  } catch (error) {
    console.error("Error loading posts:", error);
  }
}

// Hàm xóa bài viết dựa trên chỉ số index
function deletePost(index) {
  // Ngăn không cho trang tải lại nếu sự kiện xảy ra trong form hoặc liên kết

  fetch("../include/delete_post.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    cache: "no-cache",
    body: JSON.stringify({ index: index }), // Gửi chỉ số của bài viết để xóa
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("Xóa thành công:", data);
      loadPosts(); // Tải lại danh sách bài viết sau khi xóa
    })
    .catch((error) => console.error("Error:", error));
}

// Event delegation để thay đổi màu nút khi nhấn và xóa bài viết
document
  .getElementById("postsContainer")
  .addEventListener("click", function (event) {
    // Ngăn chặn hành động mặc định
    event.preventDefault();

    const icon = event.target.closest("i");
    if (icon) {
      // icon.style.color = icon.style.color === "white" ? "#22B14C" : "white";
      // Kiểm tra loại nút bấm và gọi hàm cập nhật
      const post = icon.closest(".post");
      const postIndex = post.getAttribute("data-index");
      const type = icon.classList.contains("fa-heart")
        ? "heart"
        : icon.classList.contains("fa-comment")
        ? "comment"
        : icon.classList.contains("fa-bookmark")
        ? "bookmark"
        : icon.classList.contains("fa-share")
        ? "share"
        : null;

      if (type != "comment" && type != "share") {
        let currentValue = parseInt(icon.textContent.trim()) || 0; // Lấy giá trị hiện tại và chuyển thành số
        console.log("type", type);
        console.log("color before : ", icon.style.color);
        // Kiểm tra trạng thái màu của biểu tượng
        if (icon.style.color === "white") {
          // Nếu màu hiện tại là trắng, nghĩa là chưa tương tác -> tăng giá trị
          console.log("tín hiệu 1");
          icon.style.color = "#22B14C"; // Đổi màu biểu tượng để biểu thị đã tương tác
          icon.textContent = " " + (currentValue + 1); // Tăng giá trị lên 1
          updatePostInteraction(postIndex, type, true); // Gọi hàm cập nhật với tham số tăng
        } else {
          // Nếu màu hiện tại là màu đã tương tác -> giảm giá trị (hủy tương tác)
          console.log("tín hiệu 2");
          icon.style.color = "white"; // Đổi màu biểu tượng lại về trắng
          icon.textContent = " " + (currentValue - 1); // Giảm giá trị đi 1
          updatePostInteraction(postIndex, type, false); // Gọi hàm cập nhật với tham số giảm
        }
        console.log("color after : ", icon.style.color);
      } else if (type == "comment") {
        document
          .getElementById("postsContainer")
          .addEventListener("click", function (event) {
            console.log("click at postContainer");
            const post = event.target.closest("div.post");
            if (post) {
              const PostData = {
                id: post.getAttribute("data-id"),
                username: post.getAttribute("data-username"),
                name: post.getAttribute("data-name"),
                user_img_path: post.getAttribute("data-user_img_path"),
                content: post.getAttribute("data-content"),
                image: post.getAttribute("data-image"),
                time: post.getAttribute("data-time"),
                react: post.getAttribute("data-react"),
                comment: post.getAttribute("data-comment"),
                bookmark: post.getAttribute("data-bookmark"),
                share: post.getAttribute("data-share"),
                react_action: post.getAttribute("data-react_action"),
                bookmark_action: post.getAttribute("data-bookmark_action"),
              };
              localStorage.setItem("PostData", JSON.stringify(PostData));
            }
          });
        console.log("chuyển hướng đến post");
        window.open("post.php", "_blank");
      }
    }

    // Kiểm tra nếu nút X được nhấn (nút delete-btn)
    const deleteButton = event.target.closest(".delete-btn");
    if (deleteButton) {
      const postIndex = deleteButton.getAttribute("data-index");
      deletePost(postIndex); // Gọi hàm deletePost với chỉ số của bài viết
    }
  });

function updatePostInteraction(postIndex, interactionType, increase) {
  console.log("index: ", postIndex);
  console.log("interactionType: ", interactionType);
  console.log("increase: ", increase);
  fetch("../include/update_interaction.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    cache: "no-cache",
    body: JSON.stringify({
      index: postIndex,
      type: interactionType,
      increase: increase,
    }), // Gửi loại tương tác và chỉ số bài viết
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(`Cập nhật ${interactionType} thành công:`, data);
      // Có thể xử lý giao diện người dùng nếu cần, ví dụ: tăng số lượng heart/comment/bookmark/share
    })
    .catch((error) => console.error("Error:", error));
}
