<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Specific Details</title>
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

        .frame {
            border: 2px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
        }
         h1 {
    position: absolute;
    top: 0;
    left: 0;
    margin: 20px; /* ปรับขอบรอบตามต้องการ */
}
    </style>
</head>
<body>
    <?php
    // Check if 'uname' is present in the query string
    if (isset($_GET['uname'])) {
        $uname = $_GET['uname'];  // Get the 'uname' from URL
        $api_url = "https://sheet.best/api/sheets/d4253266-7e5a-436c-bc12-51d3b1b24671";
        $json_data = file_get_contents($api_url);
        $data = json_decode($json_data, true);
        $found = false;  // Flag to check if the uname is found

        // Iterate through each entry in the API data
        foreach ($data as $entry) {
            // Check if the current entry's uname matches the uname from URL
            if ($entry['uname'] === $uname) {
                echo '<div class="frame">';
                echo '<a href="Download.php?link=' . urlencode($entry['link']) . '">';
                echo '<img src="' . htmlspecialchars($entry['img']) . '" alt="' . htmlspecialchars($entry['name']) . '">';
                echo '</a>';
                echo '<p>' . htmlspecialchars($entry['name']) . '</p>';
                echo '</div>';
                $found = true;  // Set the flag to true since uname is found
            }
        }

        // If no matching uname is found, show a message
        if (!$found) {
            echo '<p>No user found with that username.</p>';
        }
    } else {
        echo '<p>No username provided.</p>';  // Display error if no uname parameter is provided
    }
    ?>
<h1 class="mt-5"><?php  echo '<p>ผู้สร้างสร้าง: ' . htmlspecialchars($entry['uname']) . '</p>'; ?></h1>    
</body>
</html>
