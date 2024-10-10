// Lấy phần tử bằng ID
const registerLink = document.getElementById("register_x");
const loginLink = document.getElementById("login_x");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");
const registeer_button = document.getElementById("register_action");

const fullname = document.getElementById("fullname");
const username = document.getElementById("username");
const email = document.getElementById("email");

// Thêm sự kiện click cho liên kết
registerLink.addEventListener("click", function (event) {
  event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a

  // Ẩn phần đăng nhập và hiển thị phần đăng ký
  document.querySelector(".login").style.display = "none"; // Ẩn phần đăng nhập
  document.querySelector(".register").style.display = "block"; // Hiển thị phần đăng ký
});
loginLink.addEventListener("click", function (event) {
  event.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a

  // Ẩn phần đăng nhập và hiển thị phần đăng ký
  document.querySelector(".login").style.display = "block"; // Ẩn phần đăng nhập
  document.querySelector(".register").style.display = "none"; // Hiển thị phần đăng ký
});
registeer_button.addEventListener("click", function (event) {
  if (password.value != confirmPassword.value) {
    event.preventDefault(); // Ngăn gửi biểu mẫu

    // Tạo thông báo mới
    // const notification = document.createElement("div");
    // notification.classList.add("notification");
    // notification.innerHTML = `
    //   <div style="position: fixed; top: 20px; right: -300px; background-color: #f44336; color: white; padding: 16px; border-radius: 4px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: right 0.5s ease, opacity 0.5s ease; z-index: 1000;">
    //     Mật khẩu và xáccc nhận mật khẩu không khớp!
    //   </div>
    // `;

    // // Thêm thông báo vào body
    // document.body.appendChild(notification);

    // // Kích hoạt hiệu ứng trượt vào màn hình
    // setTimeout(() => {
    //   notification.firstChild.style.right = "20px";
    // }, 10);

    // // Sau 3 giây, trượt ra ngoài và xóa thông báo
    // setTimeout(() => {
    //   notification.firstChild.style.right = "-300px";
    //   setTimeout(() => {
    //     notification.remove();
    //   }, 500); // Đợi hiệu ứng hoàn tất trước khi xóa
    // }, 3000);
  }
});
