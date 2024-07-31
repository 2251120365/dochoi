<?php
session_start(); // Bắt đầu session để lưu trữ giỏ hàng

// Kiểm tra xem giỏ hàng đã tồn tại chưa
if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = array();
}

// Xử lý thêm sản phẩm vào giỏ hàng (nếu có yêu cầu từ chitiet.php)
if (isset($_POST['them_vao_gio'])) {
    $id = $_POST['id'];
    $so_luong = $_POST['so_luong'];
    $_SESSION['giohang'][$id] = $so_luong;
}

// Kết nối cơ sở dữ liệu (giống như trong index.php)
// ...

// Lấy thông tin sản phẩm trong giỏ hàng
$tong_tien = 0;
foreach ($_SESSION['giohang'] as $id => $so_luong) {
    $sql = "SELECT * FROM sanpham WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $tong_tien += $row['gia'] * $so_luong;

    // Hiển thị thông tin sản phẩm
    echo '<div class="product">';
    echo '<img src="images/' . $row["anh"] . '" alt="' . $row["ten_sanpham"] . '">';
    echo '<h2>' . $row["ten_sanpham"] . '</h2>';
    echo '<p>Giá: ' . $row["gia"] . ' VND</p>';
    echo '<p>Số lượng: ' . $so_luong . '</p>';
    // Thêm nút cập nhật số lượng và xóa sản phẩm ở đây
    echo '</div>';
}

// Hiển thị tổng tiền
echo '<p>Tổng tiền: ' . $tong_tien . ' VND</p>';
echo '<a href="thanhtoan.php">Thanh toán</a>';
?>
