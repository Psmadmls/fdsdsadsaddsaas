<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id']) || $_SESSION['id'] !== 1) {
    header("location: signin.php");
    exit; // Ensure that the script stops here to prevent further execution
}

// Check if the uname is sent through a form from welcome.php
if(isset($_POST['uname'])) {
    $uname = $_POST['uname'];
    // Proceed with the value of $uname
} else {
    echo "<p>No username provided.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 400px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: 2px solid #ccc;
    transition: transform 0.3s ease;
}

img:hover {
    transform: scale(1.05);
    border-color: #aaa;
}

p {
    margin: 0;
    padding: 10px 20px;
    color: #333;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    background-color: rgba(255, 255, 255, 0.8);
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #ff6347;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #ff473d;
}
#Logout {
  position: absolute;
  top: 0;
  left: 0;
  margin: 20px; /* ปรับขอบรอบตามต้องการ */
}
    </style>
</head>
<body>
<a href="logout.php" id="Logout">Logout</a>
    <div class="container">
        <?php
        // Check if the uname is received through a form
        if(isset($uname)) {
            // ดึงข้อมูลจาก API
            $api_data = file_get_contents('https://sheet.best/api/sheets/d4253266-7e5a-436c-bc12-51d3b1b24671');
            
            // แปลงข้อมูล JSON เป็น associative array
            $user_data = json_decode($api_data, true);
            
            // ตรวจสอบข้อมูลและแสดงผล
            if (!empty($user_data)) {
                foreach ($user_data as $user) {
                    if ($user['uname'] === $uname) {
                        echo "<div>";
                        echo "<p><a href='Download.php?link=" . $user['link'] . "'><img src='" . $user['img'] . "' alt='User Image'></a></p>";
                        echo "<p>" . $user['name'] . "</p>"; // แสดงชื่อผู้ใช้ด้านล่างภาพ

                        // เพิ่มปุ่ม Delete และให้เรียกใช้ JavaScript function deleteUser()
                        echo "<button onclick='deleteUser(\"" . $user['uname'] . "\")'>Delete</button>";

                        echo "</div>";
                    }
                }
            } else {
                echo "<p>No data found.</p>";
            }
        } else {
            echo "<p>No username provided.</p>";
        }
        ?>
    </div>
<script>
    function deleteUser(uname) {
    // แสดงกล่องข้อความยืนยันก่อนลบ
    if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')) {
        fetch('https://sheet.best/api/sheets/d4253266-7e5a-436c-bc12-51d3b1b24671')
        .then(response => response.json())
        .then(data => {
            const user = data.find(user => user.uname === uname);
            const index = data.indexOf(user);

            if (index !== -1) {
                fetch(`https://sheet.best/api/sheets/d4253266-7e5a-436c-bc12-51d3b1b24671/${index}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Data deleted successfully.');
                        // หน่วงเวลาก่อนรีโหลดหน้าเพื่อให้แน่ใจว่าเซิร์ฟเวอร์ได้แสดงผลการลบข้อมูลแล้ว
                        setTimeout(() => location.reload(), 1000); // รีโหลดหน้าหลังจาก 1 วินาที
                    } else {
                        console.error('Error deleting data:', response.statusText);
                    }
                })
                .catch(error => console.error('Error deleting data:', error));
            } else {
                console.log('User not found.');
            }
        })
        .catch(error => console.error('Error fetching data:', error));
    } else {
        // หากผู้ใช้ยกเลิกการลบข้อมูล
        console.log('Deletion cancelled.');
    }
}
</script>
</body>
</html>
