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
if ($clothingType === 'top') {
    $sql = "INSERT INTO ITEM (iid, available, attire, color, istop, isbot, isshoes, isacc) VALUES ('$itemId', 1, ?, ?, 1, 0, 0, 0)";
    $sqlTop = "INSERT INTO TOP (iid, type, material, pattern, isdress) VALUES ('$itemId', ?, ?, ?, ?)";
} elseif ($clothingType === 'bottom') {
    $sql = "INSERT INTO ITEM (iid, available, attire, color, istop, isbot, isshoes, isacc) VALUES ('$itemId', 1, ?, ?, 0, 1, 0, 0)";
    $sqlBottom = "INSERT INTO BOTTOM (iid, type) VALUES ('$itemId', ?)";
} elseif ($clothingType === 'shoe') {
    $sql = "INSERT INTO ITEM (iid, available, attire, color, istop, isbot, isshoes, isacc) VALUES ('$itemId', 1, ?, ?, 0, 0, 1, 0)";
    $sqlShoe = "INSERT INTO SHOES (iid, type, brand) VALUES ('$itemId', ?, ?)";
} elseif ($clothingType === 'accessory') {
    $sql = "INSERT INTO ITEM (iid, available, attire, color, istop, isbot, isshoes, isacc) VALUES ('$itemId', 1, ?, ?, 1, 0, 0, 1)";
    $sqlAccessory = "INSERT INTO ACCESSORY (iid, type, brand) VALUES ('$itemId', ?, ?)";
}
// SQL query to insert clothing item details into the respective table based on clothing type
if ($clothingType === 'top') {
    $conn->begin_transaction(); // Start a transaction

    $stmtTop = $conn->prepare($sqlTop);
    $stmtTop->bind_param("ssss", $_POST['type'], $_POST['top_material'], $_POST['top_pattern'], isset($_POST['top_isdress']) ? '1' : '0');
    $stmtTop->execute();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_POST['type'], $_POST['top_material']);
    $stmt->execute();

    $conn->commit(); // Commit the transaction
} elseif ($clothingType === 'bottom') {
    $conn->begin_transaction(); // Start a transaction

    $stmtBottom = $conn->prepare($sqlBottom);
    $stmtBottom->bind_param("s", $_POST['bottom_type']);
    $stmtBottom->execute();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST['bottom_type']);
    $stmt->execute();

    $conn->commit(); // Commit the transaction
} elseif ($clothingType === 'shoe') {
    $conn->begin_transaction(); // Start a transaction

    $stmtShoe = $conn->prepare($sqlShoe);
    $stmtShoe->bind_param("ss", $_POST['shoe_type'], $_POST['shoe_brand']);
    $stmtShoe->execute();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_POST['shoe_type'], $_POST['shoe_brand']);
    $stmt->execute();

    $conn->commit(); // Commit the transaction
} elseif ($clothingType === 'accessory') {
    $conn->begin_transaction(); // Start a transaction

    $stmtAccessory = $conn->prepare($sqlAccessory);
    $stmtAccessory->bind_param("ss", $_POST['accessory_type'], $_POST['accessory_brand']);
    $stmtAccessory->execute();

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_POST['accessory_type'], $_POST['accessory_brand']);
    $stmt->execute();

    $conn->commit(); // Commit the transaction
}

    $stmt->close();

$conn->close();
function generateItemId() {
    $conn = openConnect();
    
    do {
        $randomId = mt_rand(0, 999999);
        $checkQuery = "SELECT iid FROM ITEM WHERE iid = '$randomId'";
        $result = $conn->query($checkQuery);
    } while ($result->num_rows > 0);

    $conn->close();

    return $randomId;
}
?>