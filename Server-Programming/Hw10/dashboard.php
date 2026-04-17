<?php
session_start();
if (!isset($_SESSION['manager'])) {
    header("Location: manager_login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "dbhw10");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

function truncate_string($string, $length) {
    if (mb_strlen($string) > $length) {
        // ตัดที่ความยาวที่กำหนด
        $truncated = mb_substr($string, 0, $length);
        // ตรวจสอบว่าคำสุดท้ายเป็นคำเต็มหรือไม่
        if (mb_substr($string, $length, 1) != ' ') {
            // ถ้าตัดกลางคำให้ย้อนกลับไปหาตำแหน่งเว้นวรรคสุดท้าย
            $last_space = mb_strrpos($truncated, ' ');
            if ($last_space !== false) {
                $truncated = mb_substr($truncated, 0, $last_space);
            }
        }
        return $truncated . '...'; // เพิ่ม '...' ต่อท้าย
    }
    return $string; // ถ้าไม่เกินความยาวให้ส่งคืนข้อความเดิม
}

// ดึงข้อมูลสินค้าทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แดชบอร์ดผู้จัดการ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
</head>
<body>
    <div class="header">
        <img src="images/header2.jpg" alt="Logo" class="logo">
        <h1>NUTTHANICHA</h1>
        <h2>ยินดีต้อนรับ, <?= $_SESSION['manager'] ?></h2>
    </div>

    <center><h2>รายการสินค้าทั้งหมด</h2></center>
    <table border="1">
        <tr>
            <th>ชื่อสินค้า</th>
            <th>รายละเอียด</th>
            <th>ราคา</th>
            <th>จำนวนในสต็อก</th>
            <th>หมวดหมู่</th>
            <th>ภาพ</th>
            <th>แก้ไข, ลบ</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo truncate_string($row['description'], 100); ?></td>
                    <td><?php echo $row['price']; ?> บาท</td>
                    <td><?php echo $row['stock_quantity']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><img src="<?php echo $row['image_path']; ?>" width="50" height="50" alt="รูปสินค้า"></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>"><span class="material-symbols-outlined">edit</span></a>
                        <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้านี้?');"><span class="material-symbols-outlined">delete</span></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">ไม่พบสินค้าที่มีอยู่</td>
            </tr>
        <?php endif; ?>
    </table><br>
    <center><a href="add_product.php"><button style="margin: 5px;">เพิ่มสินค้า</button></a></center><br>
    <a href="index.php">กลับไปยังหน้าแรก</a><br>
    <?php
    // ปิดการเชื่อมต่อ
    $conn->close();
    ?>
</body>
</html>
