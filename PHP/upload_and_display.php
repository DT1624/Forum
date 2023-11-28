<?php
    if (isset($_FILES["image"])) {
        $image_name = $_FILES["image"]["name"];
        $image_tmp = $_FILES["image"]["tmp_name"];

        // Move uploaded image to desired directory
        $upload_directory = "uploads/";
        $target_image = $upload_directory . $image_name;
        echo $target_image;
        if (move_uploaded_file($image_tmp, $target_image)) {
            echo "Image uploaded successfully.";

            // Display the image inside the frame
            echo '<div class="image-frame"><img src="' . $target_image . '></div>';
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "No image uploaded.";
    }
?>
