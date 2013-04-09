<?
class Output {

function Output(){
	global $pathname,$pathsize;
	$pathname = $this->parse_path($_SERVER['REQUEST_URI']);
	$pathsize = sizeof($pathname);
}

function AuthCheck($flag=''){
    global $user;

    if($flag=='admin')
    {
     if(isset($user) && $user['usertype']==2){
         return true;
     }
    }
    else
    if(isset($user['id']) && $user['id'])
    {
        return true;
    }
    else
    {
    return false;
    }
}

function parse_path($address) {
        global $docroot;
        $temp=addslashes($address);
       $temp=parse_url($temp);
       if (isset($temp['query'])&&$temp['query']=='print'){
       	$skin='print';
       } else if (isset($temp['query'])){
       	$query = $temp['query'];
	}
	$url=$temp['path'];
	$url=urldecode($url);
#	$url=strtolower ($url);
	$url=str_replace(' ','_',$url);
	$url=str_replace('\\','/',$url);
	$url=trim ($url, '/');
	$pathname=explode ('/',$url);

        if($docroot!="")
        {
	array_shift($pathname);
        }
	if (!isset($pathname) || !isset($pathname[0]) || $pathname[0]=='')
	{
		$pathname = array();
	}
	return $pathname;
}

function title($header, $path='', $mode='both') {
// name, path
	global $head, $crumbs;
	$crumbs[] = array( 'name'=> $header, 'path'=> $path );
	if ($mode == 'head' || $mode == 'both') {
		$head = $header.' &raquo; '.$head;
	}
	if ($mode == 'header' || $mode == 'both') {
	echo '<h1>'.$header.'</h1>';
	}
}

function post_check()
{
	global $post;
	if(isset($_POST['send']))
	{
		foreach ($_POST['send'] as $key => $value)
	    {
			$post[$key] = trim($value);
			$post[$key] = addslashes($value);
		}
	} else if(!empty($_POST)) {
		foreach ($_POST as $key => $value)
	    {
			$post[$key] = trim($value);
			$post[$key] = addslashes($value);
		}
	}
}

function validate_post()
{
	global $post;
	if(!empty($_POST)) {
		foreach ($_POST as $key => $value)
	    {
			$post[$key] = trim($value);
		}
	}
}

function post_out($data) {
	foreach ($data as $key => $value) {
		$data[$key] = stripslashes($value);
	}
	return $data;
}

function get_check()
{
	global $get;
	if(isset($_GET)) {
		foreach ($_GET as $key => $value) {
			$get[$key] = addslashes($value);
			$get[$key] = trim($value);
		}
	}
}

function redirect($target) {
	header('status: 303 See Other');
	header("Location: ".$target);
	exit;
}

function imTranslite($str){
	// �������������� ��������� �������� �� ��������� � ����� ����������
	// (c)Imbolc http://php.imbolc.name

	static $tbl= array(
		'�'=>'a', '�'=>'b', '�'=>'v', '�'=>'g', '�'=>'d', '�'=>'e', '�'=>'g', '�'=>'z',
		'�'=>'i', '�'=>'y', '�'=>'k', '�'=>'l', '�'=>'m', '�'=>'n', '�'=>'o', '�'=>'p',
		'�'=>'r', '�'=>'s', '�'=>'t', '�'=>'u', '�'=>'f', '�'=>'i', '�'=>'e', '�'=>'A',
		'�'=>'B', '�'=>'V', '�'=>'G', '�'=>'D', '�'=>'E', '�'=>'G', '�'=>'Z', '�'=>'I',
		'�'=>'Y', '�'=>'K', '�'=>'L', '�'=>'M', '�'=>'N', '�'=>'O', '�'=>'P', '�'=>'R',
		'�'=>'S', '�'=>'T', '�'=>'U', '�'=>'F', '�'=>'I', '�'=>'E', '�'=>"yo", '�'=>"h",
		'�'=>"ts", '�'=>"ch", '�'=>"sh", '�'=>"shch", '�'=>"", '�'=>"", '�'=>"yu", '�'=>"ya",
		'�'=>"YO", '�'=>"H", '�'=>"TS", '�'=>"CH", '�'=>"SH", '�'=>"SHCH", '�'=>"", '�'=>"",
		'�'=>"YU", '�'=>"YA"
	);

    return strtr($str, $tbl);
}

function slug($string) {
		$string = $this->imTranslite($string);
        $slug = preg_replace("/[^a-zA-Z0-9 -]/", "", $string); // only take alphanumerical characters, but keep the spaces and dashes too...
		$slug = $this->crop($slug, 32);
        $slug = str_replace(" ", "-", $slug); // replace spaces by dashes
        $slug = strtolower($slug);  // make it lowercase
        return $slug;
}
	
function crop($str, $len) {
    if ( strlen($str) <= $len ) {
        return $str;
    }

    // find the longest possible match
    $pos = 0;
    foreach ( array('. ', '? ', '! ') as $punct ) {
        $npos = strpos($str, $punct);
        if ( $npos > $pos && $npos < $len ) {
            $pos = $npos;
        }
    }

    if ( !$pos ) {
        // substr $len-3, because the ellipsis adds 3 chars
        return substr($str, 0, $len-3); 
    }
    else {
        // $pos+1 to grab punctuation mark
        return substr($str, 0, $pos+1);
    }
}
	
function generatePassword ($length = 8)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  // done!
  return $password;

}
      
