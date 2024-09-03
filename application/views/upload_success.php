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
            align-items: flex-start;
            min-height: 100vh;
        }

        .success-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
            max-width: 1200px;
            width: 100%;
            margin-top: 30px;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .image-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f8f8;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .image-container img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .image-container img:hover {
            transform: scale(1.05);
        }

        .image-container p {
            margin-top: 10px;
            font-size: 16px;
            color: #555;
        }

        .compression-ratio {
            color: #4CAF50;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .button-container a {
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .button-container a:hover {
            background-color: #388E3C;
            transform: translateY(-2px);
        }

        .button-container a.download {
            background-color: #1a73e8;
        }

        .button-container a.download:hover {
            background-color: #0c51a8;
        }

        .download-all-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .download-all-container button {
            padding: 12px 25px;
            font-size: 18px;
            color: white;
            background: linear-gradient(to right, #4facfe, #00f2fe); /* Gradien biru */
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .download-all-container button:hover {
            background: linear-gradient(to right, #00d2ff, #3a7bd5); /* Warna gradien biru yang lebih dalam */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-3px);
        }

        .download-all-container button:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
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
    <script>
        function downloadAll() {
            var links = document.querySelectorAll('.download-link');
            links.forEach(function(link) {
                var a = document.createElement('a');
                a.href = link.href;
                a.download = link.download;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });
        }
    </script>
</head>
<body>

<div class="success-container">
    <h3>Gambar Berhasil Dikompres</h3>

    <div class="image-grid">
        <?php foreach ($images as $image): ?>
        <div class="image-container">
            <p>Berhasil kompres gambar dari <strong><?php echo $image['original_size']; ?></strong> menjadi <strong><?php echo $image['compressed_size']; ?></strong> (<strong class="compression-ratio"><?php echo $image['compression_ratio']; ?>%</strong>)</p>

            <img src="<?php echo base_url('uploads/'.$image['file_name']); ?>" alt="Preview Gambar">

            <div class="button-container">
                <a href="<?php echo base_url('uploads/'.$image['file_name']); ?>" target="_blank" class="button">Lihat Gambar</a>
                <a href="<?php echo base_url('uploads/'.$image['file_name']); ?>" download="<?php echo $image['file_name']; ?>" class="button download">Download Gambar</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if(count($images) > 1): ?>
    <div class="download-all-container">
        <button onclick="downloadAll()">Download Semua</button>
        <?php foreach ($images as $image): ?>
            <a href="<?php echo base_url('uploads/'.$image['file_name']); ?>" download="<?php echo $image['file_name']; ?>" class="download-link" style="display:none;"></a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
