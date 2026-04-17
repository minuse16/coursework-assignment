<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "upload_img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // ย้ายไฟล์ที่อัปโหลดไปยังโฟลเดอร์เป้าหมาย
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // เชื่อมต่อกับฐานข้อมูล
        $conn = new mysqli("localhost", "root", "", "dbhw10");

        // ตรวจสอบการเชื่อมต่อ
        if ($conn->connect_error) {
            die("การเชื่อมต่อผิดพลาด: " . $conn->connect_error);
        }

        // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock_quantity = $_POST['stock_quantity'];
        $category = $_POST['category'];
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity, category, image_path) VALUES (?, ?, ?, ?, ?, ?)");

        // ตั้งค่า parameter
        $stmt->bind_param("ssdiss", $name, $description, $price, $stock_quantity, $category, $target_file);

        // ทำการ execute คำสั่ง
        if ($stmt->execute()) {
            echo "อัปโหลดและบันทึกข้อมูลสินค้าสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }

        // ปิดการเชื่อมต่อ
        $stmt->close();
        $conn->close();
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลด";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <img src="images/header2.jpg" alt="Logo" class="logo">
        <h1>NUTTHANICHA</h1>
    </div>

    <center><h2>เพิ่มสินค้า</h2></center>
    <form method="POST" enctype="multipart/form-data">
        ชื่อสินค้า : <input type="text" name="name" required><br>
        รายละเอียดสินค้า : <textarea name="description" rows="4" cols="50" required></textarea><br>
        ราคา : <input type="number" name="price" required><br>
        จำนวนในสต็อก : <input type="number" name="stock_quantity" required><br>
        หมวดหมู่ : 
        <select name="category" required>
            <option value="">เลือกหมวดหมู่</option>
            <option value="Worldtech">Worldtech</option>
            <option value="Sony">Sony</option>
            <option value="KENWOOD">KENWOOD</option>
            <option value="Pioneer">Pioneer</option>
            <option value="Alpine">Alpine</option>
        </select><br>
        เลือกรูปภาพ: <input type="file" name="image" required><br>
        <button type="submit">ยืนยัน</button>
    </form><br>
    <a href="dashboard.php">กลับไปหน้าจัดการสินค้า</a>
</body>
</html>
