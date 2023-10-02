<?php
/*
 * [www.7ree.com] (C)2006-2021 7ree.com.
 * This is NOT a freeware, use is subject to license terms
 * Agreement: https://addon.dismall.com/?@7.developer.doc/agreement_7ree_html
 * More Plugins: https://addon.dismall.com/developer-7.html
 * EMail: service@7ree.com
 * QQ: 860618629
 * WeiXin: www_7ree_com
 * Update: 2022-01-13 17:11:50
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$vars_7ree = $_G['cache']['plugin']['x7ree_v'];

$navtitle = $vars_7ree['navtitle_7ree'];

$navtitle = $vars_7ree['seo_title_7ree'] ?  $vars_7ree['seo_title_7ree'] : $vars_7ree['navtitle_7ree'];

$metakeywords = $vars_7ree['seo_keywords_7ree'];
$metadescription = $vars_7ree['seo_description_7ree'];


if(!$vars_7ree['agreement_7ree']) showmessage('x7ree_v:php_lang_agree_7ree');

$code_7ree = intval($_GET['code_7ree']);
$id_7ree = intval($_GET['id_7ree']);
$folder_7ree = 'source/plugin/x7ree_v/upload_img_7ree';

require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/function_7ree.php';


$rewrite_config_7ree = DISCUZ_ROOT.'source/plugin/x7ree_v/rewrite_config_7ree.inc.php';
if (file_exists($rewrite_config_7ree) && $vars_7ree['rewrite_7ree']){
	@include $rewrite_config_7ree;
}else{
	
	//小视频首页
	$home_url_7ree = "plugin.php?id=x7ree_v:x7ree_v";
	//小视频分类页
	$fenlei_url_7ree = "plugin.php?id=x7ree_v:x7ree_v&fenlei=";
	//小视频详情页
	$page_url_7ree = "plugin.php?id=x7ree_v:x7ree_v&code_7ree=1&id_7ree=";
	//我的小视频
	$wode_url_7ree = "plugin.php?id=x7ree_v:x7ree_v&code_7ree=3";
	//分享小视频
	$share_url_7ree = "plugin.php?id=x7ree_v:x7ree_v&code_7ree=2";
	//管理小视频
	$admin_url_7ree = "plugin.php?id=x7ree_v:x7ree_v&code_7ree=4";
}



$exttitle_7ree = $_G['setting']['extcredits'][$vars_7ree['ext_7ree']][title];

$fenlei_7ree = explode(',',trim($vars_7ree['fenlei_7ree']));

$gid_7ree = $vars_7ree['gid_7ree'] ? unserialize($vars_7ree['gid_7ree']) : array();
$postgid_7ree = in_array($_G['groupid'],$gid_7ree);

$gid2_7ree = $vars_7ree['uploadgid_7ree'] ? unserialize($vars_7ree['uploadgid_7ree']) : array();
$uploadgid_7ree = in_array($_G['groupid'],$gid2_7ree);

if($vars_7ree['mobbtn4_7ree']){
	$mobbtn4_7ree=explode('|',trim($vars_7ree['mobbtn4_7ree']));
}else{
	$mobbtn4_7ree=array('forum.php',lang('plugin/x7ree_v','php_lang_luntan_7ree'));
}

if(in_array($code_7ree, array("2","3","4","5","6","7","8")) && !$_G['uid']) showmessage('not_loggedin', NULL, array(), array('login' => 1));

if(in_array($code_7ree,array("4","5","6")) && !$_G['adminid']) showmessage( "Access Deined @7ree" );

if(in_array($code_7ree,array("1","6")) && !$id_7ree) showmessage( "ERROR,Missing required parameter.@7ree" );

if(in_array($code_7ree,array("5","7")) && !submitcheck('submit_7ree')) showmessage("Access Deined @7ree");

if(in_array($code_7ree,array("6")) && $_GET['formhash']<>FORMHASH) showmessage('Access Deined @7ree');

//vip用户组免费判定
$vipgids_7ree = $vars_7ree['vipgids_7ree'] ? unserialize($vars_7ree['vipgids_7ree']) : array();

if(!$code_7ree){//v首页


	if($_GET['searchkey_7ree']){
			$searchkey_7ree = dhtmlspecialchars(trim($_GET['searchkey_7ree']));
			$searchwhere_7ree = "AND name_7ree LIKE '%{$searchkey_7ree}%'";
	}else{

			if(defined('IN_MOBILE')){
				$fotos_7ree = $vars_7ree['mob_fotos_7ree'] ? str_replace("\r\n","|||",$vars_7ree['mob_fotos_7ree']) : array();
			}else{
				$fotos_7ree = $vars_7ree['pc_fotos_7ree'] ? str_replace("\r\n","|||",$vars_7ree['pc_fotos_7ree']) : array();
			}

			if($fotos_7ree){
				$fotos_array =  explode('|||', $fotos_7ree);
				foreach($fotos_array as $fotos_value){
					$fotos_array2 = explode('=', $fotos_value);
					$fotos_array2['v_7ree'] = DB::fetch_first("SELECT id_7ree,name_7ree,detail_7ree FROM %t WHERE id_7ree=%d",array('x7ree_v_main',$fotos_value[0]));
					$photoslider_array[] = $fotos_array2;
				}
			}
	}


	$fenlei = INTVAL($_GET['fenlei']);
	$fenlei_key = max(0,$fenlei-1);
	$fenlei_where_7ree = $fenlei ? "AND fenlei_7ree='{$fenlei_7ree[$fenlei_key]}'":"";


	if($fenlei){
			$navtitle =$fenlei_7ree[$fenlei_key].'-'.$navtitle;
			$metakeywords = $fenlei_7ree[$fenlei_key].','.$metakeywords;
			$metadescription = $fenlei_7ree[$fenlei_key].','.$metadescription;
	}
	
	
	

	if($vars_7ree['orderby_7ree']=='1'){//发布顺序
		$orderby_7ree='ORDER BY id_7ree DESC';
	}elseif($vars_7ree['orderby_7ree']=='2'){//随机排序
		$orderby_7ree='ORDER BY rand()';
	}else{
		$orderby_7ree='ORDER BY id_7ree DESC';
	}


	if(defined('IN_MOBILE')){
			$height_7ree='240px';
			$height_m_7ree='80px';
	}else{
			$height_7ree='212px';
	}


	//视频地址解析
	require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/analysis_7ree.php';

	
	$page = max(1, intval($_GET['page']));
	$startpage = ( $page - 1 ) * 20;
	$querynum = DB::result_first( "SELECT Count(*) FROM ".DB::table('x7ree_v_main')." WHERE status_7ree=1 {$fenlei_where_7ree} {$searchwhere_7ree}");
	$query = DB::query( "SELECT * FROM ".DB::table('x7ree_v_main')." WHERE status_7ree=1 {$fenlei_where_7ree} {$searchwhere_7ree} {$orderby_7ree} LIMIT {$startpage},20" );
	while ($list_table = DB::fetch($query)){
			$list_table['time_7ree']=dgmdate($list_table['time_7ree'],'u');
			if(!$list_table['pic_7ree']){
				$list_table['showplay_7ree']=analysis_7ree($list_table['url_7ree'],$height_7ree);
			}
			//会员是否已付费判断，如已付费或无需付费则解析，否则只显示封面；
			if($_G['uid']){
				if(in_array($_G['groupid'],$vipgids_7ree)){
					$list_table['needpay_7ree'] = FALSE;
				}else{
						$pay_7ree = DB::result_first("SELECT * FROM ".DB::table('x7ree_v_buylog')." WHERE vid_7ree='$list_table[id_7ree]' AND uid_7ree='$_G[uid]'");
						if($pay_7ree>0){
							$list_table['needpay_7ree'] = FALSE;
						}else{
							$list_table['needpay_7ree'] = TRUE;
						}
				}
			}
			$list_7ree[]=$list_table;
	}
	$multipage = multi($querynum, 20, $page, "plugin.php?id=x7ree_v:x7ree_v&fenlei={$fenlei}&searchkey_7ree={$searchkey_7ree}" );

	//print_r($list_7ree);


}elseif($code_7ree==1){//v详情页
	$v_7ree = DB::fetch_first("SELECT * FROM ".DB::table('x7ree_v_main')." WHERE id_7ree='$id_7ree' AND status_7ree=1");
	if(!$v_7ree) showmessage('x7ree_v:php_lang_err_missv_7ree');
	
	$navtitle =$v_7ree['name_7ree'].'-'.$v_7ree['fenlei_7ree'].'-'.$navtitle;
	$metakeywords = $v_7ree['name_7ree'].','.$metakeywords;
	$metadescription = $v_7ree['name_7ree'].','.$metadescription;
	
	$v_7ree['detail_7ree'] = str_replace(PHP_EOL,"<br>", $v_7ree['detail_7ree']);
	$v_7ree['time_7ree']=dgmdate($v_7ree['time_7ree'],'u');
	$v_7ree['avatar_7ree']=avatar($v_7ree['uid_7ree'],small);
	$v_7ree['chatavt_7ree'] = str_replace('<img','<img class="chatavatar_7ree" ',$v_7ree['avatar_7ree']);
	
	//会员是否已付费判断，如已付费或无需付费则解析，否则只显示封面；
	if($_G['uid']){
		if(in_array($_G['groupid'],$vipgids_7ree)){
			$needpay_7ree = FALSE;
		}else{
				$pay_7ree = DB::result_first("SELECT * FROM ".DB::table('x7ree_v_buylog')." WHERE vid_7ree='$id_7ree' AND uid_7ree='$_G[uid]'");
				if($pay_7ree>0){
					$needpay_7ree = FALSE;
				}else{
					$needpay_7ree = TRUE;
				}
		}
	}

	if(defined('IN_MOBILE')){
			$height_7ree=$vars_7ree['mobplayer_h_7ree'] ? $vars_7ree['mobplayer_h_7ree'].'px' : '200px';
			$recommend_7ree = $vars_7ree['recommend2_7ree'] ? $vars_7ree['recommend2_7ree'] : 10;
	}else{
			$height_7ree=$vars_7ree['pcplayer_h_7ree'] ? $vars_7ree['pcplayer_h_7ree'].'px' : '400px';
			$recommend_7ree = $vars_7ree['recommend1_7ree'] ? $vars_7ree['recommend1_7ree'] : 10;
	}

	//视频地址解析
	require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/analysis_7ree.php';
	$showplay_7ree=analysis_7ree($v_7ree['url_7ree'],$height_7ree);

	$fenlei_id_7ree = fenlei_id_7ree($fenlei_7ree,$v_7ree['fenlei_7ree']);

	$query = DB::query( "SELECT * FROM ".DB::table('x7ree_v_main')." WHERE id_7ree<>'$id_7ree' AND status_7ree=1 ORDER BY id_7ree DESC LIMIT {$recommend_7ree}" );
	while ($list_table = DB::fetch($query)){
			$list_table['time_7ree']=dgmdate($list_table['time_7ree'],'u');
			if(!$list_table['pic_7ree']){
				$list_table['showplay_7ree']=analysis_7ree($list_table['url_7ree'],$height_7ree);
			}
			$list_7ree[]=$list_table;
	}
	
	$v_7ree['yizan_7ree'] = getcookie('zan_7ree_'.$v_7ree['id_7ree']);
	if(!$v_7ree['yizan_7ree'] && $_G['uid']){//如果cookie没有记录则再查询mysql数据表
			$v_7ree['yizan_7ree'] = DB::result_first("SELECT id_7ree FROM ".DB::table('x7ree_v_zan')." WHERE id_7ree='$id_7ree' AND uid_7ree='$_G[uid]'");
	}
	
	if($_G['uid']){//播放次数增加

		if($vars_7ree['randcount_7ree']){
				$randcount_7ree = explode(',',$vars_7ree['randcount_7ree']);
				$addnum_7ree = rand($randcount_7ree[0],$randcount_7ree[1]);
		}else{
				$addnum_7ree = 1;
		}
		DB::query("UPDATE ".DB::table('x7ree_v_main')." SET view_7ree=view_7ree+$addnum_7ree WHERE id_7ree ='$id_7ree' LIMIT 1");
	}
	
	//上一条
	$last_v_7ree=DB::fetch_first("SELECT * FROM ".DB::table('x7ree_v_main')." WHERE id_7ree<'$id_7ree' AND status_7ree=1 ORDER BY id_7ree DESC");
	//下一条
	$next_v_7ree=DB::fetch_first("SELECT * FROM ".DB::table('x7ree_v_main')." WHERE id_7ree>'$id_7ree' AND status_7ree=1 ORDER BY id_7ree ASC");
	
	//评论读取
	if($vars_7ree['replyon_7ree']){
		$page = max(1, intval($_GET['page']));
		$startpage = ( $page - 1 ) * 20;
		$querynum = DB::result_first( "SELECT Count(*) FROM ".DB::table('x7ree_v_discuss')." WHERE vid_7ree='$v_7ree[id_7ree]'");
		$query = DB::query( "SELECT * FROM ".DB::table('x7ree_v_discuss')." WHERE vid_7ree='$v_7ree[id_7ree]' ORDER BY id_7ree DESC LIMIT {$startpage},20" );
		while ($query_table = DB::fetch($query)){
				$query_table['time_7ree']=dgmdate($query_table['time_7ree'],'u');
				$query_table['avatar_7ree'] = avatar($query_table['uid_7ree'], small);
				$query_table['avatar_7ree'] = str_replace('<img','<img class="discussavatar_7ree" ',$query_table['avatar_7ree']);

				$discuzlist_7ree[]=$query_table;
		}
		$multipage = multi($querynum, 20, $page, "plugin.php?id=x7ree_v:x7ree_v&code_7ree=1&id_7ree=".$v_7ree['id_7ree']);
	}
	

}elseif($code_7ree==2){//发布，编辑

	if(!$postgid_7ree) showmessage('x7ree_v:php_lang_err_denied_7ree');

	if($id_7ree){
		$v_7ree = DB::fetch_first("SELECT * FROM ".DB::table('x7ree_v_main')." WHERE id_7ree = ".$id_7ree);
		$uid_7ree=$v_7ree['uid_7ree'];
		$user_7ree=$v_7ree['user_7ree'];
		if($_G['adminid']){
			$backurl_7ree=$admin_url_7ree;
		}else{
		$backurl_7ree=$wode_url_7ree;
		}
	}else{
		$uid_7ree=$_G['uid'];
		$user_7ree=$_G['username'];
		$backurl_7ree='plugin.php?id=x7ree_v:x7ree_v&code_7ree=2';
	}
	
	if($uploadgid_7ree && $vars_7ree['uploadtype_7ree']==2){
			require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/config_7ree.php';
			require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/qiniu_sdk/io.php';
			require_once DISCUZ_ROOT."./source/plugin/x7ree_v/include/qiniu_sdk/rs.php";
			require_once DISCUZ_ROOT."./source/plugin/x7ree_v/include/qiniu_sdk/fop.php";
			$GLOBALS['QINIU_UP_HOST'] = UH_7REE;
			$GLOBALS['QINIU_RS_HOST'] = 'http://rs.qbox.me';
			$GLOBALS['QINIU_RSF_HOST'] = 'http://rsf.qbox.me';
			
			Qiniu_setKeys(AK_7REE, SK_7REE);
			$putPolicy = new Qiniu_RS_PutPolicy(BK_7REE);
			$upToken = $putPolicy->Token(null);
	}
	
	
	if(submitcheck('submit_7ree')){



		
	//录入过滤
	$name_7ree = dhtmlspecialchars(trim($_GET['name_7ree']));
	$detail_7ree = dhtmlspecialchars(trim($_GET['detail_7ree']));
	$fenlei_7ree = dhtmlspecialchars(trim($_GET['fenlei_7ree']));
	$url_7ree = dhtmlspecialchars(trim($_GET['url_7ree']));
	$url2_7ree = dhtmlspecialchars(trim($_GET['url2_7ree']));	
	$cost_7ree = intval($_GET['cost_7ree']);
	

	if(!$name_7ree) showmessage('x7ree_v:php_lang_err_missname_7ree');
	//if(!$url_7ree) showmessage('x7ree_v:php_lang_err_missurl_7ree');
	if(!$url_7ree && !$_FILES['video_7ree']['size']) showmessage('x7ree_v:php_lang_err_missurl_7ree');

		if($_FILES['video_7ree']['size'] && $uploadgid_7ree){
			
/*
			require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/config_7ree.php';
			require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/qiniu_sdk/io.php';
			require_once DISCUZ_ROOT."./source/plugin/x7ree_v/include/qiniu_sdk/rs.php";
			require_once DISCUZ_ROOT."./source/plugin/x7ree_v/include/qiniu_sdk/fop.php";
			$GLOBALS['QINIU_UP_HOST'] = UH_7REE;
			$GLOBALS['QINIU_RS_HOST'] = 'http://rs.qbox.me';
			$GLOBALS['QINIU_RSF_HOST'] = 'http://rsf.qbox.me';
			
			Qiniu_setKeys(AK_7REE, SK_7REE);
			$putPolicy = new Qiniu_RS_PutPolicy(BK_7REE);
			$upToken = $putPolicy->Token(null);
*/
			if($vars_7ree['uploadtype_7ree']==2){
					$putExtra = new Qiniu_PutExtra();
					$putExtra->Crc32 = 1;
			}

			if($_FILES['video_7ree']['size'] > 1024*1024*$vars_7ree['upsize_7ree']){
				showmessage('x7ree_v:php_lang_err_toobig_7ree');
			}
			$source = $_FILES['video_7ree']['tmp_name'];
			$knamearray = explode(".",$_FILES['video_7ree']['name']);
			$kname = $knamearray[count($knamearray)-1];
			//仅限mp4文件才可以提交
			if($kname<>'mp4'){
				showmessage('x7ree_v:php_lang_err_mp4_7ree');
			}
			$rand_str = date("YmdHis");
			//文件名生成
			$file_name  = $rand_str."_".$_G['uid'].".".$kname;

			if($vars_7ree['uploadtype_7ree']==1){
					$folder2_7ree="source/plugin/x7ree_v/upload_video_7ree";
					$subname_7ree=$_G['uid'];
					$mp4name_7ree=upload_mp4_7ree($_FILES['video_7ree'],$folder2_7ree,1024*$vars_7ree['upsize_7ree'],$subname_7ree);
					$url_7ree=$_G['siteurl'].$folder2_7ree.'/'.$mp4name_7ree;
					//如果是编辑上传，则删除原视频文件
					if($id_7ree){
						$oldmp4url_7ree=DB::result_first( "SELECT url_7ree FROM ".DB::table('x7ree_v_main')." WHERE id_7ree='$id_7ree'");
						$delmp4_7ree = str_replace($_G['siteurl'],"",$oldmp4url_7ree);
						if(file_exists($delmp4_7ree)){
									unlink($delmp4_7ree);
						}
					}
					
					
			}elseif($vars_7ree['uploadtype_7ree']==2){
					list($ret, $err) = Qiniu_PutFile($upToken, $file_name, $source, $putExtra);
					//echo "====> Qiniu_PutFile result: \n";
					if ($err !== null) {
						//var_dump($err);
						showmessage('x7ree_v:php_lang_err_qiniu_7ree');
					} else {
						//var_dump($ret);
						$url_7ree=WL_7REE.$file_name;
					}
			}
		}
	
	
	$valuearray_7ree = array(
								'name_7ree'=>$name_7ree,
								'detail_7ree'=>$detail_7ree,
								'fenlei_7ree'=>$fenlei_7ree,
								'cost_7ree'=>$cost_7ree,
								'url_7ree'=>$url_7ree,
								'url2_7ree'=>$url2_7ree,								
								'uid_7ree'=>$uid_7ree,
								'user_7ree'=>$user_7ree,
								'time_7ree'=>$_G['timestamp'],
							);

	$imagearray_7ree = $_FILES['pic_7ree']['size'] ? array('pic_7ree'=>$_FILES['pic_7ree']): array();

	if($id_7ree){//提交编辑
		$wherearray_7ree = array('id_7ree'=>$id_7ree);
		data_update_7ree('x7ree_v_main',$valuearray_7ree,$wherearray_7ree,$imagearray_7ree,$folder_7ree);
		
	}else{//提交新增

		$gid_exempt_7ree = $vars_7ree['gid_exempt_7ree'] ? unserialize($vars_7ree['gid_exempt_7ree']) : array();
		if($gid_exempt_7ree){
			if(in_array($_G['groupid'],$gid_exempt_7ree)){
				$valuearray_7ree['status_7ree']=1;
			}
		}

		data_update_7ree('x7ree_v_main',$valuearray_7ree,array(),$imagearray_7ree,$folder_7ree);

		if($vars_7ree['fid_7ree']){//同步发帖
			require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/post_7ree.php';
		}


	}
	
	//清空当前会员所有的上传临时表
	DB::query("DELETE FROM ".DB::table('x7ree_v_qiniu')." WHERE uid_7ree='$_G[uid]'");
	
		showmessage('x7ree_v:php_lang_ok_submit_7ree',$backurl_7ree);
	}
	
}elseif($code_7ree==3){//我的v

	$page = max(1, intval($_GET['page']));
	$startpage = ( $page - 1 ) * 20;
	$querynum = DB::result_first( "SELECT Count(*) FROM ".DB::table('x7ree_v_main')." WHERE uid_7ree='$_G[uid]'");
	$query = DB::query( "SELECT * FROM ".DB::table('x7ree_v_main')." WHERE uid_7ree='$_G[uid]' ORDER BY id_7ree DESC LIMIT {$startpage},20" );
	while ($list_table = DB::fetch($query)){
			$list_table['time_7ree']=dgmdate($list_table['time_7ree'],'u');
			$list_7ree[]=$list_table;
	}
	$multipage = multi($querynum, 20, $page, "plugin.php?id=x7ree_v:x7ree_v&code_7ree=3" );
	
}elseif($code_7ree==4){//前台管理v

	$page = max(1, intval($_GET['page']));
	$startpage = ( $page - 1 ) * 20;
	$querynum = DB::result_first( "SELECT Count(*) FROM ".DB::table('x7ree_v_main'));
	$query = DB::query( "SELECT * FROM ".DB::table('x7ree_v_main')." ORDER BY id_7ree DESC LIMIT {$startpage},20" );
	while ($list_table = DB::fetch($query)){
			$list_table['time_7ree']=dgmdate($list_table['time_7ree'],'u');
			$list_7ree[]=$list_table;
	}
	$multipage = multi($querynum, 20, $page, "plugin.php?id=x7ree_v:x7ree_v&code_7ree=4" );
	
}elseif($code_7ree==5){//批量审核v动作
		if(count($_GET['mod_7ree'])){
			$mod_7ree = dintval((array)$_GET['mod_7ree'], true);
			if($vars_7ree['ext_7ree'] && $vars_7ree['reward_7ree']){
					$query = DB::query( "SELECT uid_7ree FROM ".DB::table('x7ree_v_main')." WHERE id_7ree IN(".dimplode($mod_7ree).") AND status_7ree=0 ORDER BY id_7ree DESC LIMIT 100" );
					while ($list_table = DB::fetch($query)){
						updatemembercount($list_table['uid_7ree'], array($vars_7ree['ext_7ree'] => $vars_7ree['reward_7ree']));
					}
			}
			DB::query("UPDATE ".DB::table('x7ree_v_main')." SET status_7ree = 1 WHERE id_7ree IN(".dimplode($mod_7ree).")");
			showmessage('x7ree_v:php_lang_ok_check_7ree',$admin_url_7ree);
		}else{
			showmessage('x7ree_v:php_lang_err_select_7ree',$admin_url_7ree);

		}
		showmessage('x7ree_v:php_lang_ok_edit_7ree',$admin_url_7ree);
	
}elseif($code_7ree==6){//删除v动作
		require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/config_7ree.php';
		$wherearray_7ree = array('id_7ree'=>$id_7ree);
		$imagearray_7ree = array('pic_7ree');
		data_delete_7ree('x7ree_v_main',$wherearray_7ree,$imagearray_7ree,$folder_7ree);
		
		
		if(strstr($v_7ree['url_7ree'],WL_7REE)){
				require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/qiniu_sdk/io.php';
				require_once DISCUZ_ROOT."./source/plugin/x7ree_v/include/qiniu_sdk/rs.php";
				require_once DISCUZ_ROOT."./source/plugin/x7ree_v/include/qiniu_sdk/fop.php";
				$GLOBALS['QINIU_UP_HOST'] = UH_7REE;
				$GLOBALS['QINIU_RS_HOST'] = 'http://rs.qbox.me';
				$GLOBALS['QINIU_RSF_HOST'] = 'http://rsf.qbox.me';
				
				Qiniu_setKeys(AK_7REE, SK_7REE);
				$delvideo_7ree=str_replace(WL_7REE,'',$v_7ree['url_7ree']);
				$client = new Qiniu_MacHttpClient(null);
				$err = Qiniu_RS_Delete($client, BK_7REE, $delvideo_7ree);
				//echo "====> Qiniu_RS_Delete result: \n";
				if ($err !== null) {
				    var_dump($err);
				    showmessage('x7ree_v:php_lang_err_qiniu2_7ree');
				} else {
				    //echo "Success!";
				}
		}
		
		
		
		showmessage('x7ree_v:php_lang_ok_del_7ree',$admin_url_7ree);
	
}elseif($code_7ree==7){//发表评论
	//录入过滤
	$message_7ree = dhtmlspecialchars(trim($_GET['message_7ree']));
	if(!$message_7ree){
		//showmessage('x7ree_v:php_lang_err_mgs_7ree');
		showmessage('x7ree_v:php_lang_err_mgs_7ree','forum.php?mod=viewthread&tid='.$tid_7ree, array(), array('showdialog' => 1, 'showmsg' => true, 'locationtime' => true));
	}
	

	$ajax_data_7ree['avatar_7ree'] = avatar($_G['uid'], small);
	$ajax_data_7ree['avatar_7ree'] = str_replace('<img','<img class="discussavatar_7ree" ',$ajax_data_7ree['avatar_7ree'] );



	$imagearray_7ree=array();
	$folder_7ree='';
	
	$valuearray_7ree = array(
								'vid_7ree'=>$id_7ree,
								'message_7ree'=>$message_7ree,
								'uid_7ree'=>$_G['uid'],
								'user_7ree'=>$_G['username'],
								'time_7ree'=>$_G['timestamp'],
							);
						
	data_update_7ree('x7ree_v_discuss',$valuearray_7ree,array(),$imagearray_7ree,$folder_7ree);
	$discussnum_7ree=DB::result_first("SELECT COUNT(*) FROM ".DB::table('x7ree_v_discuss')." WHERE vid_7ree='$id_7ree'");
	$updatevalue_7ree=array('discuss_7ree'=>$discussnum_7ree);
	$wherevalue_7ree=array('id_7ree'=>$id_7ree);
	data_update_7ree('x7ree_v_main',$updatevalue_7ree,$wherevalue_7ree,$imagearray_7ree,$folder_7ree);

	//showmessage('x7ree_v:php_lang_ok_discuz_7ree',"plugin.php?id=x7ree_v:x7ree_v&code_7ree=1&id_7ree=".$id_7ree);



	
}elseif($code_7ree==8){//会员付费动作
	$v_7ree = DB::fetch_first("SELECT * FROM ".DB::table('x7ree_v_main')." WHERE id_7ree='$id_7ree'");

	if($v_7ree['cost_7ree']){//积分检测与消耗
		if(extcredit_7ree($vars_7ree['ext_7ree'],$v_7ree['cost_7ree'],$_G['uid'],'','0')){
			//积分受让给发布者
			updatemembercount($v_7ree['uid_7ree'],array($vars_7ree['ext_7ree'] => $v_7ree['cost_7ree']));
			//写入购买日志
			$valuearray_7ree = array(
										'vid_7ree'=>$id_7ree,
										'cost_7ree'=>$v_7ree['cost_7ree'],
										'uid_7ree'=>$_G['uid'],
										'user_7ree'=>$_G['username'],
										'time_7ree'=>$_G['timestamp'],
									);
			
			$imagearray_7ree=array();
			$folder_7ree='';
			
			data_update_7ree('x7ree_v_buylog',$valuearray_7ree,array(),$imagearray_7ree,$folder_7ree);
			showmessage('x7ree_v:php_lang_ok_pay_7ree',"plugin.php?id=x7ree_v:x7ree_v&code_7ree=1&id_7ree=".$id_7ree);
		}else{
			showmessage('x7ree_v:php_lang_err_extcredit_7ree');
		}
	}
	
}elseif($code_7ree==9){//评论管理

	//评论读取
		$page = max(1, intval($_GET['page']));
		$startpage = ( $page - 1 ) * 20;
		$querynum = DB::result_first( "SELECT Count(*) FROM ".DB::table('x7ree_v_discuss'));
		$query = DB::query( "SELECT d.*, v.name_7ree FROM ".DB::table('x7ree_v_discuss')." d
								LEFT JOIN ".DB::table('x7ree_v_main')." v ON d.vid_7ree=v.id_7ree
								ORDER BY d.id_7ree DESC LIMIT {$startpage},20" );
		while ($query_table = DB::fetch($query)){
				$query_table['time_7ree']=dgmdate($query_table['time_7ree'],'u');
				$list_7ree[]=$query_table;
		}
	$multipage = multi($querynum, 20, $page, "plugin.php?id=x7ree_v:x7ree_v&code_7ree=9");


	
}elseif($code_7ree==10){//批量删除评论

		if(count($_GET['mod_7ree'])){
			$mod_7ree = dintval((array)$_GET['mod_7ree'], true);
			DB::query("DELETE FROM ".DB::table('x7ree_v_discuss')." WHERE id_7ree IN(".dimplode($mod_7ree).")");
			showmessage('x7ree_v:php_lang_ok_del_7ree','plugin.php?id=x7ree_v:x7ree_v&code_7ree=9');
		}else{
			showmessage('x7ree_v:php_lang_err_select_7ree','plugin.php?id=x7ree_v:x7ree_v&code_7ree=9');
		}



}else{
	showmessage("Undefined Operation @ 7ree.com");
}

if($code_7ree==7){
	include template('x7ree_v:x7ree_ajax_discuss');
}else{
	include template('x7ree_v:x7ree_v');
}
	
?>