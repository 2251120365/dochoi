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

// 2. Lấy ID sản phẩm từ URL
$id = $_GET['id'];

// 3. Xử lý cập nhật sản phẩm nếu có dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $tenSanPham = $_POST['ten_sanpham'];
    $moTa = $_POST['mo_ta'];
    $gia = $_POST['gia'];
    $anh = $_FILES['anh']['name']; // Lấy tên file ảnh mới (nếu có)

    // Xử lý upload ảnh mới (nếu có)
    if (!empty($anh)) {
        $targetDir = "images/";
        $targetFile = $targetDir . basename($anh);
        move_uploaded_file($_FILES["anh"]["tmp_name"], $targetFile);
    }

    // Cập nhật thông tin sản phẩm
    $sql = "UPDATE sanpham SET 
            ten_sanpham = '$tenSanPham', 
            mo_ta = '$moTa', 
            gia = $gia, 
            anh = '$anh' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật sản phẩm thành công.";
    } else {
        echo "Lỗi khi cập nhật sản phẩm: " . $conn->error;
    }
}

// 4. Truy vấn thông tin sản phẩm để hiển thị trong form
$sql = "SELECT * FROM sanpham WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Sửa sản phẩm</h2>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="ten_sanpham">Tên sản phẩm:</label><br>
        <input type="text" id="ten_sanpham" name="ten_sanpham" value="<?php echo $row["ten_sanpham"]; ?>"><br>

        <label for="mo_ta">Mô tả:</label><br>
        <textarea id="mo_ta" name="mo_ta"><?php echo $row["mo_ta"]; ?></textarea><br>

        <label for="gia">Giá:</label><br>
        <input type="text" id="gia" name="gia" value="<?php echo $row["gia"]; ?>"><br>

        <label for="anh">Ảnh:</label><br>
        <input type="file" id="anh" name="anh"><br>
        <img src="images/<?php echo $row["anh"]; ?>" alt="<?php echo $row["ten_sanpham"]; ?>" width="100"><br><br>

        <input type="submit" value="Cập nhật">
    </form>

</body>
</html>
