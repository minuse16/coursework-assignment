<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dbhw10");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $manager = $result->fetch_assoc();
        if (password_verify($password, $manager['password'])) {
            $_SESSION['manager'] = $manager['username'];
            header("Location: index.php");
            exit();
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบผู้จัดการ";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ล็อกอินผู้จัดการ</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <h1>ล็อกอินผู้จัดการ</h1>
    <form method="POST" action="manager_login.php">
        <label for="username">ชื่อผู้ใช้:</label>
        <input type="text" name="username" required><br>
        <label for="password">รหัสผ่าน:</label>
        <input type="password" name="password" required><br>
        <center><h2>ยังไม่ได้ลงทะเบียนผู้จัดการ? <a href="register_manager.php">ลงทะเบียนที่นี่</a></h2>
        <button type="submit">ล็อกอิน</button></center>
    </form><br>

    <a href="index.php">กลับไปหน้าหลัก</a>
</body>
</html>
