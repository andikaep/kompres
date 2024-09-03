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
    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
    $config['max_size'] = 2048;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('userfile'))
    {
        $error = array('error' => $this->upload->display_errors());
        $this->load->view('upload_form', $error);
    }
    else
    {
        $data = $this->upload->data();
        $file_path = $data['full_path'];

        // Ukuran file sebelum kompresi
        $original_size = filesize($file_path);

        // Lakukan kompresi gambar
        $this->compress($file_path, $data['file_type']);

        // Pastikan kompresi dilakukan sebelum menghitung ukuran baru
        clearstatcache(); // Bersihkan cache ukuran file
        $compressed_size = filesize($file_path);

        // Hitung persentase pengurangan ukuran
        $compression_ratio = 100 - (($compressed_size / $original_size) * 100);

        // Tambahkan informasi ukuran file dan persentase kompresi ke data yang dikirim ke view
        $data['original_size'] = $this->format_size_units($original_size);
        $data['compressed_size'] = $this->format_size_units($compressed_size);
        $data['compression_ratio'] = number_format($compression_ratio, 2);

        $this->load->view('upload_success', $data);
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

    private function compress($path, $file_type)
    {
        if ($file_type == 'image/jpeg' || $file_type == 'image/jpg') {
            $image = imagecreatefromjpeg($path);
            
            // Hapus metadata EXIF
            $image_without_metadata = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagecopy($image_without_metadata, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    
            // Compress JPEG to 70% quality
            imagejpeg($image_without_metadata, $path, 70);
    
            imagedestroy($image_without_metadata);
        } elseif ($file_type == 'image/png') {
            $image = imagecreatefrompng($path);
    
            // Reduce color palette if possible (good for images with less color variation)
            imagetruecolortopalette($image, false, 256);
    
            // Maximum PNG compression
            imagepng($image, $path, 9);
        } elseif ($file_type == 'image/gif') {
            $image = imagecreatefromgif($path);
            imagegif($image, $path);
        }
    
        imagedestroy($image);
    }
    

}
