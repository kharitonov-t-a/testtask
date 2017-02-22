<?php
session_start();
include "watermark.php";

$data = '';

if (isset($_SESSION['arraysrc'])){
    $arraysrc = $_SESSION['arraysrc'];
}else{
    $arraysrc = array();
}

if(isset($_GET['uploadtxt']) && !empty($_FILES)){

    $error = false;
    $files = array();
    
    $uploaddir = '../uploads/';
    
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $path = $uploaddir . "test.txt";

    if( move_uploaded_file( $_FILES[0]['tmp_name'], $path ) ){
        $files = realpath( $path );
    }else{
        echo 'failed download';
        die();
    }

    $array=file($path);
    $watermark = new watermark();
    $n=1;

    foreach($array as $item){

        $stopadd = false;
        $n++;
        $url = $item;
       

        $img = str_replace('https://', 'http://', $item);
        $img = trim(preg_replace('/\s/', '', $img));

        
        //basename($img);
        $arr = explode('/',$img);
        $filename = $arr[(count($arr) - 1)];
        

        $arr = explode('.','z_Megalos20Ceramic-Dune-7.jpg');
        $arr = explode('.',$filename);
        $filename = md5($filename) . '.' . $arr[(count($arr) - 1)];
        $path = $uploaddir . $filename;

        if(!empty($img)){

            if(is_array($arraysrc) && !empty($arraysrc)){
                foreach ($arraysrc as $key => $value) {
                    if($value == $img){
                        $stopadd = true;
                        break;
                    }
                }
            }

            if( $stopadd == false ){

                $arraysrc[] = $img;
                if (!file_exists($path)){

                    file_put_contents($path, file_get_contents($img));

                    $water = '../img/watermark.png';
                    $im=$watermark->create_watermark($path, $water, 50, 200);
                    imagejpeg($im, $path);
                }

                $data .= '<div class="images-div"><img class="images-img" height="200" data-line="" src="./uploads/' . $filename . '"></div>';
            }
        }
    }

    $_SESSION['arraysrc'] = $arraysrc;

    echo $data;
}