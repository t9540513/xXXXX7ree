<?php
/*
 * [www.7ree.com] (C)2006-2021 7ree.com.
 * This is NOT a freeware, use is subject to license terms
 * Agreement: https://addon.dismall.com/?@7.developer.doc/agreement_7ree_html
 * More Plugins: https://addon.dismall.com/developer-7.html
 * EMail: service@7ree.com
 * QQ: 860618629
 * WeiXin: www_7ree_com
 * Update: 2021-06-22 20:07:15
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$vars_7ree = $_G['cache']['plugin']['x7ree_v'];
require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/function_7ree.php';

if(!$vars_7ree['agreement_7ree']) showmessage('x7ree_v:php_lang_agree_7ree');

require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/function_7ree.php';
$navtitle = $vars_7ree['navtitle_7ree'];

if($_GET['formhash']<>FORMHASH){
	showmessage("Access Denied");
}

if(!$_G['uid']){
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}

$vid_7ree=intval($_GET['vid_7ree']);
$zanid_7ree='zan_7ree_'.$vid_7ree;

$yizan_7ree = getcookie($zanid_7ree);
if(!$yizan_7ree && $_G['uid']){
	//sql查询是否已赞
	$yizan_7ree = DB::result_first("SELECT id_7ree FROM ".DB::table('x7ree_v_zan')." WHERE id_7ree='$vid_7ree' AND uid_7ree='$_G[uid]'");
}

if($yizan_7ree){
	//已经赞过了，不重复操作
}else{
	//点赞动作
	DB::query("UPDATE ".DB::table('x7ree_v_main')." SET zan_7ree=zan_7ree+1 WHERE id_7ree ='$vid_7ree' LIMIT 1");
	//记录点赞日志避免重复点击
	$valuearray_7ree = array(
									'id_7ree'=>$vid_7ree,
									'uid_7ree'=>$_G['uid']
								);
	data_update_7ree('x7ree_v_zan',$valuearray_7ree,array(),array(),'');
	dsetcookie($zanid_7ree, $vid_7ree, 86400);
}
	$zannum_7ree=DB::result_first("SELECT zan_7ree FROM ".DB::table('x7ree_v_main')." WHERE id_7ree='$vid_7ree'");




	include template('x7ree_v:dianzan_7ree');
?>