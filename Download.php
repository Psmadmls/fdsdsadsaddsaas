<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าดาวน์โหลด</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* ตั้งค่าฟอนต์สำหรับหน้าเว็บ */
            background-color: #f7f7f7; /* สีพื้นหลัง */
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white; /* สีพื้นหลังของกล่อง */
            border-radius: 8px; /* ขอบมน */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เงา */
            padding: 20px;
            text-align: center;
            width: 300px;
        }
        button {
            background-color: #4CAF50; /* สีพื้นหลังของปุ่ม */
            color: white; /* สีตัวอักษรของปุ่ม */
            padding: 10px 20px; /* ขนาดของปุ่ม */
            border: none; /* ไม่มีขอบ */
            border-radius: 5px; /* ขอบมน */
            cursor: pointer; /* เมาส์เป็นรูปมือเมื่อชี้ที่ปุ่ม */
            font-size: 16px; /* ขนาดตัวอักษร */
            transition: background-color 0.3s; /* แอนิเมชันเมื่อเปลี่ยนสี */
        }
        button:hover {
            background-color: #45a049; /* สีพื้นหลังของปุ่มเมื่อชี้เมาส์ */
        }
    </style>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-16538921097"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-16538921097');
</script>    
</head>
<body>
    <div class="container">
        <p>หน้าดาวน์โหลด:</p>
        <!-- ปุ่มที่เมื่อกดแล้วจะทำการเปลี่ยนหน้า -->
        <button id="redirectButton">กดเพื่อดาวน์โหลด</button>
    </div>

    <script>
        document.getElementById('redirectButton').onclick = function() {
            // ตรวจสอบว่า URL มีพารามิเตอร์ 'link'
            const params = new URLSearchParams(window.location.search);
            if (params.has('link')) {
                const link = params.get('link');
                // ใช้ window.location.href เพื่อเปลี่ยนหน้าไปยังลิงก์ที่ระบุ
                window.location.href = link;
            } else {
                alert('ไม่พบลิงก์ที่จะเปลี่ยนไป!');
            }
        };
    </script>
</body>
</html>
