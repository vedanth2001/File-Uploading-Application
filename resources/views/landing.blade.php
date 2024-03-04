<!-- resources/views/landing.blade.php -->

<!-- resources/views/landing.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the File Uploader System!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 50px 20px;
            text-align: center;
        }
        h1 {
            color: #000000;
            margin-bottom: 30px;
            text-align: center;
        }
        p {
            color: #000000;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FFA500;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0000FF;
        }
        ul {
    text-align: left; /* Align list items to the left */
        }

        /* Style the bullet points */
        ul li {
            list-style: none; /* Remove default bullet points */
            margin-left: 20px; /* Adjust the space between the bullet points and the text */
            position: relative; /* Position the custom bullet points relative to the list items */
        }

        ul li::before {
            content: '\2022'; /* Unicode character for bullet point */
            color: #FFA500; /* Color of the bullet points */
            font-size: 20px; /* Adjust the size of the bullet points */
            position: absolute; /* Position the bullet points absolutely */
            left: -20px; /* Adjust the position of the bullet points */
            top: 4px; /* Adjust the vertical position of the bullet points */
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Welcome to the File Uploader System!</h1>
        <p>Upload various types of files including:</p>
        <ul>
            <li>Restaurant menus</li>
            <li>Restaurant images (logos, food photos, ambiance photos)</li>
            <li>Restaurant videos (chef interviews, restaurant tours)</li>
            <li>User profile pictures</li>
            <li>User uploaded images</li>
            <li>Booking documents (reservation documents, invoices)</li>
            <li>Banners (app home banner, web home banner, payeazy offer banner)</li>
        </ul>
        <p>Click the button below to upload files.</p>
        <a href="/upload" class="btn">Start Uploading Files</a>
    </div>
    </body>
</html>
