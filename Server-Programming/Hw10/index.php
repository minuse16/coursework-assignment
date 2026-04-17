<?php
// เริ่ม session เพื่อใช้ตรวจสอบสถานะล็อกอิน
session_start();

$isCustomerLoggedIn = isset($_SESSION['user']);
$isManagerLoggedIn = isset($_SESSION['manager']);

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "dbhw10");
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// รับค่าจากฟอร์มการค้นหา
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// สร้าง SQL Query พร้อมใช้งาน Prepared Statements
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if (!empty($keyword)) {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $like_keyword = "%" . $keyword . "%";
    $params[] = $like_keyword;
    $params[] = $like_keyword;
}

if (!empty($category)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

// เตรียมและ Bind ค่าพารามิเตอร์
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าร้านค้า</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="header">
        <img src="images/header2.jpg" alt="Logo" class="logo">
        <h1>NUTTHANICHA</h1>

        <!-- แสดงชื่อผู้ใช้หรือลิงก์เข้าสู่ระบบ -->
        <div class="login-info">
            <?php if ($isCustomerLoggedIn): ?>
                <p>ยินดีต้อนรับ, <?php echo $_SESSION['user']; ?> | <a href="logout.php"><button style="margin: 5px;">ล็อกเอาท์</button></a></p>
            <?php elseif ($isManagerLoggedIn): ?>
                <p>ยินดีต้อนรับผู้จัดการ, <?php echo $_SESSION['manager']; ?><br>
                <a href="dashboard.php">จัดการสินค้า</a> | <a href="logout.php"><button style="margin: 5px;">ล็อกเอาท์</button></a></p>
            <?php else: ?>
                <p><a href="login.php">เข้าสู่ระบบลูกค้า</a> | 
                <a href="manager_login.php">เข้าสู่ระบบผู้จัดการ</a></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- ฟอร์มค้นหาสินค้า -->
    <form method="GET" action="index.php" class="search-bar">
        <input type="text" name="keyword" placeholder="ค้นหาสินค้า" value="<?php echo htmlspecialchars($keyword); ?>">
        <button type="submit"><i class="fa-solid fa-magnifying-glass" style="color: #f9f9f9;"></i></button>
    </form>

    <!-- ฟอร์มเลือกหมวดหมู่ -->
    <form method="GET" action="index.php">
        หมวดหมู่ :
        <select name="category" onchange="this.form.submit()">
            <option value="">ทั้งหมด</option>
            <option value="Worldtech" <?php if ($category == 'Worldtech') echo 'selected'; ?>>Worldtech</option>
            <option value="Sony" <?php if ($category == 'Sony') echo 'selected'; ?>>Sony</option>
            <option value="KENWOOD" <?php if ($category == 'KENWOOD') echo 'selected'; ?>>KENWOOD</option>
            <option value="Pioneer" <?php if ($category == 'Pioneer') echo 'selected'; ?>>Pioneer</option>
            <option value="Alpine" <?php if ($category == 'Alpine') echo 'selected'; ?>>Alpine</option>
        </select>
    </form><br>

    <div class="btcategory">
        <a href="index.php?category=Worldtech"><button style="margin: 5px;">Worldtech</button></a>
        <a href="index.php?category=Sony"><button style="margin: 5px;">Sony</button></a>
        <a href="index.php?category=KENWOOD"><button style="margin: 5px;">KENWOOD</button></a>
        <a href="index.php?category=Pioneer"><button style="margin: 5px;">Pioneer</button></a>
        <a href="index.php?category=Alpine"><button style="margin: 5px;">Alpine</button></a>
    </div><br>
    
    <!-- แสดงรายการสินค้า -->
    <div class="product-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <?php if (!empty($row['image_path']) && file_exists($row['image_path'])): ?>
                        <img src="<?php echo $row['image_path']; ?>" alt="รูปสินค้า">
                    <?php else: ?>
                        <p>ไม่มีรูปภาพ</p>
                    <?php endif; ?>
                    <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                    <center><p>ราคา: <?php echo number_format($row['price'], 2); ?> บาท</p></center>
                    <a href="product_details.php?id=<?php echo $row['id']; ?>">ดูรายละเอียด</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>ไม่พบสินค้าที่ตรงกับการค้นหา</p>
        <?php endif; ?>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>