function declension($int, $expressions) 
    { 
        if (count($expressions) < 3) $expressions[2] = $expressions[1];
        settype($int, "integer"); 
        $count = $int % 100; 
        if ($count >= 5 && $count <= 20) { 
            $result = $expressions['2']; 
        } else { 
            $count = $count % 10; 
            if ($count == 1) { 
                $result = $expressions['0']; 
            } elseif ($count >= 2 && $count <= 4) { 
                $result = $expressions['1']; 
            } else { 
                $result = $expressions['2']; 
            }
        } 
        return $result; 
    }


    function sort2d ($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE) 
    {
        if(is_array($array) && count($array)>0) 
        {
           foreach(array_keys($array) as $key) 
               $temp[$key]=$array[$key][$index];
               if(!$natsort) 
                   ($order=='asc')? asort($temp) : arsort($temp);
              else 
              {
                 ($case_sensitive)? natsort($temp) : natcasesort($temp);
                 if($order!='asc') 
                     $temp=array_reverse($temp,TRUE);
           }
           foreach(array_keys($temp) as $key) 
               (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
           return $sorted;
      }
      return $array;
    }

function message_show($data, $isbb=0) {


    /*
    $data = stripslashes($data);

    //Подсвечиваем email
    $data = preg_replace( '{ [\w-/\+.]+ @ [\w-]+\.([\w-]+)* }xs', '<a href="mailto:$0">$0</a>', $data );

    $data = nl2br($data);

    $result = new bbcode($data);
    $data = $result->get_html();
    */

    //Подсвечиваем ссылки
    //$data = hrefActivate($data);



    if($isbb)
    {
    $data = stripslashes($data);
    $data = html_entity_decode($data);
    $result = new bbcode($data);
    $data = $result->get_html();

    }
    else
    {
    $data = stripslashes($data);
    $data = html_entity_decode($data);     $data = htmlspecialchars($data);

    }


    $data = nl2br($data);


    return $data;
}


function send_mail($subject,$template,$address){

        if(is_array($address)){
        array_unique($address);
        }
        
        //При сортировке в логах видны повторы - удобней ловить ошибки
        if(is_array($address)) 
            { sort($address); }

        global $user,$mail,$conf,$body_mail;
        

	$mail->IsSMTP(); // telling the class to use SendMail transport
	

        if(is_file($conf['dir']['skin'].'email/'.$template.'.php')){
	ob_start();
        require($conf['dir']['skin'].'email/'.$template.'.php');
        $body_mail = ob_get_contents();
	ob_end_clean();
        } else {
        $body_mail = $template;
        }

	
#echo $body_mail;
	try {
                $mail->ClearAddresses();
                
		if(is_array($address)) {
			foreach($address as $v) {
			  $mail->AddAddress($v);
			}
		} else {
			$mail->AddAddress($address);
		}
		$mail->FromName = $conf['sitename'];
		$mail->Subject = $subject;
		$mail->MsgHTML($body_mail);

	  	$mail->Send();
		return true;
	} catch (phpmailerException $e) {
	  echo $e->errorMessage(); //Pretty error messages from PHPMailer
	  echo 'PHPMailer';
	} catch (Exception $e) {
	  echo $e->getMessage(); //Boring error messages from anything else!
	  echo 'else!';
	}
      }



// class end
}

