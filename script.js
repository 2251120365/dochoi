// Ví dụ: Thêm sản phẩm vào giỏ hàng (chưa hoàn chỉnh)
const addToCartButtons = document.querySelectorAll('.product button');

addToCartButtons.forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.parentElement.querySelector('a').href.split('=')[1];
        // Thêm sản phẩm vào giỏ hàng (sử dụng localStorage hoặc gửi AJAX request)
        alert(`Sản phẩm ${productId} đã được thêm vào giỏ hàng!`);
    });
});

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
