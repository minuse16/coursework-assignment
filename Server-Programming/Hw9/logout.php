<?php
session_start();
session_unset(); // ลบข้อมูลเซสชันทั้งหมด
session_destroy(); // ทำลายเซสชัน

header("Location: index.html"); // กลับไปยังหน้าล็อกอิน
exit();
?>
