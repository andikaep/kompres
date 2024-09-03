Image Compression Tool
======================

This is a lightweight image compression tool built using CodeIgniter. It allows you to compress images directly on your server without relying on external libraries, APIs, or third-party services. The tool supports JPEG, PNG, and GIF formats, providing efficient compression while maintaining good image quality.

Features
--------

- **JPEG, PNG, GIF Compression**: Compress images directly on the server.
- **Simple Implementation**: No need for external libraries like Composer or ImageMagick.
- **Automatic Compression**: Automatically compress images upon upload.
- **Preserve Image Quality**: Balance between reducing file size and maintaining image clarity.

Prerequisites
-------------

- PHP 7.2 or higher
- CodeIgniter 3.x
- cURL PHP extension (optional for advanced features)

Installation
------------

Clone the Repository:

.. code-block:: bash

   git clone https://github.com/andikaep/kompres.git
   cd kompres

Configure CodeIgniter:

- Copy ``application/config/config.sample.php`` to ``application/config/config.php`` and update the ``base_url`` to match your environment.
- Set up your ``uploads`` directory in the root of the project and ensure it has write permissions.

Configure the Compression Method:

- The compression is handled directly in the ``Compress.php``. No additional setup is required.

Usage
-----

1. **Access the Tool**:

   Open your browser and navigate to the base URL of your project. For example::

      http://localhost/kompres/

2. **Upload and Compress**:

   - Use the provided upload form to select an image file.
   - Click "Upload" to compress the image.
   - After uploading, you'll see options to view or download the compressed image.

How It Works
------------

- **JPEG Compression**: Uses PHP's ``imagejpeg`` function with adjustable quality settings.
- **PNG Compression**: Uses PHP's ``imagepng`` function with maximum compression level.
- **GIF Compression**: Uses PHP's ``imagegif`` function to handle GIF images without further compression (as GIF is already well-compressed).

Example Code in ``Compress.php``:

.. code-block:: php

   private function compress($path, $file_type)
   {
       if ($file_type == 'image/jpeg' || $file_type == 'image/jpg') {
           $image = imagecreatefromjpeg($path);
           imagejpeg($image, $path, 70); // Compress JPEG to 70% quality
       } elseif ($file_type == 'image/png') {
           $image = imagecreatefrompng($path);
           imagepng($image, $path, 9); // Maximum PNG compression
       } elseif ($file_type == 'image/gif') {
           $image = imagecreatefromgif($path);
           imagegif($image, $path);
       }

       imagedestroy($image);
   }

Troubleshooting
---------------

- **404 Page Not Found**: Ensure the ``uploads`` directory exists and has the correct permissions.
- **File Not Compressing Enough**: Experiment with different compression levels for JPEG and PNG by adjusting the quality/compression values in the ``compress`` function.

Contributing
------------

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Commit your changes and push them to your fork.
4. Open a pull request with a detailed description of your changes.

License
-------

This project is licensed under the MIT License. See the ``LICENSE`` file for details.
