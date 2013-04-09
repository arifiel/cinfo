<?php
function add_foto($item_id) {
    global $conf, $post, $data, $img, $mod,$pathname;


    require_once $conf['dir']['inc'].'/phpthumb/ThumbLib.inc.php';
    $conf['dir']['upload'] = $conf['dir']['upload'].$pathname[0].'/';


    if (isset($_FILES['upload_file']['tmp_name']) && $_FILES['upload_file']['tmp_name']!="") {

    $filename = $item_id.'.jpg';
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $conf['dir']['upload'].'covers/'.$filename);
        $post['img'] = $filename;
        chmod ($conf['dir']['upload'].'covers/'.$filename, 0755);


        //photo
        try {
            $cover = PhpThumbFactory::create($conf['dir']['upload'].'covers/'.$filename);
        }
        catch (Exception $e) {
            // handle error here however you'd like
            echo $e.' error occured!';
        }

        $cover->resize(640, 480);
        $cover->cropFromCenter(640,480);
        $cover->save($conf['dir']['upload'].'covers/'.$filename, 'jpg');
		
		
		
		//Накладываем изображение
		$size = getimagesize('i/address.png'); // Узнаем размеры логотипа
		$im = imagecreatefromjpeg('data/events/covers/'.$filename);
		$im2 = imagecreatefrompng('i/address.png'); 
		imagecopy($im, $im2, 5, 5, 0, 0, $size['0'], $size['1']); // Вставляем логотип
		imagejpeg($im,'data/events/covers/'.$filename);
		imagedestroy($im);


        //preview
        try {
            $thumb = PhpThumbFactory::create($conf['dir']['upload'].'covers/'.$filename);
        }
        catch (Exception $e) {
            // handle error here however you'd like
            echo $e.' error occured!';
        }
        $thumb->resize(300, 1000);
        $thumb->cropFromCenter(300,400);

        $thumb->save($conf['dir']['upload'].'preview/'.$filename, 'jpg');

        chmod ($conf['dir']['upload'].'preview/'.$filename, 0755);


        //min
        try {
            $min = PhpThumbFactory::create($conf['dir']['upload'].'covers/'.$filename);
        }
        catch (Exception $e) {
            // handle error here however you'd like
            echo $e.' error occured!';
        }

        $min->resize(150, 500);
        $min->cropFromCenter(150,200);
        $min->save($conf['dir']['upload'].'m/'.$filename, 'jpg');

        chmod ($conf['dir']['upload'].'m/'.$filename, 0755);

    }
}
?>
