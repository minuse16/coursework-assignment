<?php
session_start();
if (!isset($_SESSION['manager'])) {
    header("Location: manager_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "dbhw10");
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่ง ID ของสินค้ามาหรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE id = $id");

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        echo "ไม่พบสินค้าที่ต้องการแก้ไข";
        exit();
    }
} else {
    echo "ไม่มีการระบุ ID ของสินค้า";
    exit();
}

// อัปเดตข้อมูลสินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, stock_quantity=?, category=? WHERE id=?");
    $stmt->bind_param("ssdssi", $name, $description, $price, $stock_quantity, $category, $id);

    if ($stmt->execute()) {
        echo "อัปเดตข้อมูลสินค้าสำเร็จ";
        header("Location: dashboard.php"); // เปลี่ยนเส้นทางไปยังหน้าจัดการสินค้า
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลสินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <img src="images/header2.jpg" alt="Logo" class="logo">
        <h1>NUTTHANICHA</h1>
    </div>

    <center><h2>แก้ไขสินค้า</h2></center>
    <form method="POST" action="">
        ชื่อสินค้า : <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>
        รายละเอียดสินค้า :
        <textarea name="description" rows="4" cols="50" required><?php echo $product['description']; ?></textarea><br>
        ราคา : <input type="number" name="price" value="<?php echo $product['price']; ?>" required><br>
        จำนวนในสต็อก : <input type="number" name="stock_quantity" value="<?php echo $product['stock_quantity']; ?>" required><br>
        หมวดหมู่ :
        <select name="category" required>
            <option value="Worldtech" <?php if ($product['category'] == 'Worldtech') echo 'selected'; ?>>Worldtech</option>
            <option value="Sony" <?php if ($product['category'] == 'Sony') echo 'selected'; ?>>Sony</option>
            <option value="KENWOOD" <?php if ($product['category'] == 'KENWOOD') echo 'selected'; ?>>KENWOOD</option>
            <option value="Pioneer" <?php if ($product['category'] == 'Pioneer') echo 'selected'; ?>>Pioneer</option>
            <option value="JBL" <?php if ($product['category'] == 'JBL') echo 'selected'; ?>>JBL</option>
        </select><br>
        <button type="submit">บันทึกการเปลี่ยนแปลง</button>
    </form><br>
    <a href="dashboard.php">กลับไปหน้าจัดการสินค้า</a>
</body>
</html>
