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
    alert("Mật khẩu và xác nhận mật khẩu không khớp!");
  }
});
