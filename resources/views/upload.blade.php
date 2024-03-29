<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>

    <!-- <link rel="stylesheet" href="/Users/vedanthvasishth/file-uploader/public/css/app.css"> Link to your CSS file -->
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
        <p>Visit the <a href="/">home page</a> to understand what kinds of files can be uploaded</p>
        <form id="uploadForm" action="/upload" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
            
            <input type="hidden" id="topFolderInput" name="topFolder">
            <input type="hidden" id="subFolderInput" name="subFolder">
            <div class="form-group">
                <select id="topFolderSelect" name="folder">
                    <option value="">Select Top-Level Folder</option>
                    <?php
                        // Sample array representing project hierarchy
                        $folders = [
                                'Restaurant Data' => [
                                    'menus',
                                    'images',
                                    'videos' 
                                ],
                                'User Data' => [
                                    'profile pictures'
                                    
                                ],
                                'Booking Data' => [
                                    'reservation documents',
                                    'invoices'
                                ],
                                'Banners' => [
                                    'app home banner',
                                    'web home banner',
                                    'payeazy offer banner'
                                ]
                                ];

                                function generateSubfolderOptions($subfolders) {
                                    foreach ($subfolders as $subfolder => $contents) {
                                        if (is_array($contents)) {
                                            // If the value is an array, recursively call the function
                                            generateSubfolderOptions($contents);
                                        } else {
                                            // If it's a string (subfolder name), generate the option
                                            echo '<option value="' . $contents . '">' . ucfirst(str_replace('_', ' ', $contents)) . '</option>';
                                        }
                                    }
                                }
                                
                                // Function to generate top-level options
                                function generateTopLevelOptions($folders) {
                                    foreach ($folders as $folder => $subfolders) {
                                        echo '<option value="' . $folder . '">' . ucfirst(str_replace('_', ' ', $folder)) . '</option>';
                                    }
                                }
                                
                                // Generate top-level options for dropdown
                                generateTopLevelOptions($folders);
                                // Call the recursive function to generate options for subfolders
                                
 
                                ?>
                </select>
            </div>
            <div class="form-group" id="subFolderSelectWrapper" style="display: none;">
                <select id="subFolderSelect" name="subfolder">
                    <option value="">Select Subfolder</option>
                </select>
            </div>
            <div class="form-group" id="subSubFolderSelectWrapper" style="display: none;">
                <select id="subSubFolderSelect" name="subsubfolder">
                    <option value="">Select Sub-Subfolder</option>
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
            <div class="message" id="uploadMessage"></div> <!-- Success/failure -->
            <script>
    
    document.getElementById('topFolderSelect').addEventListener('change', function() {
        var selectedFolder = this.value;
        var subFolderSelect = document.getElementById('subFolderSelect');
        var subFolderSelectWrapper = document.getElementById('subFolderSelectWrapper');
        var fileInputWrapper = document.getElementById('fileInputWrapper');
        var uploadButton = document.getElementById('uploadButton');
        var progressBar = document.querySelector('.progress');
        var topFolderInput = document.getElementById('topFolderInput');
        // Clear existing options
        subFolderSelect.innerHTML = '<option value="">Select Subfolder</option>';
        fileInputWrapper.style.display = 'none';
        uploadButton.style.display = 'none';
        progressBar.style.display = 'none';


        topFolderInput.value = selectedFolder;
        // If a top-level folder is selected
        if (selectedFolder !== '') {
            var subfolders = <?php echo json_encode($folders); ?>;
            var selectedSubfolders = subfolders[selectedFolder];

            // If the selected top-level folder has subfolders
            if (selectedSubfolders && typeof selectedSubfolders === 'object') {
                subFolderSelectWrapper.style.display = 'block';

                // Generate and populate subfolder options
                Object.keys(selectedSubfolders).forEach(function(subfolder) {
                    var option = document.createElement('option');
                    option.value = selectedSubfolders[subfolder];
                    option.textContent = selectedSubfolders[subfolder].charAt(0).toUpperCase() + selectedSubfolders[subfolder].slice(1).replace('_', ' ');
                    subFolderSelect.appendChild(option);
                });

                // Show subfolder dropdown
                subFolderSelectWrapper.style.display = 'block';
            } else {
                // If no subfolders, hide subfolder dropdown
                subFolderSelectWrapper.style.display = 'none';
            }
        } else {
            // If no top-level folder selected, hide subfolder dropdown
            subFolderSelectWrapper.style.display = 'none';
        }
    });

    // Function to populate sub-subfolder dropdown based on the selected subfolder
    document.getElementById('subFolderSelect').addEventListener('change', function() {
        var selectedSubfolder = this.value;
        var subSubFolderSelect = document.getElementById('subSubFolderSelect');
        var subSubFolderSelectWrapper = document.getElementById('subSubFolderSelectWrapper');
        var fileInputWrapper = document.getElementById('fileInputWrapper');
        var uploadButton = document.getElementById('uploadButton');
        var progressBar = document.querySelector('.progress');
        var subFolderInput = document.getElementById('subFolderInput');
        // Clear existing options
        subSubFolderSelect.innerHTML = '<option value="">Select Sub-Subfolder</option>';
        fileInputWrapper.style.display = 'none';
        uploadButton.style.display = 'none';
        progressBar.style.display = 'none';
        
        subFolderInput.value = selectedSubfolder;

        if (selectedSubfolder !== '') {
            var subfolders = <?php echo json_encode($folders); ?>;
            var selectedSubfolders = subfolders[selectedSubfolder];
            fileInputWrapper.style.display = 'block';
            uploadButton.style.display = 'block';
            // progressBar.style.display = 'block';

            // If the selected subfolder has sub-subfolders
            if (selectedSubfolders && typeof selectedSubfolders === 'object') {
                subSubFolderSelectWrapper.style.display = 'block';

                // Generate and populate sub-subfolder options
                Object.keys(selectedSubfolders).forEach(function(subSubfolder) {
                    var option = document.createElement('option');
                    option.value = subSubfolder;
                    option.textContent = subSubfolder.charAt(0).toUpperCase() + subSubfolder.slice(1).replace('_', ' ');
                    subSubFolderSelect.appendChild(option);
                });

                // Show sub-subfolder dropdown
                subSubFolderSelectWrapper.style.display = 'block';
            } 
        } else {
            // If no subfolder selected, hide sub-subfolder dropdown
            fileInputWrapper.style.display = 'none';
            uploadButton.style.display = 'none';
            progressBar.style.display = 'none';
        }

       
    });
</script>

        </form>
    </div>
</body>
</html>
