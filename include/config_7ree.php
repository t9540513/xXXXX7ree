<?php
/*
	[www.7ree.com] (C)2007-2018 7ree.com.
	This is NOT a freeware, use is subject to license terms
	Update: 2018/9/5 15:10
	Agreement: http://addon.dismall.com/?@7.developer.doc/agreement_7ree_html
	More Plugins: http://addon.dismall.com/?@7ree
*/

//七牛API参数配置文件

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['uid']) showmessage('not_loggedin', NULL, array(), array('login' => 1));

define('AK_7REE','');//ak
define('SK_7REE','');//sk
define('BK_7REE','');//空间
define('UH_7REE','');//上传服务器
define('WL_7REE','');//外链域名

?>