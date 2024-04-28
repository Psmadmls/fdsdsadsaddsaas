<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['id'] !== 1) {
    header("location: signin.php");
    exit; // Ensure that the script stops here to prevent further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
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
        
        /* ส่วนที่เพิ่มเข้ามา */
        #popup {
            border-radius: 20px;
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            height: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        df {
            display: none;
        }

        divv {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: transparent; 
            display: flex;
            justify-content: center;
            align-items: center;
            grid-template-columns: repeat(aoto-fit, ifn);
        }

        button { 
            padding: 10px 30px;
            border: 0px;
            background-color: transparent;
            border-radius: 30px;
        }

        .btn-1 {
            background-color: rgb(149, 79, 247);
            border-radius: 30px;
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
    <h1 class="mt-5"><?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : "Guest"; ?></h1>
<divv>
    <nav>
        <t id="btn1"><a href="index.php">
            <button class="btn-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
            </svg></button></a>
        <t id="btn2"><a href="index1.php">
            <button class="btn-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg></button>
        </a>
        <t id="btn3">
    <button class="btn-1" onclick="submitForm()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-plus" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
            <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622-.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z"/>
        </svg>
    </button>
</t>

<script>
    function submitForm() {
        var fname = document.querySelector('h1.mt-5').textContent.trim();
        if (fname !== '') {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'up.php';

            var fnameInput = document.createElement('input');
            fnameInput.type = 'hidden';
            fnameInput.name = 'fname';
            fnameInput.value = fname;

            form.appendChild(fnameInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Fname is not available.');
        }
    }
</script>

        <form id="categoryForm">
        <select id="category">
            <option value="all">ทั้งหมด</option>
            <option value="addon">Addon</option>
            <option value="map">Map</option>
        </select>
    </form>
    </nav>
</divv>
<div class="container">
    <div id="places"></div>
</div>
<script>
    // When the h1 element is clicked
    document.querySelector('h1').addEventListener('click', function() {
        var uname = "<?php echo isset($_SESSION["uname"]) ? $_SESSION["uname"] : ""; ?>";
        if (uname !== "") {
            // Create a form and submit it to Profile.php using POST method
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'Profile.php';
            // Create a hidden input field to hold the username value
            var unameInput = document.createElement('input');
            unameInput.type = 'hidden';
            unameInput.name = 'uname';
            unameInput.value = uname;
            // Append the input field to the form
            form.appendChild(unameInput);
            // Append the form to the document body and submit it
            document.body.appendChild(form);
            form.submit();
        } else {
            alert("Username is not available.");
        }
    });
</script>
<script>
    // When the h1 element is clicked
    document.querySelector('#submitForm').addEventListener('click', function() {
        var uname = "<?php echo isset($_SESSION["uname"]) ? $_SESSION["uname"] : ""; ?>";
        if (uname !== "") {
            // Create a form and submit it to Profile.php using POST method
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'up.php';
            // Create a hidden input field to hold the username value
            var unameInput = document.createElement('input');
            unameInput.type = 'hidden';
            unameInput.name = 'uname';
            unameInput.value = uname;
            // Append the input field to the form
            form.appendChild(unameInput);
            // Append the form to the document body and submit it
            document.body.appendChild(form);
            form.submit();
        } else {
            alert("Username is not available.");
        }
    });
</script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            let locations = [];  // This will hold the fetched location data

            const placesContainer = document.getElementById('places');
            const categorySelector = document.getElementById('category');

            // Fetch data from API and initialize
            fetch('https://sheet.best/api/sheets/65319c94-ed9a-4508-a3f8-a36cdf6658c2')
                .then(response => response.json())
                .then(data => {
                    locations = data;  // Update locations with the fetched data
                    showPlaces('all'); // Show all locations initially
                });

            categorySelector.addEventListener('change', function () {
                showPlaces(categorySelector.value);
            });

            function showPlaces(category) {
                const filteredLocations = locations.filter(location => 
                    category === 'all' || location['ประเภท'].toLowerCase() === category.toLowerCase()
                );

                placesContainer.innerHTML = ''; // Clear previous content

                filteredLocations.forEach(location => {
                    const placeElement = document.createElement('div');
                    placeElement.classList.add('frame');

                    const linkElement = document.createElement('a');
                    linkElement.href = 'Download.php?link=' + encodeURIComponent(location.link);

                    const imageElement = document.createElement('img');
                    imageElement.src = location.img;
                    imageElement.alt = location.name;

                    linkElement.appendChild(imageElement);

                    const nameElement = document.createElement('p');
                    nameElement.textContent = location.name;

                    const unameLinkElement = document.createElement('a');
                    unameLinkElement.href = `test.php?uname=${encodeURIComponent(location.uname)}`;
                    unameLinkElement.textContent = 'Username: ' + location.uname;
                    unameLinkElement.style.display = 'block';  // Ensure this is on a new line

                    placeElement.appendChild(linkElement);
                    placeElement.appendChild(nameElement);
                    placeElement.appendChild(unameLinkElement);
                    placesContainer.appendChild(placeElement);
                });
            }
        });
    </script>

</body>
</html>
