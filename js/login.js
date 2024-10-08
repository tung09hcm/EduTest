// Lấy phần tử bằng ID
const registerLink = document.getElementById("register_x");
const loginLink = document.getElementById("login_x");
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
