<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $province = $_POST['province'];
    $email = $_POST['email'];

    // ตรวจสอบรหัสผ่าน
    if ($password !== $_POST['confirm_password']) {
        echo "<h3>รหัสผ่านไม่ตรงกัน</h3>";
        echo "<button onclick=\"window.history.back();\">ย้อนกลับไปยังหน้าสมัครสมาชิก</button>";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        echo "<h3>รหัสผ่านต้องมีอย่างน้อย 8 ตัว รวมถึงตัวพิมพ์ใหญ่ ตัวพิมพ์เล็ก และตัวเลข</h3>";
        echo "<button onclick=\"window.history.back();\">ย้อนกลับไปยังหน้าสมัครสมาชิก</button>";
    } else {
        // เข้ารหัสรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // ตรวจสอบว่าชื่อผู้ใช้หรืออีเมลซ้ำหรือไม่
        $stmt = $conn->prepare("SELECT * FROM customers WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // ถ้ามีการซ้ำ ให้แสดงข้อความและปุ่มย้อนกลับ
            echo "<h3>ชื่อผู้ใช้หรืออีเมลนี้มีอยู่แล้ว</h3>";
            echo "<button onclick=\"window.history.back();\">ย้อนกลับไปยังหน้าสมัครสมาชิก</button>";
        } else {

        // เพิ่มข้อมูลลงในฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO customers (username, password, first_name, last_name, gender, age, province, email) VALUES (:username, :password, :first_name, :last_name, :gender, :age, :province, :email)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':email', $email);
        
        if ($stmt->execute()) {
            echo "<h3>สมัครสมาชิกสำเร็จ!<h3>";
            echo '<button><a href="index.html">เข้าสู่หน้าล็อคอิน</a></button>'; // ไปยังหน้าเข้าสู่ระบบเมื่อสมัครสมาชิกสำเร็จ
            exit;
        } else {
            echo "<h3>เกิดข้อผิดพลาดในการสมัครสมาชิก</h3>";
            echo "<button onclick=\"window.history.back();\">ย้อนกลับไปยังหน้าสมัครสมาชิก</button>";
        }
    }
    }
}
?>