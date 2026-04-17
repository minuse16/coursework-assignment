<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$host = "localhost";  // ชื่อโฮสต์ของเซิร์ฟเวอร์ฐานข้อมูล
$dbname = "dbhw9";    // ชื่อฐานข้อมูล
$username = "root";   // ชื่อผู้ใช้ MySQL
$password = "";       // รหัสผ่านของ MySQL

try {
    // สร้างการเชื่อมต่อกับฐานข้อมูล
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // ตั้งค่าโหมดการแสดงข้อผิดพลาด
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // แสดงข้อความข้อผิดพลาดหากการเชื่อมต่อล้มเหลว
    echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
    exit;
}
?>
