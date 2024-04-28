<?php
session_start();
if (isset($_SESSION['id']) || $_SESSION['id'] == 1) {
    header("location: index.php");
    exit; // Ensure that the script stops here to prevent further execution
}
?>


<?php
session_start();
include_once('functions.php');

$userdata = new DB_con();

if (isset($_POST['signin'])) {
    $uname = $_POST['username'];
    $password = $_POST['password'];

    $result = $userdata->signin($uname, $password);
    if ($result) {
    $_SESSION['id'] = 1; // Set $_SESSION['id'] to 1 upon successful login
    $_SESSION['fname'] = $result['fullname'];
    $_SESSION['uname'] = $uname; // Set $_SESSION['uname'] to the username upon successful login
    echo "<script>alert('Login Successful!');</script>";
    echo "<script>window.location.href='index.php?open=1'</script>";
}
 else {
        echo "<script>alert('Something went wrong! Please try again.');</script>";
        echo "<script>window.location.href='signin.php'</script>";
    }
}

if(isset($_SESSION['fname'])) {
    $fullname = $_SESSION['fname'];
} else {
    $fullname = "Guest";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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

     /* ปุ่มเข้าสู่ระบบ */
     .btn-success {
     background-color: #4CAF50;
     color: white;
     }

     /* ปุ่มลงทะเบียน */
     .btn-primary {
     background-color: #2196F3;
     color: white;
     }

     </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Login Page</h1>
        <hr>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="signin" class="btn btn-success">Login</button>
            <a href="register.php" class="btn btn-primary">Go to Register</a>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</body>
</html>
