<?php
session_start();  // เริ่มต้น session
$conn = new mysqli("localhost", "root", "", "dbhw10");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบผู้ใช้จากฐานข้อมูล
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];  // เก็บ username ใน session
            header("Location: index.php");  // ย้ายไปหน้า index
            exit();  // หยุดการทำงานของสคริปต์
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบผู้ใช้";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ล็อกอินลูกค้า</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <center><h1>ล็อกอินลูกค้า</h1></center>
    <form method="POST" action="login.php">
        <label for="username">ชื่อผู้ใช้ : </label>
        <input type="text" name="username" required><br>
        <label for="password">รหัสผ่าน : </label>
        <input type="password" name="password" required><br>
        <center><h2>ยังไม่ได้ลงทะเบียน? <a href="register.php">สมัครสมาชิกที่นี่</a></h2>
        <button type="submit">ล็อกอิน</button></center>
    </form><br>

    <a href="index.php">กลับไปหน้าหลัก</a>
</body>
</html>