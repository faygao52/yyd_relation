<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS cdb_yyd_relation;
CREATE TABLE cdb_yyd_relation (
  `uid` mediumint(8) unsigned NOT NULL,
  `username` varchar(15) NOT NULL DEFAULT '',
  `reladata` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`,`username`),
  KEY `username` (`username`)
) TYPE=MyISAM;

EOF;

runquery($sql);

$finish = TRUE;

?>
