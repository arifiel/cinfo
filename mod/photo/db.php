<?php
    require_once $conf['dir']['inc'].'/phpthumb/ThumbLib.inc.php';
	
function add_foto($item_id,$i) {
    global $conf, $post, $data, $img, $mod,$pathname;


	$toupload = $conf['dir']['upload'].$pathname[0].'/';
	
    if (isset($_FILES['upload']['tmp_name'][$i]) && $_FILES['upload']['tmp_name'][$i]!="") {

    $filename = $item_id.'.jpg';
        move_uploaded_file($_FILES['upload']['tmp_name'][$i], $toupload.'big/'.$filename);
        $post['img'] = $filename;
        chmod ($toupload.'big/'.$filename, 0755);


        //photo
        try {
            $cover = PhpThumbFactory::create($toupload.'big/'.$filename);
        }
        catch (Exception $e) {
            // handle error here however you'd like
            echo $e.' error occured!';
        }

        $cover->resize(1024, 768);
        $cover->cropFromCenter(1024,768);
        $cover->save($toupload.'big/'.$filename, 'jpg');
		
		
		
		//Накладываем изображение
		$size = getimagesize('i/photo_label.png'); // Узнаем размеры логотипа
		$im = imagecreatefromjpeg('data/photo/big/'.$filename);
		$im2 = imagecreatefrompng('i/photo_label.png'); 
		imagecopy($im, $im2, 5, 5, 0, 0, $size['0'], $size['1']); // Вставляем логотип
		imagejpeg($im,'data/photo/big/'.$filename);
		imagedestroy($im);


        //min
        try {
            $min = PhpThumbFactory::create($toupload.'big/'.$filename);
        }
        catch (Exception $e) {
            // handle error here however you'd like
            echo $e.' error occured!';
        }

        $min->resize(150, 200);
        $min->save($toupload.'min/'.$filename, 'jpg');

        chmod ($toupload.'min/'.$filename, 0755);

    }
}
?>
