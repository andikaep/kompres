<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .upload-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .upload-container h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .upload-container p {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #495057;
            font-size: 14px;
        }
        .upload-container input[type="file"] {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        .upload-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .upload-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="upload-container">
    <h3>Upload Gambar untuk Dikompres</h3>

    <p>Max Size: 2 MB<br>Allowed Formats: JPG, PNG, GIF</p>

    <div class="error-message">
        <?php echo $error;?>
    </div>

    <?php echo form_open_multipart('Compress/compress_image');?>

    <input type="file" name="userfile" size="20" />

    <br />

    <input type="submit" value="Kompres" />

    </form>
</div>

</body>
</html>
