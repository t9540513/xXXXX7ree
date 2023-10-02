<?php
/*
 * [www.7ree.com] (C)2006-2021 7ree.com.
 * This is NOT a freeware, use is subject to license terms
 * Agreement: https://addon.dismall.com/?@7.developer.doc/agreement_7ree_html
 * More Plugins: https://addon.dismall.com/developer-7.html
 * EMail: service@7ree.com
 * QQ: 860618629
 * WeiXin: www_7ree_com
 * Update: 2021-12-13 23:17:47
*/



if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class mobileplugin_x7ree_v {	

	function discuzcode($param) {
		global $_G;
		loadcache('plugin');
		$vars_7ree = $_G['cache']['plugin']['x7ree_v'];
		$return='';
		
		if(!$vars_7ree['agreement_7ree']){
			return $return;
		}
	
		$_G['discuzcodemessage'] = $this->analysis_7ree($_G['discuzcodemessage']);

		return $return;

	}


	function view_article_content_output(){
		global $_G,$content;
		loadcache('plugin');
		$vars_7ree = $_G['cache']['plugin']['x7ree_v'];
		$return='';
		
		if(!$vars_7ree['agreement_7ree']){
			return $return;
		}
		
		$content['content'] = $this->analysis_7ree($content['content']);


	}


	function analysis_7ree($msg_analysis_7ree){
		global $_G;
		loadcache('plugin');
		$vars_7ree = $_G['cache']['plugin']['x7ree_v'];
		if($vars_7ree['media_7ree']){
			$msg_analysis_7ree = preg_replace("/\[media=([\w,]+)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is", "[x7ree_v]\\2[/x7ree_v]", $msg_analysis_7ree);
		}
		
		if(strstr($msg_analysis_7ree,'[/x7ree_v]')){

			$height_7ree=$vars_7ree['pcplayer_h_7ree'] ? $vars_7ree['pcplayer_h_7ree'].'px' : '400px';
			preg_match('/\[x7ree_v\]\s*(.*?)\s*\[\/x7ree_v\]/i',$msg_analysis_7ree,$match);

			//ÊÓÆµµØÖ·½âÎö
			require_once DISCUZ_ROOT.'./source/plugin/x7ree_v/include/analysis_7ree.php';
			$showplay_7ree=analysis_7ree($match[1],$height_7ree);

			$prestr_7ree='';	
			$msg_analysis_7ree = preg_replace("/\[x7ree_v\]\s*(.*?)\s*\[\/x7ree_v\]/is",$prestr_7ree."<div class='vplayer_7ree'>".$showplay_7ree."</div>",$msg_analysis_7ree);
			
		}

		return $msg_analysis_7ree;
	}



}


class mobileplugin_x7ree_v_forum extends mobileplugin_x7ree_v {
}
class mobileplugin_x7ree_v_portal extends mobileplugin_x7ree_v {
}

?>