<?php
// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "dbhw10");
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลสินค้าตาม ID
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดสินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <img src="images/header2.jpg" alt="Logo" class="logo">
        <h1>NUTTHANICHA</h1>
    </div>

    <h1><?php echo $product['name']; ?></h1>
    <center><img src="<?php echo $product['image_path']; ?>" width="300" height="400" alt="รูปสินค้า"></center>
    <p>รายละเอียด : <?php echo $product['description']; ?></p>
    <p>ราคา : <?php echo $product['price']; ?> บาท</p>
    <p>จำนวนคงเหลือ : <?php echo $product['stock_quantity']; ?> ชิ้น</p>

    <button onclick = window.history.back();>ย้อนกลับ</button>

    <?php $conn->close(); ?>
</body>
</html>
