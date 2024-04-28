<?php
session_start();
if (isset($_SESSION['id']) || $_SESSION['id'] == 1) {
    header("location: index.php");
    exit; // Ensure that the script stops here to prevent further execution
}
?>

<?php 
    define('API_URL', 'https://sheet.best/api/sheets/f7ba6bef-d7a0-473b-984d-18e9cfbdefca');

    include_once('functions.php'); 

    $userdata = new DB_con();

    if (isset($_POST['submit'])) {
        $fname = $_POST['fullname'];
        $uname = $_POST['username'];
        $uemail = $_POST['email'];
        $password = $_POST['password']; // ไม่มีการเข้ารหัสรหัสผ่าน

        // ตรวจสอบความถูกต้องของข้อมูลก่อนการส่งแบบฟอร์มไปยังเซิร์ฟเวอร์
        if ($fname === '' || $uname === '' || $uemail === '' || $password === '') {
            echo "<script>alert('Please fill in all fields.');</script>";
        } else {
            // เรียกใช้งาน API เพื่อดึงข้อมูลผู้ใช้ทั้งหมด
            $users = $userdata->sendRequest('GET', API_URL);

            // ตรวจสอบว่ามีชื่อผู้ใช้ที่ตรงกับที่ผู้ใช้กรอกมาแล้วหรือไม่
            $usernameExists = false;
            foreach ($users as $user) {
                if ($user['username'] === $uname) {
                    $usernameExists = true;
                    break;
                }
            }

            if ($usernameExists) {
                echo "<script>alert('Username already associated with another account.');</script>";
            } else {
                // ส่งข้อมูลไปยังเซิร์ฟเวอร์เมื่อทุกช่องมีค่าและชื่อผู้ใช้สามารถใช้ได้
                $sql = $userdata->registration($fname, $uname, $uemail, $password);

                if ($sql) {
                    echo "<script>alert('Registration Successful!');</script>";
                    echo "<script>window.location.href='signin.php'</script>";
                } else {
                    echo "<script>alert('Something went wrong! Please try again.');</script>";
                    echo "<script>window.location.href='signin.php'</script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <style>
    /* เพิ่มระยะห่างด้านข้างของ container */
.container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

/* ปรับขนาดและแสดงผลของปุ่ม */
.btn {
    padding: 10px 20px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 5px;
    transition: all 0.3s ease;
}

/* สีพื้นหลังของปุ่มเมื่อเม้าส์ไปวัตถุ */
.btn:hover {
    background-color: #4CAF50;
    color: white;
}

/* รูปแบบหัวเรื่อง */
h1 {
    text-align: center;
    color: #333;
}

/* รูปแบบฟอร์ม */
.form-label {
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

/* ปุ่มสร้างบัญชี */
.btn-success {
    background-color: #4CAF50;
    color: white;
}

/* ลิงก์ไปยังหน้า Sign In */
.btn-primary {
    background-color: #2196F3;
    color: white;
}

    </style>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1300934661334297"
     crossorigin="anonymous"></script>
</head>
<body>

    <div class="container">
        <h1 class="mt-5">Register Page</h1>
        <hr>
        <form method="post">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" class="form-control" id="username" name="username" onblur="checkusername(this.value)">
                <span id="usernameavailable"></span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" name="submit" id="submit" class="btn btn-success">สร้างบัญชี</button>
             <a href="signin.php" class="btn btn-primary">มีบัญแล้ว</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function checkusername(val) {
            $.ajax({
                type: 'POST',
                url: 'checkuser_available.php',
                data: 'username='+val,
                success: function(data) {
                    $('#usernameavailable').html(data);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>
</html>
