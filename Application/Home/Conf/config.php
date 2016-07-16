<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_L_DELIM'    => '<{',
	'TMPL_R_DELIM'    => '}>',
	'SHOW_PAGE_TRACE' => true, //显示调试面板
	/*数据库配置*/
	'DB_TYPE'         => 'mysql', // 数据库类型
	'DB_HOST'         => '192.168.27.1', // 服务器地址
	'DB_NAME'         => 'echomusic', // 数据库名
	'DB_USER'         => 'root', // 用户名
	'DB_PWD'          => '123456', // 密码
	'DB_PORT'         => 3306, // 端口
	'DB_PREFIX'       => 'em_', // 数据库表前缀
	'DB_CHARSET'      => 'utf8', // 字符集
	'DB_DEBUG'        => TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

	'MINE_COOKIE'     => '_csrf=9da154dde6607b1eb566c786ff2d6290b21b30b8fb00d33c478166efe2e339c4a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22pyYUQDN76yJ89mm5pLfOZucLPmAGn4Os%22%3B%7D; PHPSESSID=ld98k58rums89cujidkkcqglm3; Hm_lvt_46b3b8e7eb78200527b089c276c81a7e=1453967669; Hm_lpvt_46b3b8e7eb78200527b089c276c81a7e=1453967693',
);