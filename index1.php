<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Search</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #searchInput {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .user-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .user {
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
    }

    .user img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .user h3 {
        margin: 0;
    }

</style>
</head>
<body>
<div class="container">
    <form method="GET" action="">
        <input type="text" id="searchInput" name="search" placeholder="Search...">
    </form>
    <div class="user-list" id="userList">
        <?php
        if(isset($_GET['search'])) {
            $searchTerm = strtolower($_GET['search']);
            $data = file_get_contents("https://sheet.best/api/sheets/d4253266-7e5a-436c-bc12-51d3b1b24671");
            $users = json_decode($data, true);

            foreach ($users as $user) {
                if (strpos(strtolower($user['name']), $searchTerm) !== false) {
                    echo '<div class="user">';
                    echo '<img src="' . $user['img'] . '" alt="' . $user['name'] . '" onclick="window.location.href=\'Download.php?link=' . urlencode($user['link']) . '\'">';
                    echo '<h3>' . $user['name'] . '</h3>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</div>
</body>
</html>
