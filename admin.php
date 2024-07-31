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

// 2. Xử lý các tác vụ (sửa, xóa) nếu có yêu cầu từ người dùng
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $productId = $_GET['id'];

    if ($action == 'delete') {
        // Xử lý xóa sản phẩm
        $sql = "DELETE FROM sanpham WHERE id = $productId";
        if ($conn->query($sql) === TRUE) {
            echo "Sản phẩm đã được xóa thành công.";
        } else {
            echo "Lỗi khi xóa sản phẩm: " . $conn->error;
        }
    }
}

// 3. Truy vấn tất cả sản phẩm
$sql = "SELECT * FROM sanpham";
$result = $conn->query($sql);

// 4. Hiển thị danh sách sản phẩm
if ($result->num_rows > 0) {
    echo "<h2>Danh sách sản phẩm</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Hành động</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["ten_sanpham"] . "</td>";
        echo "<td>" . $row["gia"] . "</td>";
        echo "<td>";
        echo "<a href='sua_sanpham.php?id=" . $row["id"] . "'>Sửa</a> | ";
        echo "<a href='admin.php?action=delete&id=" . $row["id"] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Không có sản phẩm nào.";
}

// 5. Đóng kết nối
$conn->close();
?>
