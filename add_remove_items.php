<?php
include 'db_connection.php'
?>

<!DOCTYPE html>
<html lang="en">
<script>
    window.onload = function() {
        const radios = document.getElementsByName('clothing_type');

        for (let i = 0; i < radios.length; i++) {
            radios[i].onclick = function () {
                showFields(this.value);
            }
        }
    }
    function showFields(type) {
        // Hide all fields first
        document.getElementById('topFields').style.display = 'none';
        document.getElementById('bottomFields').style.display = 'none';
        document.getElementById('shoeFields').style.display = 'none';
        document.getElementById('accessoryFields').style.display = 'none';

        // Show fields based on selected radio button
        document.getElementById(type + 'Fields').style.display = 'block';
    }
</script>
<head>

    <meta charset="UTF-8">
    <title>Add Clothing Items</title>
    <style>
        body {
            font-family: "Futura", "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        h1 {
            text-align: center;
            color: #333;
            font-family: "Futura", "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
        }
        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        input[type="file"] {
            display: block;
            margin: 0 auto;
        }
        button {
            margin: 20px 0 0 auto;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        label {
            display: inline-block;
            margin-right: 15px;
            font-family: "Futura", "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
        }
    </style>
</head>
<body>
<h1>Add Clothing Item</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*" required>
    <br>
    <label><input type="radio" name="clothing_type" value="top" onclick="showFields('top')">Top</label>
    <label><input type="radio" name="clothing_type" value="bottom" onclick="showFields('bottom')">Bottom</label>
    <label><input type="radio" name="clothing_type" value="shoe" onclick="showFields('shoe')">Shoe</label>
    <label><input type="radio" name="clothing_type" value="accessory" onclick="showFields('accessory')">Accessory</label>
    <br>
    <div id="colorSelection">
        <label for="color">Color:</label>
        <select name="color" id="color">
            <option value="">Select a color</option>
            <option value="Red">Red</option>
            <option value="Blue">Blue</option>
            <option value="Green">Green</option>
            <option value="Orange">Orange</option>
            <option value="Purple">Purple</option>
            <option value="White">White</option>
            <option value="Brown">Brown</option>
            <option value="Black">Black</option>
            <option value="Gray">Gray</option>
            <option value="Yellow">Yellow</option>
            <!-- Add more colors as needed -->
        </select>
    </div>
    <div id="topFields" style="display: none">
        <label for="top_type">Type: </label>
        <input type="text" name="top_type" id="top_type"><br>
        <label for="top_material">Material:</label>
        <input type="text" name="top_material" id="top_material"><br>
        <label for="top_pattern">Pattern:</label>
        <input type="text" name="top_pattern" id="top_pattern"><br>
        <label for="top_isdress">Is Dress:</label>
        <input type="checkbox" name="top_isdress" id="top_isdress"><br>
    </div>
    <div id="bottomFields" style="display: none">
        <label for="bottom_type">Type:</label>
        <input type="text" name="bottom_type" id="bottom_type"><br>
    </div>
    <div id="shoeFields" style="display: none">
        <label for="shoe_type">Type:</label>
        <input type="text" name="shoe_type" id="shoe_type"><br>
        <label for="shoe_brand">Brand:</label>
        <input type="text" name="shoe_brand" id="shoe_brand"><br>
    </div>
    <div id="accessoryFields" style="display: none">
        <label for="accessory_type">Type:</label>
        <input type="text" name="accessory_type" id="accessory_type"><br>
        <label for="accessory_brand">Brand:</label>
        <input type="text" name="accessory_brand" id="accessory_brand"><br>
    </div>
    <button type="submit">Add Item</button>
    <div id="formalityButtons">
        <label><input type="radio" name="formality" value="casual">Casual</label>
        <label><input type="radio" name="formality" value="business_casual">Business Casual</label>
        <label><input type="radio" name="formality" value="formal">Formal</label>
    </div>
    <div id="id">
        <input type="hidden" name="item_id" id="item_id" value="<?php ini_set('display_errors', 1); echo generateItemId(); ?>">
    </div>
</form>
</body>
</html>