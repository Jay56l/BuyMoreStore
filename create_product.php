<?php
    // Creating the page title and adding the header page 
    $pagetitle = "Create Product";
    require_once "assets/header.php";

    // Creating a connection to the database
    require_once 'assets/db_connect.php';
?>

<form action="" method="post" enctype="multipart/form-data">
    <h1>Create a Product</h1>
    <input type="text" name="product_name" placeholder="Enter Product Name" required/>
    <select name="product_category" required>
        <option value="Home Appliances">Home Appliances</option>
        <option value="Kitchen Appliances">Kitchen Appliances</option>
        <option value="Electronic Gadgets" selected>Electronic Gadgets</option>
        <option value="Office Equiptment">Office Equiptment</option>
        <option value="Groceries">Groceries</option>
    </select>
    <textarea name="product_description" placeholder="Enter Product Description" required width="100%"></textarea>
    <input type="text" name="initial_price" placeholder="Enter Initial Price" required>
    <input type="text" name="selling_price" placeholder="Enter Selling Price" required>

    <input type="submit" value="Create Product">
</form>