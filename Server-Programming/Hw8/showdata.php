<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbhw8";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลสมาชิก
$sql = "SELECT * FROM members";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูลสมาชิก</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>ข้อมูลสมาชิก</h2>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>ลำดับที่</th>
                    <th>ชื่อ</th>
                    <th>อายุ</th>
                    <th>วันเกิด</th>
                    <th>หน่วยงาน</th>
                    <th>ที่อยู่</th>
                    <th>หมู่</th>
                    <th>ซอย</th>
                    <th>ถนน</th>
                    <th>ตำบล</th>
                    <th>อำเภอ</th>
                    <th>จังหวัด</th>
                    <th>รหัสไปรษณีย์</th>
                    <th>อาชีพ</th>
                    <th>ทำงานที่</th>
                    <th>เบอร์โทรศัพท์บ้าน/ที่ทำงาน</th>
                    <th>หมายเลขโทรศัพท์มือถือ</th>
                </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["age"] . "</td>
                    <td>" . $row["birthdate"] . "</td>
                    <td>" . $row["organization"] . "</td>
                    <td>" . $row["address"] . "</td>
                    <td>" . $row["village"] . "</td>
                    <td>" . $row["soi"] . "</td>
                    <td>" . $row["street"] . "</td>
                    <td>" . $row["subdistrict"] . "</td>
                    <td>" . $row["district"] . "</td>
                    <td>" . $row["province"] . "</td>
                    <td>" . $row["postalcode"] . "</td>
                    <td>" . $row["occupation"] . "</td>
                    <td>" . $row["workplace"] . "</td>
                    <td>" . $row["homephone"] . "</td>
                    <td>" . $row["mobilephone"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='16'>ไม่มีข้อมูลสมาชิก</td></tr>";
        }
        $conn->close();
        ?>
    </table>
        </div>
    </main>
</body>
</html>