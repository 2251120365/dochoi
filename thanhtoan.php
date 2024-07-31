<?php
session_start();

// Kiểm tra xem giỏ hàng có sản phẩm không
if (empty($_SESSION['giohang'])) {
    header("Location: giohang.php"); // Chuyển hướng về giỏ hàng nếu rỗng
    exit();
}

// Kết nối cơ sở dữ liệu (giống như trong index.php)
// ...

// Lấy thông tin sản phẩm trong giỏ hàng (tương tự như trong giohang.php)
// ...

?>

<!DOCTYPE html>
<html>
<head>
    <title>Thanh toán</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Thông tin đơn hàng</h1>
    
    <?php
    // Hiển thị thông tin sản phẩm trong giỏ hàng
    // ...
    ?>

    <h2>Thông tin giao hàng</h2>
    <form action="xuly_thanhtoan.php" method="post">
        <input type="text" name="ten_khach_hang" placeholder="Tên khách hàng">
        <input type="text" name="dia_chi" placeholder="Địa chỉ">
        <input type="text" name="so_dien_thoai" placeholder="Số điện thoại">
        <button type="submit">Đặt hàng</button>
    </form>
</body>
</html>
