
<?php
$target_dir = "Fotos/"; // Ensure this directory exists and is writable
$target_file = $target_dir . basename($_FILES["file"]["name"]);

// Check for upload errors
if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
    die("Upload failed with error code " . $_FILES["file"]["error"]);
}

// Move file from temporary location to target directory
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars(basename($_FILES["file"]["name"])). " has been uploaded.";
} else {
    echo "Sorry, there was an error moving your file.";
}
?>
