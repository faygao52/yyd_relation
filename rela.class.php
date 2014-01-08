<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_yyd_relation {

}
class plugin_yyd_relation_forum extends plugin_yyd_relation {
	function viewthread_sidetop_output() {
		global $postlist,$_G;

		$relaview = array();
		$pids=array_keys($postlist);
		foreach($postlist as $pid=>$pinfo){
			$authorids[]=$pinfo['authorid'];
			$layout = '<style>
.qdsmile {padding:3px; margin-left:7px; margin-right:7px; list-style:none;}
.qdsmile li{padding:5px .4em;background:#F7FAFF;border:2px dashed #D1D8D8;}
.qdsmile li img{margin-bottom:5px;}
</style>
<div class="qdsmile" id ="rela'.$pinfo['pid'].'"onmouseover="showMenu({\'ctrlid\':this.id, \'pos\':\'12!\'});"><li><center>TA的关系
</center></li></div><div id="rela'.$pinfo['pid'].'_menu" class="tip tip_4" style="width:140px;display: none;"><div class="tip_horn"></div><div class="tip_c"><table width="120px">';
			foreach (C::t('#yyd_relation#yyd_relation')->fetch_all_by_uid($pinfo['authorid']) as $user){
				$layout .= '<tr><td width="50%">'.$user['reladata'].'</td><td>'.$user['username'].'</td></tr>';
			}
			$layout .= '</table></div></div>';
			$relaview[] =$layout;
			$layout = '';
		}
		
		return $relaview;
	}
}
?>