function url_encode($s) {
    $s= strtr ($s, array (" "=> "%20", "а"=>"%D0%B0", "А"=>"%D0%90","б"=>"%D0%B1", "Б"=>"%D0%91", "в"=>"%D0%B2", "В"=>"%D0%92", "г"=>"%D0%B3", "Г"=>"%D0%93", "д"=>"%D0%B4", "Д"=>"%D0%94", "е"=>"%D0%B5", "Е"=>"%D0%95", "ё"=>"%D1%91", "Ё"=>"%D0%81", "ж"=>"%D0%B6", "Ж"=>"%D0%96", "з"=>"%D0%B7", "З"=>"%D0%97", "и"=>"%D0%B8", "И"=>"%D0%98", "й"=>"%D0%B9", "Й"=>"%D0%99", "к"=>"%D0%BA", "К"=>"%D0%9A", "л"=>"%D0%BB", "Л"=>"%D0%9B", "м"=>"%D0%BC", "М"=>"%D0%9C", "н"=>"%D0%BD", "Н"=>"%D0%9D", "о"=>"%D0%BE", "О"=>"%D0%9E", "п"=>"%D0%BF", "П"=>"%D0%9F", "р"=>"%D1%80", "Р"=>"%D0%A0", "с"=>"%D1%81", "С"=>"%D0%A1", "т"=>"%D1%82", "Т"=>"%D0%A2", "у"=>"%D1%83", "У"=>"%D0%A3", "ф"=>"%D1%84", "Ф"=>"%D0%A4", "х"=>"%D1%85", "Х"=>"%D0%A5", "ц"=>"%D1%86", "Ц"=>"%D0%A6", "ч"=>"%D1%87", "Ч"=>"%D0%A7", "ш"=>"%D1%88", "Ш"=>"%D0%A8", "щ"=>"%D1%89", "Щ"=>"%D0%A9", "ъ"=>"%D1%8A", "Ъ"=>"%D0%AA", "ы"=>"%D1%8B", "Ы"=>"%D0%AB", "ь"=>"%D1%8C", "Ь"=>"%D0%AC", "э"=>"%D1%8D", "Э"=>"%D0%AD", "ю"=>"%D1%8E", "Ю"=>"%D0%AE", "я"=>"%D1%8F", "Я"=>"%D0%AF"));
    return $s;
}
// функция раскодирует строку из URL
function url_decode($s) {
    $s= strtr ($s, array ("%20"=>" ", "%D0%B0"=>"а", "%D0%90"=>"А", "%D0%B1"=>"б", "%D0%91"=>"Б", "%D0%B2"=>"в", "%D0%92"=>"В", "%D0%B3"=>"г", "%D0%93"=>"Г", "%D0%B4"=>"д", "%D0%94"=>"Д", "%D0%B5"=>"е", "%D0%95"=>"Е", "%D1%91"=>"ё", "%D0%81"=>"Ё", "%D0%B6"=>"ж", "%D0%96"=>"Ж", "%D0%B7"=>"з", "%D0%97"=>"З", "%D0%B8"=>"и", "%D0%98"=>"И", "%D0%B9"=>"й", "%D0%99"=>"Й", "%D0%BA"=>"к", "%D0%9A"=>"К", "%D0%BB"=>"л", "%D0%9B"=>"Л", "%D0%BC"=>"м", "%D0%9C"=>"М", "%D0%BD"=>"н", "%D0%9D"=>"Н", "%D0%BE"=>"о", "%D0%9E"=>"О", "%D0%BF"=>"п", "%D0%9F"=>"П", "%D1%80"=>"р", "%D0%A0"=>"Р", "%D1%81"=>"с", "%D0%A1"=>"С", "%D1%82"=>"т", "%D0%A2"=>"Т", "%D1%83"=>"у", "%D0%A3"=>"У", "%D1%84"=>"ф", "%D0%A4"=>"Ф", "%D1%85"=>"х", "%D0%A5"=>"Х", "%D1%86"=>"ц", "%D0%A6"=>"Ц", "%D1%87"=>"ч", "%D0%A7"=>"Ч", "%D1%88"=>"ш", "%D0%A8"=>"Ш", "%D1%89"=>"щ", "%D0%A9"=>"Щ", "%D1%8A"=>"ъ", "%D0%AA"=>"Ъ", "%D1%8B"=>"ы", "%D0%AB"=>"Ы", "%D1%8C"=>"ь", "%D0%AC"=>"Ь", "%D1%8D"=>"э", "%D0%AD"=>"Э", "%D1%8E"=>"ю", "%D0%AE"=>"Ю", "%D1%8F"=>"я", "%D0%AF"=>"Я"));
    return $s;
}

function ucfirstUtf($var) {
    $string = iconv("UTF-8", "Windows-1251", $var);
    $string = ucfirst($string);
    $string = iconv("Windows-1251", "UTF-8", $string);
    return $string;
}



?>
