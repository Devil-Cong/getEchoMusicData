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

	public static function ParallelRequestWithCookie($urls) {
		$max_size = 20;
		$mh       = curl_multi_init();
		for ($i = 0; $i < $max_size; $i++) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $urls[$i]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_COOKIE, C('MINE_COOKIE'));
			curl_multi_add_handle($mh, $ch);
		}
		$user_arr = array();

		do {
			//运行当前 cURL 句柄的子连接
			while (($cme = curl_multi_exec($mh, $active)) == CURLM_CALL_MULTI_PERFORM);

			if ($cme != CURLM_OK) {break;}
			//获取当前解析的cURL的相关传输信息
			while ($done = curl_multi_info_read($mh)) {
				$info       = curl_getinfo($done['handle']);
				$tmp_result = curl_multi_getcontent($done['handle']);
				$error      = curl_error($done['handle']);

				$user_arr[] = $tmp_result; //array_values(getUserInfo($tmp_result));

				//保证同时有$max_size个请求在处理
				if ($i < sizeof($urls) && isset($urls[$i]) && $i < count($urls)) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $urls[$i]);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
					curl_setopt($ch, CURLOPT_COOKIE, C('MINE_COOKIE'));
					curl_multi_add_handle($mh, $ch);
					$i++;
				}

				curl_multi_remove_handle($mh, $done['handle']);
			}

			if ($active) {
				curl_multi_select($mh, 10);
			}

		} while ($active);

		curl_multi_close($mh);
		return $user_arr;
	}

}