<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Sukses</title>
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
        .success-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
            max-width: 600px;
            width: 100%;
        }
        .success-container h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .success-container p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #555;
        }
        .success-container .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .success-container a.button {
            text-decoration: none;
            color: white;
            background-color: #1a73e8;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .success-container a.button:hover {
            background-color: #0c51a8;
            transform: translateY(-2px);
        }
        .image-preview {
            width: 100%;
            max-width: 300px;
            margin: 20px auto;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .image-preview:hover {
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="success-container">
    <h3>Gambar Berhasil Dikompres</h3>

    <p>Berhasil kompres gambar dari <strong><?php echo $original_size; ?></strong> menjadi <strong><?php echo $compressed_size; ?></strong>.</p>

    <!-- Preview Gambar -->
    <img src="<?php echo base_url('uploads/'.$file_name); ?>" alt="Preview Gambar" class="image-preview">

    <!-- Tombol-tombol diatur menggunakan Flexbox -->
    <div class="button-container">
        <a href="<?php echo base_url('uploads/'.$file_name); ?>" target="_blank" class="button">Klik di sini untuk melihat gambar</a>
        <a href="<?php echo base_url('uploads/'.$file_name); ?>" download class="button">Download Gambar</a>
    </div>
</div>

</body>
</html>
