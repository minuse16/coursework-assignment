import { clothesProducts } from './clothes.js';
import { electronicsProducts } from './electronics.js';

const productsByCategory = {
    clothes: clothesProducts,
    electronics: electronicsProducts
};

window.showCategory = function(category) {
    const container = document.getElementById('product-list');
    container.innerHTML = '';

    const products = productsByCategory[category] || [];
    products.forEach((product, index) => {
        const button = document.createElement('button');
        button.textContent = product.name;
        button.onclick = () => showProductDetails(category, index);
        container.appendChild(button);
    });
};

function showProductDetails(category, index) {
    const product = productsByCategory[category]?.[index];
    if (!product) return;

    const details = document.getElementById('product-info');
    if (!details) return;

    details.innerHTML = `
        <p>รหัสสินค้า : ${product.product_id}</p>
        <p>ชื่อสินค้า : ${product.name}</p>
        <p>รายละเอียด : ${product.description}</p>
        <p>จำนวนสต็อก : ${product.stock}</p>
        <p>คุณสมบัติ :</p>
        <u>
            <li>ขนาด : ${Array.isArray(product.properties.size) ? product.properties.size.join(', ') : product.properties.size}</li>
            <li>สี : ${Array.isArray(product.properties.color) ? product.properties.color.join(', ') : product.properties.color}</li>
            <li>วัสดุ : ${product.properties.material}</li>
        </u>
    `;
}
