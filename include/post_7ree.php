<?php
/*
 * [www.7ree.com] (C)2006-2021 7ree.com.
 * This is NOT a freeware, use is subject to license terms
 * Agreement: https://addon.dismall.com/?@7.developer.doc/agreement_7ree_html
 * More Plugins: https://addon.dismall.com/developer-7.html
 * EMail: service@7ree.com
 * QQ: 860618629
 * WeiXin: www_7ree_com
 * Update: 2021-11-17 16:23:32
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$vars_7ree = $_G['cache']['plugin']['x7ree_v'];

$navtitle = $vars_7ree['navtitle_7ree'];



///// 自动生成论坛视频主题帖的流程
require_once DISCUZ_ROOT.'./source/function/function_forum.php'; 
require_once DISCUZ_ROOT.'./source/function/function_post.php';


	$subject_7ree = '['.$fenlei_7ree.'] '.$name_7ree;
	$post_7ree = '[x7ree_v]'.$url_7ree.'[/x7ree_v][hr]'.$detail_7ree;

	DB::query("INSERT INTO ".DB::table('forum_thread')." (fid, author, authorid, subject, dateline, lastpost, lastposter)
VALUES ('$vars_7ree[fid_7ree]', '{$_G[username]}', '{$_G[uid]}', '{$subject_7ree}', '{$_G[timestamp]}', '{$_G[timestamp]}', '{$_G[username]}')");
	$tid = DB::insert_id();	


	$pid = insertpost(array(
	'fid' => $vars_7ree['fid_7ree'],
	'tid' => $tid,
	'first' => '1',
	'author' => $_G['username'],
	'authorid' => $_G['uid'],
	'subject' => $subject_7ree,
	'dateline' => $_G['timestamp'],
	'message' => $post_7ree,
	'useip' => $_G['clientip'],
	'invisible' => $pinvisible,
	'anonymous' => $isanonymous,
	'usesig' => $usesig,
	'htmlon' => $htmlon,
	'bbcodeoff' => $bbcodeoff,
	'smileyoff' => $smileyoff,
	'parseurloff' => $parseurloff,
	'attachment' => '0',
	'tags' => $tagstr,
	'replycredit' => 0,
	'status' => (defined('IN_MOBILE') ? 8 : 0)
));


DB::query("UPDATE ".DB::table('forum_thread')." SET lastposter='$_G[username]', lastpost='$_G[timestamp]', replies=replies+1 WHERE tid='{$tid}'", 'UNBUFFERED');		
	
$lastpost = "$tid\t{$subject_7ree}\t{$_G[timestamp]}\t{$_G[username]}";
DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$lastpost', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='{$vars_7ree[fid_7ree]}'", 'UNBUFFERED');






?>