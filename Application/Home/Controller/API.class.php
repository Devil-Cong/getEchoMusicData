<?php
namespace Home\Controller;
class API {
	public static function RequestWithCookie($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_COOKIE, C('MINE_COOKIE'));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

}