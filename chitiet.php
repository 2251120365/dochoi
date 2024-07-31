<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dochoi_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID sản phẩm từ URL
$id = $_GET['id'];

// Truy vấn chi tiết sản phẩm
$sql = "SELECT * FROM sanpham WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?php echo $row["ten_sanpham"]; ?></h1>
    <img src="images/<?php echo $row["anh"]; ?>" alt="<?php echo $row["ten_sanpham"]; ?>">
    <p><?php echo $row["mo_ta"]; ?></p>
    <p>Giá: <?php echo $row["gia"]; ?> VND</p>
    <button>Thêm vào giỏ hàng</button>
</body>
</html>
