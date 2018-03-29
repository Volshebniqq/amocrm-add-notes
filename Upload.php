<?php

class Upload {

	public $login;
	public $subdomain;
	public $api_key;

	function __construct($login, $subdomain, $api_key) {
		$this->login = $login;
		$this->subdomain = $subdomain;
		$this->api_key = $api_key;
	}

	function connect() {

		header('Content-type: text/html; charset=utf-8');   
 	
 		$user=array(
		  'USER_LOGIN'=>$this->login,
		  'USER_HASH'=>$this->api_key
		);

		$link='https://'.$this->subdomain.'.amocrm.ru/private/api/auth.php?type=json';

		$curl=curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
		curl_setopt($curl,CURLOPT_URL,$link);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
		curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
		curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
		curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

		$out=curl_exec($curl);
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);

		$code=(int)$code;
		$errors=array(
		    301=>'Moved permanently',
		    400=>'Bad request',
		    401=>'Unauthorized',
		    403=>'Forbidden',
		    404=>'Not found',
		    500=>'Internal server error',
		    502=>'Bad gateway',
		    503=>'Service unavailable'
		);
		try
		{
		    if($code!=200 && $code!=204)
		        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
		}
		catch(Exception $E)
		{
		    die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
		}
		
		$Response=json_decode($out,true);
		$Response=$Response['response'];
		var_dump($Response);
	}

	function send($id, $text) {

		$data = array (
		  'add' =>
		  array (
		    0 =>
		    array (
		      'element_id' => $id,
		      'element_type' => '2',
		      'text' => $text,
		      'note_type' => '4',
		      'created_at' => '1509570000',
		      'responsible_user_id' => '504141',
		      'created_by' => '504141',
		    ),
		  ),
		);

		$link='https://'.$this->subdomain.'.amocrm.ru/api/v2/notes';

		$curl=curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
		curl_setopt($curl,CURLOPT_URL,$link);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
		curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
		curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
		curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		$out=curl_exec($curl);
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);

		$code=(int)$code;
		$errors=array(
		  301=>'Moved permanently',
		  400=>'Bad request',
		  401=>'Unauthorized',
		  403=>'Forbidden',
		  404=>'Not found',
		  500=>'Internal server error',
		  502=>'Bad gateway',
		  503=>'Service unavailable'
		);
		try
		{
		 if($code!=200 && $code!=204)
		    throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
		}
		catch(Exception $E)
		{
		  die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
		}
	}


}

?>