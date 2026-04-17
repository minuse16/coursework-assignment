<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dbhw10");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    if ($password !== $confirm_password) {
        echo "รหัสผ่านไม่ตรงกัน";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/", $password)) {
        echo "รหัสผ่านต้องมีอย่างน้อย 8 ตัว และมีตัวเลข, ตัวพิมพ์ใหญ่, และตัวพิมพ์เล็ก";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO managers (username, password, first_name, last_name, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $hashed_password, $first_name, $last_name, $email);

        if ($stmt->execute()) {
            echo "ลงทะเบียนผู้จัดการสำเร็จ!";
        } else {
            echo "ชื่อผู้ใช้หรืออีเมลนี้มีในระบบแล้ว";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <title>ลงทะเบียนผู้จัดการ</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <h3>ลงทะเบียนผู้จัดการ</h3>
    <form method="POST">
        <label for="username">ชื่อผู้ใช้ : </label>
        <input type="text" name="username" required><br>
        <label for="username">รหัสผ่าน : </label>
        <input type="password" name="password" required><br>
        <label for="username">ยืนยันรหัสผ่าน : </label>
        <input type="password" name="confirm_password" required><br>
        <label for="firstname">ชื่อ : </label>
        <input type="text" name="first_name" required><br>
        <label for="lastname">นามสกุล : </label>
        <input type="text" name="last_name" required><br>
        <label for="email">Email : </label>
        <input type="email" name="email" required><br>
        <center><button type="submit">ลงทะเบียน</button></center>
    </form><br>
    <center><a href="manager_login.php">มีบัญชีแล้ว? เข้าสู่ระบบ</a></center><br>
</body>
</html>
