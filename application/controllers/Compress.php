<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compress extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->view('upload_form', array('error' => ' ' ));
    }

    public function compress_image()
{
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'jpg|jpeg|png|webp'; // Tambahkan 'webp'
    $config['max_size'] = 2048;

    $this->load->library('upload', $config);

    if (!isset($_FILES['userfile']) || !is_array($_FILES['userfile']['name'])) {
        $error = array('error' => 'Please select at least one file to upload.');
        $this->load->view('upload_form', $error);
        return;
    }

    $files = $_FILES;
    $fileCount = count($_FILES['userfile']['name']);
    $data['images'] = [];

    for ($i = 0; $i < $fileCount; $i++) {
        $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
        $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
        $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
        $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
        $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
            return; // Stop execution if any upload fails
        } else {
            $fileData = $this->upload->data();
            $file_path = $fileData['full_path'];

            // Ukuran file sebelum kompresi
            $original_size = filesize($file_path);

            // Lakukan kompresi gambar
            $this->compress($file_path, $fileData['file_type']);

            // Pastikan kompresi dilakukan sebelum menghitung ukuran baru
            clearstatcache(); // Bersihkan cache ukuran file
            $compressed_size = filesize($file_path);

            // Hitung persentase pengurangan ukuran
            $compression_ratio = 100 - (($compressed_size / $original_size) * 100);

            // Tambahkan informasi ke array data untuk semua gambar yang diupload
            $data['images'][] = [
                'original_size' => $this->format_size_units($original_size),
                'compressed_size' => $this->format_size_units($compressed_size),
                'compression_ratio' => number_format($compression_ratio, 2),
                'file_name' => $fileData['file_name']
            ];
        }
    }

    $this->load->view('upload_success', $data);
}

private function compress($path, $file_type)
{
    // Dapatkan ukuran asli gambar
    list($width, $height) = getimagesize($path);

    // Kurangi resolusi gambar jika terlalu besar
    $max_dimension = 2000; // Atur ukuran maksimal
    if ($width > $max_dimension || $height > $max_dimension) {
        $scale = min($max_dimension / $width, $max_dimension / $height);
        $new_width = ceil($width * $scale);
        $new_height = ceil($height * $scale);
    } else {
        $new_width = $width;
        $new_height = $height;
    }

    if ($file_type == 'image/jpeg' || $file_type == 'image/jpg') {
        $image = imagecreatefromjpeg($path);
        
        // Resize gambar jika diperlukan
        $image_resized = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Hapus metadata EXIF dan simpan gambar yang sudah dikompresi
        imagejpeg($image_resized, $path, 70);

        imagedestroy($image);
        imagedestroy($image_resized);
    } elseif ($file_type == 'image/png') {
        $image = imagecreatefrompng($path);

        // Resize gambar jika diperlukan
        $image_resized = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Kurangi palet warna jika memungkinkan
        imagetruecolortopalette($image_resized, false, 256);

        // Simpan gambar yang sudah dikompresi
        imagepng($image_resized, $path, 9);

        imagedestroy($image);
        imagedestroy($image_resized);
    } elseif ($file_type == 'image/webp') {
        $image = imagecreatefromwebp($path);

        // Resize gambar jika diperlukan
        $image_resized = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Simpan gambar yang sudah dikompresi
        imagewebp($image_resized, $path, 70);

        imagedestroy($image);
        imagedestroy($image_resized);
    }
}





private function format_size_units($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

}
