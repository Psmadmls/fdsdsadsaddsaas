<?php
session_start(); // เริ่ม session ที่นี่

// ตรวจสอบว่า session 'uname' มีค่าหรือไม่
$uname = isset($_SESSION['uname']) ? $_SESSION['uname'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ส่งข้อมูลไปยัง API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input[type="text"], input[type="file"], input[type="submit"] {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #016e8f;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #004e66;
        }
        .error-message {
            color: #f00;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<form id="myForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <h2>การลงแอดออน</h2>
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name"><br>
    <label for="img">Image:</label><br>
    <input type="file" id="img" name="img"><br>
    <label for="link">Link File:</label><br>
    <input type="file" id="link" name="link"><br><br>
    <input type="submit" value="ส่งข้อมูล">
</form>

<t id="btn1"><a href="index.php">
    <button class="btn-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
    </svg></button></a>
</t>     

<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // ป้องกันการส่งฟอร์มใหม่ที่เปลี่ยนหน้า
        var form = event.target; // เลือกฟอร์มที่ถูกส่งไป
        var uname = "<?php echo $uname; ?>"; // รับค่า uname จาก PHP session ที่ได้รับจากหน้า welcome.php
        if (uname !== "") {
            // สร้าง input hidden เพื่อเก็บค่า uname
            var unameInput = document.createElement('input');
            unameInput.type = 'hidden';
            unameInput.name = 'uname';
            unameInput.value = uname;
            // เพิ่ม input hidden เข้าไปในฟอร์ม
            form.appendChild(unameInput);
            // ส่งฟอร์ม
            form.submit();
        } else {
            alert("Username is not available.");
        }
    });
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    if (!empty($name)) {
        $upload_dir = 'uploads/';
        $link_upload_dir = 'link_uploads/'; // เพิ่มโฟลเดอร์สำหรับ link
        $errors = array();
        $files = array('img', 'link');
        $data = array("name" => $name);

        // เพิ่ม uname เข้าไปในตัวแปร $data
        $data['uname'] = $uname;

        // เพิ่มเวลาลงในตัวแปร $data
        $data['timestamp'] = time(); // หรือใช้ date("Y-m-d H:i:s") ได้เช่นกัน

        // ตรวจสอบว่าไฟล์ img เป็นไฟล์ภาพหรือไม่
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $img_filename = $_FILES['img']['name'];
            $img_tmpname = $_FILES['img']['tmp_name'];
            $img_filetype = exif_imagetype($img_tmpname); // ตรวจสอบประเภทของไฟล์ภาพ

            // รายการประเภทไฟล์ภาพที่ยอมรับ
            $allowed_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);

            if (in_array($img_filetype, $allowed_types)) {
                $img_destination = $upload_dir . $img_filename;

                // โหลดรูปภาพเข้ามาในแรม
                $img = imagecreatefromstring(file_get_contents($img_tmpname));

                // กำหนดค่าคุณภาพของรูปภาพ (0 - 100)
                $quality = 2; // คุณภาพที่ต่ำสุด

                // บันทึกรูปภาพเป็นไฟล์ JPEG ด้วยคุณภาพที่กำหนด
                imagejpeg($img, $img_destination, $quality);

                $data['img'] = $img_destination;
            } else {
                $errors[] = "ไฟล์ที่อัปโหลดไม่ใช่ไฟล์ภาพที่รองรับ (JPEG, PNG, GIF)";
            }
        } else {
            $errors[] = "<script>alert('กรุณาเลือกไฟล์รูปภาพ');</script>";
        }

        // อัปโหลดไฟล์ link
        if (isset($_FILES['link']) && $_FILES['link']['error'] === UPLOAD_ERR_OK) {
            $link_filename = $_FILES['link']['name'];
            $link_destination = $link_upload_dir . $link_filename; // กำหนดโฟลเดอร์ใหม่สำหรับ link
            move_uploaded_file($_FILES['link']['tmp_name'], $link_destination);
            $data['link'] = $link_destination;
        } else {
            $errors[] = "<script>alert('กรุณาเลือกไฟล์ที่จะให้ดาวน์โหลด');</script>";
        }

        if (empty($errors)) {
            $url1 = "https://sheet.best/api/sheets/d4253266-7e5a-436c-bc12-51d3b1b24671"; // URL ของ API แรก
            $url2 = "https://sheet.best/api/sheets/65319c94-ed9a-4508-a3f8-a36cdf6658c2"; // URL ของ API ที่สอง
            $options = array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => 'Content-Type: application/json',
                    'content' => json_encode($data)
                )
            );
            $context  = stream_context_create($options);

            // ส่งข้อมูลไปยัง API แรก
            $result1 = file_get_contents($url1, false, $context);

            // ส่งข้อมูลไปยัง API ที่สอง
            $result2 = file_get_contents($url2, false, $context);

            if ($result1 !== false && $result2 !== false) {
                echo "<script>alert('อัพโหลดเสร็จแล้ว');</script>";
            } else {
                echo "มีข้อผิดพลาดเกิดขึ้น";
            }
        } else {
            foreach ($errors as $error) {
                echo "<div class='error-message'>$error</div>";
            }
        }
    } else {
        echo "<div class='error-message'>กรุณากรอกข้อมูลให้ครบทุกช่อง</div>";
    }
}
?>

</body>
</html>
