<?php

function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// ตรวจสอบว่ามีการส่งฟอร์มเข้ามาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize($_POST['name']);
    $age = sanitize($_POST['age']);
    $birthdate = sanitize($_POST['birthdate']);
    $organization = sanitize($_POST['organization']);
    $address = sanitize($_POST['address']);
    $village = sanitize($_POST['village']);
    $soi = sanitize($_POST['soi']);
    $street = sanitize($_POST['street']);
    $subdistrict = sanitize($_POST['subdistrict']);
    $district = sanitize($_POST['district']);
    $province = sanitize($_POST['province']);
    $postalcode = sanitize($_POST['postalcode']);
    $occupation = sanitize($_POST['occupation']);
    $workplace = sanitize($_POST['workplace']);
    $homephone = sanitize($_POST['homephone']);
    $mobilephone = sanitize($_POST['mobilephone']);

    // แสดงข้อมูลที่ได้รับ
    echo "<!DOCTYPE html>
    <html lang='th'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>ผลการสมัครสมาชิก</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
        <div class='result'>
            <h2>ผลการสมัครสมาชิก</h2>
            <div class='field'><label><b>ชื่อ :</b> $name</label></div>
            <div class='field'><label><b>อายุ :</b> $age ปี</label></div>
            <div class='field'><label><b>เกิดวันที่ :</b> $birthdate</label></div>
            <div class='field'><label><b>ในนาม :</b> $organization</label></div>
            <div class='field'><label><b>อยู่บ้านเลขที่ :</b> $address</label></div>
            <div class='field'><label><b>หมู่ :</b> $village</label></div>
            <div class='field'><label><b>ซอย :</b> $soi</label></div>
            <div class='field'><label><b>ถนน :</b> $street</label></div>
            <div class='field'><label><b>ตำบล :</b> $subdistrict</label></div>
            <div class='field'><label><b>อำเภอ :</b> $district</label></div>
            <div class='field'><label><b>จังหวัด :</b> $province</label></div>
            <div class='field'><label><b>รหัสไปรษณีย์ :</b> $postalcode</label></div>
            <div class='field'><label><b>อาชีพ :</b> $occupation</label></div>
            <div class='field'><label><b>ทำงานที่ :</b> $workplace</label></div>
            <div class='field'><label><b>เบอร์โทรศัพท์บ้าน/ที่ทำงาน :</b> $homephone</label></div>
            <div class='field'><label><b>หมายเลขโทรศัพท์มือถือ :</b> $mobilephone</label></div>
        </div>
    </body>
    </html>";
} else {
    echo "ข้อมูลไม่ถูกส่งมา";
}
