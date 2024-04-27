<?php
// Check if image uploaded
if (isset($_FILES['image'])) {
  $fileName = $_FILES['image']['name'];
  $fileType = $_FILES['image']['type'];
  $fileSize = $_FILES['image']['size'];
  $fileTmp = $_FILES['image']['tmp_name'];

  // Check for valid image types
  $allowedTypes = array("image/jpeg", "image/png", "image/gif");
  if (in_array($fileType, $allowedTypes)) {
    // Set a target directory (change path as needed)
    $targetDir = "uploads/";

    // Check and create upload directory if it doesn't exist
    if (!is_dir($targetDir)) {
      mkdir($targetDir, 0777, true);
    }

    // Generate a unique filename to avoid conflicts
    $targetFileName = uniqid() . "." . pathinfo($fileName)['extension'];
    $targetPath = $targetDir . $targetFileName;

    // Move uploaded file to target directory
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
?>
