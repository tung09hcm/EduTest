console.log("Script loaded");
window.onload = async function () {
  await loadPost(); // Tải bài viết
};
// Lắng nghe sự kiện submit của form
document
  .getElementById("postForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch("../include/upload_comment.php", {
      method: "POST",
      cache: "no-cache",
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

function updatePostInteraction(postid, interactionType, increase) {
  console.log("interactionType: ", interactionType);
  console.log("increase: ", increase);
  console.log("postid: ", postid);
  fetch("../include/update_mainpost_interaction.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    cache: "no-cache",
    body: JSON.stringify({
      type: interactionType,
      increase: increase,
      id: postid,
    }), // Gửi loại tương tác và chỉ số bài viết
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(`Cập nhật ${interactionType} thành công:`, data);
      // Có thể xử lý giao diện người dùng nếu cần, ví dụ: tăng số lượng heart/comment/bookmark/share
    })
    .catch((error) => console.error("Error:", error));
}

async function loadPost() {
  // Lấy dữ liệu từ localStorage
  const post = JSON.parse(localStorage.getItem("PostData"));
  if (post) {
    const main_post_container = document.getElementById("main_post");
    main_post_container.innerHTML = "";
    main_post_container.innerHTML = `
        <div class="post-header">
          <img src="${post.user_img_path}" alt="user_avatar" class="avatar" />
          <div class="post-info">
            <h3 class="post-author">${post.name}</h3>
            <p class="post-tag">@${post.username}</p>
          </div>
          <div class="action">
            <button type="button" class="btn delete-btn">
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
              ? `<div class="heart" ><i class="fa-solid fa-heart" style="font-size: 16px; color: #22B14C" id="heart"> ${post.react} </i></div>`
              : `<div class="heart" ><i class="fa-solid fa-heart"  style = "font-size: 16px; color: white" id="heart"> ${post.react} </i></div>`
          }

          <div class="comment"><i class="fa-solid fa-comment"  style = "font-size: 16px; color: white" id = "comment"> ${
            post.comment
          } </i></div>

          ${
            post.bookmark_action == 1
              ? `<div class="bookmark"><i class="fa-solid fa-bookmark" style="font-size: 16px; color: #22B14C" id = "bookmark"> ${post.bookmark} </i></div>`
              : `<div class="bookmark"><i class="fa-solid fa-bookmark"  style = "font-size: 16px; color: white" id = "bookmark"> ${post.bookmark} </i></div>`
          }

          <div class="share"><i class="fa-solid fa-share"  style = "font-size: 16px; color: white" id = "share"> ${
            post.share
          } </i></div>

        </div>
          <br>
        <div class="post-comment" style="width: 100%">
          <!-- <div class="user_comment self">
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
          </div> -->
          
          <!-- <div class="user_comment other">
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
          </div> -->
        </div>
    `;
    document.getElementById("heart").addEventListener("click", function () {
      const type = "react";
      console.log("click heart at main post");
      let currentValue = parseInt(this.textContent.trim()) || 0;
      // Kiểm tra xem phần tử đã có màu đỏ chưa, nếu có thì đổi về trắng, nếu chưa thì đổi sang đỏ
      if (this.style.color === "white") {
        this.style.color = "#22B14C";
        this.textContent = " " + (currentValue + 1);
        updatePostInteraction(post.id, type, true);
      } else {
        this.style.color = "white";
        this.textContent = " " + (currentValue - 1);
        updatePostInteraction(post.id, type, false);
      }
    });
    document.getElementById("bookmark").addEventListener("click", function () {
      const type = "bookmark";
      console.log("click bookmark at main post");
      let currentValue = parseInt(this.textContent.trim()) || 0;
      // Kiểm tra xem phần tử đã có màu đỏ chưa, nếu có thì đổi về trắng, nếu chưa thì đổi sang đỏ
      if (this.style.color === "white") {
        this.style.color = "#22B14C";
        this.textContent = " " + (currentValue + 1);
        updatePostInteraction(post.id, type, true);
      } else {
        this.style.color = "white";
        this.textContent = " " + (currentValue - 1);
        updatePostInteraction(post.id, type, false);
      }
    });
  }
}
