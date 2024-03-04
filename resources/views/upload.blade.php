<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        #fileInput {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error-text {
            color: red;
        }
        #uploadButton {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #uploadButton:hover {
            background-color: #0056b3;
        }
        .progress {
            height: 20px;
            margin-bottom: 20px;
            overflow: hidden;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .progress-bar {
            height: 100%;
            background-color: #007bff;
            border-radius: 5px;
            transition: width 0.3s ease;
        }
        .message {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>File Upload</h1>
        <form id="uploadForm" action="/upload" method="post" enctype="multipart/form-data">
            <!-- @csrf CSRF token -->
            <div class="form-group">
                <select id="folderSelect" name="folder">
                    <option value="">Select Folder</option>
                    <!-- Generate options dynamically -->
                    <?php
                        // Sample array representing project hierarchy
                        $folders = [
                            'file-uploading1' => [
                                'restaurant_data' => [
                                    'menus',
                                    'images' => [
                                        'restaurant_logos',
                                        'food_photos',
                                        'ambiance_photos'
                                    ],
                                    'videos' => [
                                        'chef_interviews',
                                        'restaurant_tours'
                                    ]
                                ],
                                'user_data' => [
                                    'profile_pictures',
                                    'uploaded_images'
                                ],
                                'booking_data' => [
                                    'reservation_documents',
                                    'invoices'
                                ],
                                'banners' => [
                                    'app_home_banner',
                                    'web_home_banner',
                                    'payeazy_offer_banner'
                                ]
                            ]
                        ];

                        // Function to recursively generate options
                        function generateOptions($folders, $prefix = '') {
                            foreach ($folders as $folder => $subfolders) {
                                $label = $prefix . $folder;
                                echo '<option value="' . $label . '">' . $folder . '</option>';
                                if (is_array($subfolders)) {
                                    generateOptions($subfolders, $prefix . $folder . '/');
                                }
                            }
                        }

                        // Generate options for dropdown
                        generateOptions($folders);
                    ?>
                </select>
            </div>
            <div class="form-group" id="fileInputWrapper" style="display: none;">
                <input type="file" name="file" id="fileInput">
                <small class="error-text" id="fileError"></small> <!-- Error message for file input -->
            </div>
            <button type="submit" id="uploadButton" style="display: none;">Upload</button>
            <div class="progress" style="display: none;">
                <div class="progress-bar" id="progressBar"></div> <!-- Progress bar -->
            </div>
            <div class="message" id="uploadMessage"></div> <!-- Success/failure message -->
        </form>
    </div>
    <script src="script.js"></script> <!-- Link to your JavaScript file -->
    <script>
        document.getElementById('folderSelect').addEventListener('change', function() {
            var fileInputWrapper = document.getElementById('fileInputWrapper');
            var uploadButton = document.getElementById('uploadButton');
            var progressBar = document.querySelector('.progress');
            // Show file input and upload button if a folder is selected
            if (this.value !== '') {
                fileInputWrapper.style.display = 'block';
                uploadButton.style.display = 'block';
                progressBar.style.display = 'block';
            } else {
                fileInputWrapper.style.display = 'none';
                uploadButton.style.display = 'none';
                progressBar.style.display = 'none';
            }
        });
    </script>
</body>
</html>
