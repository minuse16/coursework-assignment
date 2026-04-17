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

// ตรวจสอบว่ามีการส่ง ID ของสินค้ามาหรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // สร้างคำสั่ง SQL สำหรับการลบสินค้า
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // ทำการลบและตรวจสอบผล
    if ($stmt->execute()) {
        echo "ลบสินค้าสำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการลบ: " . $stmt->error;
    }

    // ปิด statement
    $stmt->close();
}

// เปลี่ยนเส้นทางกลับไปยังหน้าแดชบอร์ดผู้จัดการ
header("Location: dashboard.php"); // แก้ไขให้ตรงกับชื่อไฟล์แดชบอร์ดของคุณ
$conn->close();
?>
