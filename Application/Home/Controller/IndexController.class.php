<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function index() {
		echo '初始化Channel:<br />';
		$this->getChannelList();
		echo '<hr />';

		$obj         = M('Channel');
		$channelList = $obj->select();
		foreach ($channelList as $key => $value) {
			echo $value['title'] . ':<br />';
			$this->getSoundByChannel($value);
			echo '<hr />';
		}

	}

	public function getSoundByChannel($value) {
		for ($j = 1; $j < 100; $j++) {
			$url    = 'http://www.app-echo.com' . $value['url'] . '?&page=' . $j . '&per-page=14';
			$result = API::RequestWithCookie($url);
			$rule   = '/<h3 class\=\"voice-name\"><a href\=\"(.+)\">(.+)<\/a><\/h3>|title\=\"分享数目\">(.+)<\/small>|title\=\"喜欢数目\">(.+)<\/small>|title\=\"评论数目\">(.+)<\/small>/';
			preg_match_all($rule, $result, $preg);
			if ($preg[0]) {
				$obj  = M('Sound');
				$list = [];
				for ($i = 0; $i < 56; $i++) {
					$remainder = $i % 4;
					switch ($remainder) {
					case 0:
						$temp['channel_id'] = $value['id'];
						$temp['title']      = $preg[2][$i];
						$temp['url']        = $preg[1][$i];
						break;
					case 1:
						$temp['share'] = $preg[3][$i];
						break;
					case 2:
						$temp['like'] = $preg[4][$i];
						break;
					case 3:
						$temp['comment'] = $preg[5][$i];
						if ($temp['title']) {
							array_push($list, $temp);
						}
						$temp = null;
						break;
					}
				}
				$obj->addAll($list);
				echo 'page ' . $j . ' finish<br />';
				// var_dump($list);
				ob_flush();
				flush();
			} else {
				break;
			}
		}
	}

	public function getChannelList() {
		for ($j = 1; $j <= 12; $j++) {
			$url    = 'http://www.app-echo.com/channel/list?&page=' . $j . '&per-page=16';
			$result = API::RequestWithCookie($url);
			$rule   = '/<h3>(.+)<\/h3>|<a href\=\"(.+)\"><\/a>/';
			preg_match_all($rule, $result, $preg);

			$rule = '/\/channel\/\d+/';
			$obj  = M('Channel');
			$list = [];
			for ($i = 0; $i < 32; $i++) {
				if ($i % 2) {
					$temp['url'] = $preg[2][$i];
					if (preg_match($rule, $temp['url'])) {
						array_push($list, $temp);
					}
					$temp = null;
				} else {
					$temp['title'] = $preg[1][$i];
				}
			}
			$obj->addAll($list);
			echo 'page ' . $j . ' finish<br />';
			ob_flush();
			flush();
		}
	}
}