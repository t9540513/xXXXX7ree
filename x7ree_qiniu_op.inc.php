<?php
/*
	(C)2006-2020 www.7ree.com
	This is NOT a freeware, use is subject to license terms
	Update: 2020/4/28 10:10
	Agreement: https://addon.dismall.com/?@7.developer.doc/agreement_7ree_html
	More Plugins: https://addon.dismall.com/?@x7ree
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$vars_7ree = $_G['cache']['plugin']['x7ree_v'];

if(!$vars_7ree['agreement_7ree']) showmessage('x7ree_v:php_lang_agree_7ree');

require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/function_7ree.php';

if(!$_G['uid']){
 	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}

if($_GET['formhash']<>FORMHASH) showmessage('Access Deined @7ree');

$code_7ree = intval($_GET['code_7ree']);
$id_7ree = intval($_GET['id_7ree']);
$file_7ree = dhtmlspecialchars(trim($_GET['file_7ree']));

if(!$file_7ree){
 	showmessage('ERR##MISS FILE@7REE.');
}

if(!$code_7ree){//上传图片入临时数据库
	$valuearray_7ree = array(
								'file_7ree'=>$file_7ree,
								'uid_7ree'=>$_G['uid'],
								'time_7ree'=>$_G['timestamp'],
							);
		data_update_7ree('x7ree_v_qiniu',$valuearray_7ree,array(),array(),'');
		echo('OK上传完成。file='.$file_7ree);
}elseif($code_7ree==1){//上传成功，删除临时数据表

//}elseif($code_7ree==2){

//}elseif($code_7ree==3){


}else{
	
	showmessage("Undefined Operation @ 7ree.com");
	
}

?>