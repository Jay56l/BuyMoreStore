<?php
    // Creating the page title and adding the header page 
    $pagetitle = "Create Product";
    require_once "assets/header.php";

    // Creating a connection to the database
    require_once 'assets/db_connect.php';
    // validation
    $pierr = $pnerr = $pderr = $iperr = $sperr = "";
    $product_image = $product_name = $product_category = $initial_price = $selling_price = $product_description = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // sanitize the input parameters pass by users to avoid xss vulnerabilities
        function sanitizeinput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
    }
    
    function pricevaValidate($data , $errormsg) {
        if(preg_match('/^[0-9][0-9]*$/',$data)) {
            $errormsg = "";
        } else {
            $errormsg = "Invalid price value";
        }
    }

    $product_name = sanitizeinput($_POST['product_name']);
    $product_category = sanitizeinput($_POST['product_category']);
    $selling_price = sanitizeinput($_POST['selling_price']);
    $initial_price = sanitizeinput($_POST['initial_price']);
    $product_description = sanitizeinput($_POST['product_description']);
    $product_image = $_FILES['product_image'];
    
    if ($selling_price >= $initial_price) {
        $iperr = "Initial price is less than selling price";
        $sperr = "selling price is greater than initial price";
    } else {
        $iperr = $sperr = "";
    } 
     
    // Validate Image 
    $uploadDirectory = "uploads/";
    $maxFileSize = 3 * 1024 * 1024;
    if ($product_image['size'] <= $maxFileSize) {
    if(isset($product_image) && $product_image['error'] === 0) {
        $tempfilepath = $product_image['tmp_name'];

        $imageinfo = getimagesize($tempfilepath);

        if(imageinfo !== false) {
            $newFileName = uniqid('product_') . "." . pathinfo(product_image[name],
            PATHINFO_EXTENSION);

            $targetFilePath = $uploadDirectory. $newFileName;

            if(move_uploaded_file($tempFilePath,$targetFilepath)) {
                echo "Successfully uploaded as" . $newFileName;
            } else {
                $pierr = 'upload failed';
            }
        } else {
            $pierr = "No image found";
        }
    } else {
        $pierr = "No image found";
    }
} else {
    pierr = "Image Size bigger than 3mb";
}
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <h1>Create a Product</h1>
    <input type="file" id="image" name="product_image" onchange="previewImage()"> <br>
    <span><?php echo $pierr; ?></span>
    <img src="" id="ImagePreview" style="max-width: 300px; max-height:300px;">
    <input type="text" name="product_name" placeholder="Enter Product Name" required/>
    <span><?php echo $pnerr; ?></span>

    <select name="product_category" required>
        <option value="Home Appliances">Home Appliances</option>
        <option value="Kitchen Appliances">Kitchen Appliances</option>
        <option value="Electronic Gadgets" selected>Electronic Gadgets</option>
        <option value="Office Equiptment">Office Equiptment</option>
        <option value="Groceries">Groceries</option>
    </select>
    <textarea name="product_description" placeholder="Enter Product Description" required width="100%"></textarea>
    <span><?php echo $pderr; ?></span>
    <input type="number" name="initial_price" placeholder="Enter Initial Price" required>
    <span><?php echo $iperr; ?></span>
    <input type="number" name="selling_price" placeholder="Enter Selling Price" required>
    <span><?php echo $sperr; ?></span>
    <input type="submit" value="Create Product">
</form>
<script>
    function previewImage() {
        const ImageInput = document.getElementById('image');
        const ImagePreview = document.getElementById('imagePreview');

    if (ImageInput.files && ImageInput.files[0]) {
        const reader = new FileReader();
    }
}
</script>