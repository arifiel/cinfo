<?
class Vkapi {

	protected static $_client_id = 2473351;
	protected static $_access_token = '0f25c52f0ec2e0290ec2e029010ee75dae00ec00ec3c029e9f487b559f020e5';

	public static function invoke ($name, array $params = array())
	{
		$params['access_token'] = self::$_access_token;

		$content = file_get_contents('https://api.vkontakte.ru/method/'.$name.'?'.http_build_query($params));
		$result = json_decode($content);

		return $result->response;
	}

	public static function auth (array $scopes)
	{
		header('Content-type: text/html; charset=windows-1251');

		echo file_get_contents('http://oauth.vkontakte.ru/authorize?'.http_build_query(array(
		'client_id' => self::$_client_id,
		'scope' => implode(',', $scopes),
		'redirect_uri' => 'http://api.vkontakte.ru/blank.html',
		'display' => 'page',
		'response_type' => 'token'
		)));
	}

}
?>