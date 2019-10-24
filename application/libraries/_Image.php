<?php
/**
 * Developed by Adnan Bashir.
 * Email: pisces_adnan@hotmail.com
 * Autour: Adnan Bashir
 * Date: 5/30/12
 * Time: 12:56 AM
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

class _Image extends Gregwar\Image\Image
{

    protected $cacheDir = 'assets/cache/images';

    function __construct($originalFile = null, $width = null, $height = null)
    {
        $this->setCacheDir('assets/cache/images');

        $filename = explode('.', urlencode(end(explode('/', $originalFile))))[0];
        $this->setPrettyName($filename);

        parent::__construct($originalFile, $width, $height);
    }



    public function show()
    {
        return base_url($this->cacheFile('png', 100));
    }

    public function wm($image, $width = null, $height = null, $watermark_image = null, $attr = ['func' => 'resize'])
    {
        if($width == null && $height == null){
            $img = _Image::open($image);
        }else {
            $img = _Image::open($image)->{$attr['func']}($width, $height);
        }

        if($watermark_image) {
            $img = _Image::open($img);
            if ($img->width() < 200) {
                $wm_image = _Image::open($watermark_image)->cropResize(60, null);
                $wm_image = _Image::open($wm_image);
            } else{
                $wm_image = _Image::open($watermark_image);
            }

            $img_url = $img->merge($wm_image, (($img->width() / 2) - ($wm_image->width() / 2)), (($img->height() / 2) - ($wm_image->height() / 2)));//->save('out.jpg', 'jpg')
        } else{
            $img_url = $img;
        }
        return $img_url;
    }

}

