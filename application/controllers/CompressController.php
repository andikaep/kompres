<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CompressController extends CI_Controller {

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
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        }
        else
        {
            $data = $this->upload->data();
            $file_path = $data['full_path'];

            $this->compress($file_path, $data['file_type']);
            $this->load->view('upload_success', $data);
        }
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
