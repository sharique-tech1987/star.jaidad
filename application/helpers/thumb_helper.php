<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Thumb()
 * A TimThumb-style function to generate image thumbnails on the fly.
 *
 * @author Adnan Bashir
 * @author Lozano Hernán <developer.adnan@gmail.com>
 * @access public
 * @param string $src
 * @param int $width
 * @param int $height
 * @param string $image_thumb
 * @return String
 *
 */
function thumb($image_path,$new_image_path, $width = 0, $height = 0) {

    //Get the Codeigniter object by reference
    $CI = & get_instance();

    //Alternative image if file was not found
    /*if (!file_exists($image_path))
        $image_path = 'images/file_not_found.jpg';*/

    //The new generated filename we want
    $fileinfo = pathinfo($image_path);

    if(!$new_image_path){
        $new_image_path = $fileinfo['dirname'] . '/' . $width . 'x' . $height . '_' . $fileinfo['filename'] . '.' . $fileinfo['extension'];
    }


    //The first time the image is requested
    //Or the original image is newer than our cache image
    if ((!file_exists($new_image_path)) || filemtime($new_image_path) < filemtime($image_path)) {
        $CI->load->library('image_lib');

        //The original sizes
        $original_size = getimagesize($image_path);
        $original_width = $original_size[0];
        $original_height = $original_size[1];
        $ratio = $original_width / $original_height;

        //The requested sizes
        $requested_width = $width;
        $requested_height = $height;

        //Initialising
        $new_width = 0;
        $new_height = 0;

        //Calculations
        if ($requested_width > $requested_height) {
            $new_width = $requested_width;
            $new_height = $new_width / $ratio;
            if ($requested_height == 0)
                $requested_height = $new_height;

            if ($new_height < $requested_height) {
                $new_height = $requested_height;
                $new_width = $new_height * $ratio;
            }

        } else {
            $new_height = $requested_height;
            $new_width = $new_height * $ratio;
            if ($requested_width == 0)
                $requested_width = $new_width;

            if ($new_width < $requested_width) {
                $new_width = $requested_width;
                $new_height = $new_width / $ratio;
            }
        }

        $new_width = ceil($new_width);
        $new_height = ceil($new_height);

        //Resizing
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_path;
        $config['new_image'] = $new_image_path;
        $config['maintain_ratio'] = FALSE;
        $config['quality'] = '100';
        $config['height'] = $new_height;
        $config['width'] = $new_width;
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        $CI->image_lib->clear();

        //Crop if both width and height are not zero
        if (($width != 0) && ($height != 0)) {
            $x_axis = floor(($new_width - $width) / 2);
            $y_axis = floor(($new_height - $height) / 2);

            //Cropping
            $config = array();
            $config['source_image'] = $new_image_path;
            $config['maintain_ratio'] = FALSE;
            $config['new_image'] = $new_image_path;
            $config['width'] = $width;
            $config['quality'] = '100';
            $config['height'] = $height;
            $config['x_axis'] = $x_axis;
            $config['y_axis'] = $y_axis;
            $CI->image_lib->initialize($config);
            $CI->image_lib->crop();
            $CI->image_lib->clear();
        }
    }

    return $new_image_path;
}


/* End of file thumb_helper.php */
/* Location: ./application/helpers/thumb_helper.php */