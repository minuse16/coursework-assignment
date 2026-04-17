<?php
// เริ่ม session
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการล็อกอินแล้วหรือไม่
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['username'] === 'admin') {
        header("Location: showdata.php"); // ถ้าล็อกอินแล้ว ให้ไปที่หน้าแดชบอร์ดของ Admin
    }
}

$error_message = ""; // สำหรับเก็บข้อความผิดพลาด

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบชื่อผู้ใช้และรหัสผ่านสำหรับ Admin
    if ($username === 'admin' && $password === '1234') {
        $_SESSION['user_id'] = '1'; // ตั้ง ID ของผู้ใช้เป็นค่าคงที่สำหรับแอดมิน
        header("Location: showdata.php"); // ไปที่หน้าแดชบอร์ด
        exit;
    }

    // ตรวจสอบชื่อผู้ใช้และรหัสผ่านสำหรับลูกค้า
    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลผู้ใช้จากฐานข้อมูล

    // ตรวจสอบรหัสผ่าน
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // ตั้งค่า session ของลูกค้า
        $_SESSION['username'] = $user['username'];
        echo "ล็อคอินสำเร็จ!";
        echo '<br><button><a href="logout.php">ล็อคเอาต์</a></button>'; // ไปที่หน้าข้อมูลลูกค้า
        exit;
    } else {
        echo "<h3>ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</h3>"; // แสดงข้อความผิดพลาด
        echo "<button onclick=\"window.history.back();\">ย้อนกลับไปยังหน้าล็อคอิน</button>";
    }
}
?>