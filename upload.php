<?php
require_once 'db_connection.php';
ini_set('display_errors', 1);

if (isset($_FILES['image'])) {
    $fileName = $_FILES['image']['name'];
    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileTmp = $_FILES['image']['tmp_name'];

    // Check for valid image types
    $allowedTypes = array("image/jpeg", "image/png", "image/gif");
    if (in_array($fileType, $allowedTypes)) {
        // Set the target directory
        $targetDir = "images/";

        // Check and create the upload directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Generate a unique filename based on item ID
        $itemId = generateItemId(); // Implement your logic to generate item ID
        $targetFileName = $itemId . "." . pathinfo($fileName)['extension'];
        $targetPath = $targetDir . $targetFileName;
        echo($targetPath);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmp, $targetPath)) {
            echo "Image uploaded successfully!";
        } else {
            echo "There was a problem uploading the image.";
        }
    } else {
        echo "Only JPG, PNG, and GIF images are allowed.";
    }
} else {
    echo "Please select an image to upload.";
}
// Get other form data
$clothingType = $_POST['clothing_type'];

// Database connection and SQL query to insert clothing item
$conn = openConnect();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Set the flags based on the type of the item
$isTop = $isBot = $isShoes = $isAcc = 0;
if ($clothingType === 'top') {
    $isTop = 1;
} elseif ($clothingType === 'bottom') {
    $isBot = 1;
} elseif ($clothingType === 'shoe') {
    $isShoes = 1;
} elseif ($clothingType === 'accessory') {
    $isAcc = 1;
}
// SQL query to insert into ITEM table. This has to occur before the specific clothing type table insertions due to
// foreign key constraints
$sql = "INSERT INTO ITEM (iid, available, attire, color, istop, isbot, isshoes, isacc) VALUES ($itemId, 1, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ssiiii", $_POST['formality'], $_POST['color'], $isTop, $isBot, $isShoes, $isAcc);
    if ($stmt->execute()) {
        // set SQL query to insert clothing item details into the respective table based on clothing type
        if ($clothingType === 'top') {
            $sql = "INSERT INTO TOP (iid, type, material, pattern, isdress) VALUES ($itemId, ?, ?, ?, ?)";
        } elseif ($clothingType === 'bottom') {
            $sql = "INSERT INTO BOTTOM (iid, type) VALUES ($itemId, ?)";
        } elseif ($clothingType === 'shoe') {
            $sql = "INSERT INTO SHOES (iid, type, brand) VALUES ($itemId, ?, ?)";
        } elseif ($clothingType === 'accessory') {
            $sql = "INSERT INTO ACCESSORY (iid, type, brand) VALUES ($itemId, ?, ?)";
        }

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            if ($clothingType === 'top') {
                $isDress = isset($_POST['top_isdress']) ? 1 : 0;
                $stmt->bind_param("ssss", $_POST['top_type'], $_POST['top_material'], $_POST['top_pattern'], $isDress);
            } elseif ($clothingType === 'bottom') {
                $stmt->bind_param("s", $_POST['bottom_type']);
            } elseif ($clothingType === 'shoe') {
                $stmt->bind_param("ss", $_POST['shoe_type'], $_POST['shoe_brand']);
            } elseif ($clothingType === 'accessory') {
                $stmt->bind_param("ss", $_POST['accessory_type'], $_POST['accessory_brand']);
            }

            if ($stmt->execute()) {
                echo "Clothing item added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
    echo "Error in preparing the statement.";
}

} else {
    echo "Error in preparing the statement.";
}

$conn->close();