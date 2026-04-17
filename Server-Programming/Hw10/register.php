<?php
$conn = new mysqli("localhost", "root", "", "dbhw10");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            header("Location: login.php");
        } else {
            echo "ชื่อผู้ใช้หรืออีเมลนี้มีในระบบแล้ว";
        }
    } else {
        echo "รหัสผ่านไม่ตรงกัน";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <h3>ลงทะเบียนลูกค้า</h3>
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
        <center><button type="submit">สมัครสมาชิก</button></center>
    </form><br>
    <center><a href="login.php">มีบัญชีแล้ว? เข้าสู่ระบบ</a></center><br>
</body>
</html>
