<!DOCTYPE html>
<html>
<head>
    <title>Upload Sukses</title>
</head>
<body>

<h3>Gambar Berhasil Dikompres</h3>

<!-- Link untuk melihat gambar -->
<p><?php echo anchor(base_url('uploads/'.$file_name), 'Klik di sini untuk melihat gambar', array('target' => '_blank')); ?></p>

<!-- Tombol untuk mengunduh gambar -->
<p><a href="<?php echo base_url('uploads/'.$file_name); ?>" download>Download Gambar</a></p>

</body>
</html>
