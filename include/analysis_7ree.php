<?php
/*
 * [www.7ree.com] (C)2006-2021 7ree.com.
 * This is NOT a freeware, use is subject to license terms
 * Agreement: https://addon.dismall.com/?@7.developer.doc/agreement_7ree_html
 * More Plugins: https://addon.dismall.com/developer-7.html
 * EMail: service@7ree.com
 * QQ: 860618629
 * WeiXin: www_7ree_com
 * Update: 2022-01-04 19:46:59
*/


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function fenlei_id_7ree($fenlei_array,$fenlei_name_7ree){
	global $_G;
	$return_7ree = 0;
	foreach($fenlei_array as $key_7ree=>$fenlei_value){
		if($fenlei_value==$fenlei_name_7ree){
			$return_7ree = $key_7ree;
			break;
		}
	}
	return $return_7ree+1 ;
}

function analysis_7ree($url_7ree,$height_7ree){
		global $_G;
		$return_7ree = '';
		$vars_7ree = $_G['cache']['plugin']['x7ree_v'];
		$from_7ree =  str_replace("\n","|||",$vars_7ree['from_7ree']);
		$from_array =  explode('|||', $from_7ree);
		
		foreach($from_array as $from_value){
				$from_array2 = explode(':',trim($from_value));
				$from_add_7ree[$from_array2[0]]=$from_array2[1];
		}

		$iframe_onoff=0;
		$vars_7ree['iframe_7ree'] =  str_replace("\n","|||",$vars_7ree['iframe_7ree']);
		$iframe_7ree = explode('|||',trim($vars_7ree['iframe_7ree']));
		$iframe_value ='';
		foreach($iframe_7ree as $iframe_value){
			if(strstr($url_7ree,trim($iframe_value))){
				$iframe_onoff=1;
				break;
			}
		}
		
		$api_onoff=0;
		$vars_7ree['url_api_7ree'] =  str_replace("\n","|||",$vars_7ree['url_api_7ree']);
		$url_api_7ree = explode('|||',trim($vars_7ree['url_api_7ree']));
		$url_api_value ='';
		foreach($url_api_7ree as $url_api_value){
			if(strstr($url_7ree,trim($url_api_value))){
				$api_onoff=1;
				break;
			}
		}
		if($api_onoff && $vars_7ree['analysis_api_7ree']){
			$url_7ree = $vars_7ree['analysis_api_7ree'].$url_7ree;
			$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$url_7ree."' frameborder=0 'allowfullscreen'></iframe>";
			return $return_7ree;
		}


		if($iframe_onoff){
				if(!$url_7ree) showmessage('x7ree_v:php_lang_err_badurl_7ree');
				
				$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$url_7ree."' frameborder=0 'allowfullscreen'></iframe>";

		}elseif(stristr($url_7ree,'.mp4') || stristr($url_7ree,'.webm')){

		if($vars_7ree['mp4player_7ree']==1){
			//$return_7ree="<video height='".$height_7ree."' width='100%' controls autobuffer webkit-playsinline='true' playsinline='true'><source src='".$url_7ree."' type='video/mp4' />Your browser does not support the video tag.</video>";
			$return_7ree="<video height='".$height_7ree."' width='100%' controls autobuffer webkit-playsinline playsinline x5-playsinline  x-webkit-airplay='allow'><source src='".$url_7ree."' type='video/mp4' />Your browser does not support the video tag.</video>";
		}elseif($vars_7ree['mp4player_7ree']==2){
			$return_7ree=<<<EOF
				<div id="a1"></div>
				<script type="text/javascript" src="./source/plugin/x7ree_v/template/ckplayer/ckplayer.js" charset="utf-8"></script>
				<script type="text/javascript">
					var flashvars={
					    f:'$url_7ree',
					    c:0
					};
					var video=['$url_7ree'];
					CKobject.embed('./source/plugin/x7ree_v/template/ckplayer/ckplayer.swf','a1','ckplayer_a1','100%','$height_7ree',false,flashvars,video);
				</script>
EOF;
		}

		}elseif(strstr($url_7ree,'youku.com')){
			

				if(stristr($url_7ree,'/embed/')){
					$return_7ree = str_replace("http://","https://",$url_7ree);
					if($from_add_7ree['youku.com']){
							$return_7ree = $return_7ree . $from_add_7ree['youku.com'];
							
					}
				$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$return_7ree."' frameborder=0 'allowfullscreen'></iframe>";
				}else{
					//str_replace("==","",$url_7ree);
					preg_match("#id_(.*?).html#",$url_7ree,$url_7ree);
					

					
					if(!$url_7ree[1]) showmessage('x7ree_v:php_lang_err_badurl_7ree');
					$return_7ree = 'https://player.youku.com/embed/'.$url_7ree[1].'==';
					
					$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$return_7ree."' frameborder=0 allowfullscreen='true'></iframe>";
					
/*
					$return_7ree=<<<EOF
					<div id="youkuplayer_{$url_7ree[1]}" style="width:100%;height:$height_7ree"></div>
					<script type="text/javascript" src="//player.youku.com/jsapi"></script>
					<script type="text/javascript">
					var player = new YKU.Player('youkuplayer_{$url_7ree[1]}',{
					styleid: '0',
					client_id: 'YOUR YOUKUOPENAPI CLIENT_ID',
					vid: '$url_7ree[1]',
					newPlayer: true
					});
					</script>
EOF;
*/			
					
				}

		}elseif(strstr($url_7ree,'qiyi.com')){
				if(!$url_7ree) showmessage('x7ree_v:php_lang_err_badurl_7ree');
				$return_7ree = $url_7ree;
				if($from_add_7ree['iqiyi.com']){
					$return_7ree = $return_7ree . $from_add_7ree['iqiyi.com'];
				}
				$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$return_7ree."' frameborder=0 'allowfullscreen'></iframe>";

		}elseif(strstr($url_7ree,'bilibili.com')){
				if(!$url_7ree) showmessage('x7ree_v:php_lang_err_badurl_7ree');
				$return_7ree = $url_7ree;
				// if($from_add_7ree['bilibili.com']){
				// 	$return_7ree = $return_7ree . $from_add_7ree['bilibili.com'];
				// }
				// $return_7ree = "<iframe src='".$return_7ree."' scrolling='no' border='0' frameborder='no' framespacing='0' allowfullscreen='true' height='".$height_7ree."' width='100%' > </iframe>";
				if(preg_match("/https?:\/\/(m.|www.|)bilibili.(com|tv)\/video\/(a|b)v([A-Za-z0-9]+)(\/?.*?&p=|\/?\?p=)?(\d+)?/i", $url_7ree, $matches)) {
					$vid = (is_numeric($matches[4]) ? 'aid='.$matches[4] : 'bvid='.$matches[4]) . (empty($matches[6]) ? '' : '&page='.intval($matches[6]));
					$iframe_7ree = 'https://player.bilibili.com/player.html?'.$vid;
				} else if(preg_match("/https?:\/\/(www.|)(acg|b23).tv\/(a|b)v([A-Za-z0-9]+)(\/?.*?&p=|\/?\?p=)?(\d+)?/i", $url_7ree, $matches)) {
					$vid = (is_numeric($matches[4]) ? 'aid='.$matches[4] : 'bvid='.$matches[4]) . (empty($matches[6]) ? '' : '&page='.intval($matches[6]));
					$iframe_7ree = 'https://player.bilibili.com/player.html?'.$vid;
				}
				//$return_7ree = $iframe_7ree;
				$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$iframe_7ree."' frameborder=0 'allowfullscreen'></iframe>";

			}elseif(strstr($url_7ree,'acfun.cn')){
				if(!$url_7ree) showmessage('x7ree_v:php_lang_err_badurl_7ree');
				$return_7ree = str_replace("/v/ac","/player/ac",$url_7ree);
				if($from_add_7ree['acfun.cn']){
					$return_7ree = $return_7ree . $from_add_7ree['acfun.cn'];
				}
				$return_7ree = "<iframe src='".$return_7ree."' scrolling='no' border='0' frameborder='no' framespacing='0' allowfullscreen='true' height='".$height_7ree."' width='100%' > </iframe>";

		}elseif(strstr($url_7ree,'qq.com')){
				if(strstr($url_7ree,'?')){
					$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$url_7ree."' frameborder=0 'allowfullscreen'></iframe>";
				}else{
					if(preg_match("/https?:\/\/v.qq.com\/x\/page\/([^\/]+)(.html|)/i", $url_7ree, $matches)) {
						$vid = explode(".html", $matches[1]);
						$iframe_7ree = 'https://v.qq.com/txp/iframe/player.html?vid='.$vid[0];
					} else if(preg_match("/https?:\/\/v.qq.com\/x\/cover\/([^\/]+)\/([^\/]+)(.html|)/i", $url_7ree, $matches)) {
						$vid = explode(".html", $matches[2]);
						$iframe_7ree = 'https://v.qq.com/txp/iframe/player.html?vid='.$vid[0];
					}

					$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$iframe_7ree."' frameborder=0 'allowfullscreen'></iframe>";
				}


		}elseif(strstr($url_7ree,'sohu.com')){
				if(!$url_7ree) showmessage('x7ree_v:php_lang_err_badurl_7ree');
				$return_7ree = $url_7ree;
				$return_7ree = $url_7ree;
				if($from_add_7ree['sohu.com']){
					$return_7ree = $return_7ree . $from_add_7ree['sohu.com'];
				}
				$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$return_7ree."' frameborder=0 'allowfullscreen'></iframe>";

		}elseif(strstr($url_7ree,'ifeng.com')){
				if(!$url_7ree) showmessage('x7ree_v:php_lang_err_badurl_7ree');
				$return_7ree = $url_7ree;
				$return_7ree = $url_7ree;
				if($from_add_7ree['ifeng.com']){
					$return_7ree = $return_7ree . $from_add_7ree['ifeng.com'];
				}
				$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$return_7ree."' frameborder=0 'allowfullscreen'></iframe>";

		}elseif(strstr($url_7ree,'56.com')){
				if(!$url_7ree) showmessage('x7ree_v:php_lang_err_badurl_7ree');
				$return_7ree = $url_7ree;
				$return_7ree = $url_7ree;
				if($from_add_7ree['56.com']){
					$return_7ree = $return_7ree . $from_add_7ree['56.com'];
				}
				$return_7ree = "<iframe height='".$height_7ree."' width='100%' src='".$return_7ree."' frameborder=0 'allowfullscreen'></iframe>";

		}elseif(strstr($url_7ree,'music.163.com')){
			
			$patterns = "/id=\d+/";
			preg_match($patterns,$url_7ree,$idstr_7ree); 

			$return_7ree = "<iframe frameborder='no' border='0' marginwidth='0' marginheight='0' width=320 height=86 src='//music.163.com/outchain/player?type=2&".$idstr_7ree[0]."&auto=1&height=66'></iframe>";
		}else{
				$return_7ree = lang('plugin/x7ree_v','php_lang_err_badurl_7ree');
				//showmessage('x7ree_v:php_lang_err_badurl3_7ree');
		}
		return $return_7ree;

}

?>