<?php
class watermark
{
    public static function create_watermark( $main_img, $watermark_img, $alpha_level = 100, $height)
    {

        //resize main image
        $array_resize_main_img = self::resize_main_img($main_img, 200);
        $main_img_new = $array_resize_main_img[0];
        $main_img_width_new = $array_resize_main_img[1];
        $main_img_height_new = $array_resize_main_img[2];

        //resize watermark image
        $array_resize_watermark_img = self::resize_watermark_img($watermark_img, $array_resize_main_img[1]);
        $watermark_img_new = $array_resize_watermark_img[0];
        $watermark_img_width_new = $array_resize_watermark_img[1];
        $watermark_img_height_new = $array_resize_watermark_img[2];

        //adding watermark
        $dest_x = $main_img_width_new - $watermark_img_width_new;
        $dest_y = $main_img_height_new - $watermark_img_height_new;
        imagecopymerge($main_img_new, $watermark_img_new, $dest_x, $dest_y, 0, 0, $watermark_img_width_new, $watermark_img_height_new, $alpha_level);

        return $main_img_new;
    }

    public static function resize_main_img( $main_img, $main_img_height_new = 200 )
    {
        list($main_img_width_old,$main_img_height_old) = getimagesize($main_img);

        $main_img_width_new = ($main_img_height_new/$main_img_height_old)*$main_img_width_old;
        
        $main_img_new = imagecreatetruecolor($main_img_width_new, $main_img_height_new);
        $img_src = imagecreatefromjpeg($main_img);

        imagecopyresampled($main_img_new, $img_src, 0, 0, 0, 0, $main_img_width_new, $main_img_height_new, $main_img_width_old, $main_img_height_old);

        return [$main_img_new, $main_img_width_new, $main_img_height_new];
    }

    public static function resize_watermark_img( $watermark_img, $main_img_width )
    {
        list($watermark_img_width_old,$watermark_img_height_old) = getimagesize($watermark_img);

        $watermark_img_width_new = $main_img_width;
        $watermark_img_height_new = ($watermark_img_width_new/$watermark_img_width_old)*$watermark_img_height_old;

        $watermark_img_new = imagecreatetruecolor($watermark_img_width_new, $watermark_img_height_new);
        $background_color = imagecolorallocate($watermark_img_new, 0, 0, 0);
        imagecolortransparent($watermark_img_new, $background_color);
        $img_src = imagecreatefrompng($watermark_img);
        
        imagecopyresampled($watermark_img_new, $img_src, 0, 0, 0, 0, $watermark_img_width_new, $watermark_img_height_new, $watermark_img_width_old, $watermark_img_height_old);

        return [$watermark_img_new, $watermark_img_width_new, $watermark_img_height_new];
    }

}