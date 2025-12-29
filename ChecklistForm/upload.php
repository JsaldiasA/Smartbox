
<?php
$target_dir = "Fotos/"; // Ensure this directory exists and is writable
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// Check for upload errors
if ($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
    die("Upload failed with error code " . $_FILES["fileToUpload"]["error"]);
}

// Move file from temporary location to target directory
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
} else {
    echo "Sorry, there was an error moving your file.";
}
?>
