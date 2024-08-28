<!DOCTYPE html>
<html>
<head>
    <title>Upload Gambar</title>
</head>
<body>

<h3>Upload Gambar untuk Dikompres</h3>

<?php echo $error;?>

<?php echo form_open_multipart('CompressController/compress_image');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Kompres" />

</form>

</body>
</html>
