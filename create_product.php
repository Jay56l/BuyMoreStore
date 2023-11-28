<?php
    // Creating the page title and adding the header page  Hello
    $pagetitle = "Create Product";
    require_once "assets/header.php";

    // Creating a connection to the database
    require_once 'assets/db_connect.php';

    // Validation  
    $pierr = $pnerr = $iperr = $sperr = $pderr = "";
    $product_image = $product_name = $product_category = $initial_price = $selling_price = $product_description = "";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize the input parameters pass by users to avoid XSS vulnerabilities
        function sanitizeInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Capturing the input parameters
        $product_name = sanitizeInput($_POST['product_name']);
        $product_category = sanitizeInput($_POST['product_category']);
        $initial_price = sanitizeInput($_POST['initial_price']);
        $selling_price = sanitizeInput($_POST['selling_price']);
        $product_description = sanitizeInput($_POST['product_description']);
        $product_image = $_FILES['product_image'];

        if ($selling_price >= $initial_price) {
            $iperr = "Initial price is less than Selling price";
            $sperr = "Selling price is greater than Initial price";
        } else {
            $iperr = $sperr = "";
        }

        // Validate Image 
        $uploadDirectory = "uploads/";
        $maxFileSize = 3 * 1024 * 1024;
        if ($product_image['size'] <= $maxFileSize) {
            if(isset($product_image) && $product_image['error'] === 0) {
                $tempFilePath = $product_image['tmp_name'];
    
                $imageInfo = getimagesize($tempFilePath);
                
                if($imageInfo !== false) {
                    $newFileName = uniqid('product_') . "." . pathinfo($product_image['name'], PATHINFO_EXTENSION);
    
                    $targetFilePath = $uploadDirectory . $newFileName;
    
                    if(move_uploaded_file($tempFilePath, $targetFilePath)) {
                        echo "Successfully uploaded as " . $newFileName;
                    } else {
                        $pierr = 'Upload failed'; 
                    }
                } else {
                    $pierr = "No image found";
                }
            } else {
                $pierr = "No image found";
            }
    
        } else {
            $pierr = "Image Size is bigger than 3mb";
        }
        
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <h1>Create a Product</h1>
    <input type="file" id="image" name="product_image" onchange="previewImage()"/> <br/>
    <span><?php echo $pierr; ?></span>
    <img src="" id="imagePreview" style="max-width: 300px; max-height: 300px;"/>
    <input type="text" name="product_name" placeholder="Enter Product Name"/>
    <span><?php echo $pnerr; ?></span>
    <select name="product_category" required>
        <option value="Home Appliances">Home Appliances</option>
        <option value="Kitchen Appliances">Kitchen Appliances</option>
        <option value="Electronic Gadgets" selected>Electronic Gadgets</option>
        <option value="Office Equiptment">Office Equiptment</option>
        <option value="Groceries">Groceries</option>
    </select>
    <input type="number" name="initial_price" placeholder="Enter Initial Price">
    <span><?php echo $iperr; ?></span>
    <input type="number" name="selling_price" placeholder="Enter Selling Price">
    <span><?php echo $sperr; ?></span>
    <textarea name="product_description" placeholder="Enter Product Description" width="100%"></textarea>
    <span><?php echo $pderr; ?></span>

    <input type="submit" value="Create Product">
</form>

<script>
    function previewImage() {
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(imageInput.files[0]);
        }
    }
</script>

<?php

?>