<!DOCTYPE html>
<html>
<head>
    <title>Trang Sản Phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li class="dropdown">
                    <a href="#">Phân loại</a>
                    <ul class="dropdown-content">
                        <?php
                            // Kết nối CSDL, truy vấn danh sách phân loại
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "shop_db";

                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Kết nối thất bại: " . $conn->connect_error);
                            }

                            $sqlPhanLoai = "SELECT ten_phan_loai FROM phan_loai";
                            $resultPhanLoai = $conn->query($sqlPhanLoai);
                            while ($rowPhanLoai = $resultPhanLoai->fetch_assoc()) {
                                echo '<li><a href="index.php?phan_loai=' . $rowPhanLoai['ten_phan_loai'] . '">' . $rowPhanLoai['ten_phan_loai'] . '</a></li>';
                            }
                        ?>
                    </ul>
                </li>
                <li><a href="giohang.php">Giỏ hàng</a></li>
            </ul>
        </nav>

        <div class="phan-loai-top">
            <?php
                // Lặp lại danh sách phân loại như trong menu dropdown
                $resultPhanLoai = $conn->query($sqlPhanLoai); // Thực thi lại truy vấn để lấy lại kết quả
                while ($rowPhanLoai = $resultPhanLoai->fetch_assoc()) {
                    echo '<button onclick="filterProducts(\'' . $rowPhanLoai['ten_phan_loai'] . '\')">' . $rowPhanLoai['ten_phan_loai'] . '</button>';
                }
            ?>
        </div>
    </header>

    <div class="container">
        <?php

            // 2. Truy vấn sản phẩm (có thể thêm điều kiện lọc nếu cần)
            if (isset($_GET['phan_loai'])) {
                $phanLoai = $_GET['phan_loai'];
                $sql = "SELECT * FROM sanpham WHERE phan_loai_id = (SELECT id FROM phan_loai WHERE ten_phan_loai = '$phanLoai')";
            } else {
                $sql = "SELECT * FROM sanpham";
            }
            $result = $conn->query($sql);

            // 3. Hiển thị sản phẩm
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Lấy tên phân loại từ bảng phan_loai (nếu có)
                    $phanLoaiId = $row["phan_loai_id"];
                    $sqlPhanLoai = "SELECT ten_phan_loai FROM phan_loai WHERE id = $phanLoaiId";
                    $resultPhanLoai = $conn->query($sqlPhanLoai);
                    $rowPhanLoai = $resultPhanLoai->fetch_assoc();
                    $tenPhanLoai = $rowPhanLoai ? $rowPhanLoai["ten_phan_loai"] : "Chưa phân loại"; // Nếu không có phân loại, hiển thị "Chưa phân loại"

                    echo '<div class="product" data-phanloai="' . $tenPhanLoai . '">';
                    echo '<a href="chitiet.php?id=' . $row["id"] . '">';
                    echo '<img src="images/' . $row["anh"] . '" alt="' . $row["ten_sanpham"] . '">';
                    echo '<h2>' . $row["ten_sanpham"] . '</h2>';
                    echo '<p class="gia">Giá: ' . $row["gia"] . ' VND</p>';
                    echo '</a>';
                    echo '<button class="mua-hang">Mua hàng</button>';

                    // Chi tiết sản phẩm (ẩn ban đầu)
                    echo '<div class="chi-tiet">';
                    echo '<p>' . $row["mo_ta"] . '</p>';
                    echo '</div>';

                    echo '</div>';
                }
            } else {
                echo "Không có sản phẩm nào.";
            }

            $conn->close();
        ?>
    </div>

    <script src="script.js"></script>
    <script>
        function filterProducts(phanLoai) {
            const products = document.querySelectorAll('.product');
            products.forEach(product => {
                if (product.dataset.phanloai === phanLoai || phanLoai === 'all') {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
