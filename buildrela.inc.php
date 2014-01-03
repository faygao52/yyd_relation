<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(!$_G['uid']) {
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}

$relationusergroups = (array)unserialize($_G['cache']['plugin']['yyd_relation']['groups']);
if(in_array('', $relationusergroups)) {
	$relationusergroups = array();
}
$singleprem = FALSE;
$readyuser = $permusers = $permuids = array();
if(!in_array($_G['groupid'], $relationusergroups)) {
	$singleprem = TRUE;
}

foreach(C::t('#yyd_relation#yyd_relation')->fetch_all_by_username($_G['username']) as $user) {
	$permuids[] = $user['uid'];
}
$permusers = C::t('common_member')->fetch_all_username_by_uid($permuids);
foreach($permusers as $uname){
if(!C::t('#yyd_relation#yyd_relation')->count_by_uid_username($_G['uid'],$uname)){
		$readyuser[] = $uname;
}		
}
if($singleprem) {
	showmessage('yyd_relation:usergroup_disabled');
}

if($_GET['pluginop'] == 'add' && submitcheck('buildrelation')) {
	if($singleprem && in_array($_GET['usernamenew'], $permusers) || !$singleprem) {
		$usernamenew = addslashes(strip_tags($_GET['usernamenew']));
		$reladata = addslashes(strip_tags($_GET['appellationnew']));
		if(C::t('#yyd_relation#yyd_relation')->count_by_uid_username($_G['uid'], $usernamenew)) {
			DB::query("UPDATE ".DB::table('yyd_relation')." SET reladata='$reladata' WHERE uid='$_G[uid]' AND username='$usernamenew'");
		} else {
			$_GET['commentnew'] = addslashes($_GET['commentnew']);
			DB::query("INSERT INTO ".DB::table('yyd_relation')." (uid, username, reladata) VALUES ('$_G[uid]', '$usernamenew', '$reladata')");
		}
		dsetcookie('mrn', '');
		dsetcookie('mrd', '');
		showmessage('yyd_relation:adduser_succeed', 'home.php?mod=spacecp&ac=plugin&id=yyd_relation:buildrela', array('usernamenew' => stripslashes($usernamenew)));
	}
} elseif($_GET['pluginop'] == 'delete' && submitcheck('delete')) {
	if(!empty($_GET['deleteuser'])) {
		C::t('#yyd_relation#yyd_relation')->delete_by_uid_usernames($_G['uid'], $_GET['deleteuser']);
	}
	dsetcookie('mrn', '');
	dsetcookie('mrd', '');
	showmessage('yyd_relation:deleteuser_succeed', 'home.php?mod=spacecp&ac=plugin&id=yyd_relation:buildrela');
} elseif($_GET['pluginop'] == 'update' && submitcheck('connect')) {
	if(!empty($_GET['updates'])) {
		$_GET['appellation'] = daddslashes($_GET['appellation']);
		foreach($_GET['appellation'] as $user => $v) {
			DB::query("INSERT INTO ".DB::table('yyd_relation')." (uid, username, reladata) VALUES ('$_G[uid]', '$user', '".strip_tags($v)."')");

		}
	}
	dsetcookie('mrn', '');
	dsetcookie('mrd', '');
	showmessage('yyd_relation:updateuser_succeed', 'home.php?mod=spacecp&ac=plugin&id=yyd_relation:buildrela');
}

$username = empty($_GET['username']) ? '' : htmlspecialchars($_GET['username']);

$relationusers = array();
foreach(C::t('#yyd_relation#yyd_relation')->fetch_all_by_uid($_G['uid']) as $myrepeat) {
	$myrepeat['connect'] = true;
	$connetuid = C::t('common_member')->fetch_uid_by_username($myrepeat['username']);
	$connetion = C::t('#yyd_relation#yyd_relation')->count_by_uid_username($connetuid,$_G['username']);
	if($connetion == 0)	{
		$myrepeat['connect'] = false;
	}
	$relationusers[] = $myrepeat;
}

$_G['basescript'] = 'home';


?>
