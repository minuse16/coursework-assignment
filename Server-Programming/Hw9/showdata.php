<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ดึงข้อมูลลูกค้าจากฐานข้อมูล
$stmt = $conn->prepare("SELECT * FROM customers");
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>ข้อมูลสมาชิกทั้งหมด</h2>";
echo "<table border='1'>";
echo "<tr><th>ลำดับ</th><th>ชื่อผู้ใช้</th><th>ชื่อ</th><th>นามสกุล</th><th>เพศ</th><th>อายุ</th><th>จังหวัด</th><th>อีเมล</th></tr>";

foreach ($customers as $customer) {
    echo "<tr>";
    echo "<td>" . $customer['id'] . "</td>";
    echo "<td>" . $customer['username'] . "</td>";
    echo "<td>" . $customer['first_name'] . "</td>";
    echo "<td>" . $customer['last_name'] . "</td>";
    echo "<td>" . $customer['gender'] . "</td>";
    echo "<td>" . $customer['age'] . "</td>";
    echo "<td>" . $customer['province'] . "</td>";
    echo "<td>" . $customer['email'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// เพิ่มลิงก์ล็อกเอาต์
echo '<br><button><a href="logout.php">ล็อคเอาต์</a></button>';
?>