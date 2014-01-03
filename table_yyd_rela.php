<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_yyd_relation extends discuz_table
{
	public function __construct() {

		$this->_table = 'yyd_relation';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_all_by_uid($uid) {
		return DB::fetch_all("SELECT * FROM %t WHERE uid=%d", array($this->_table, $uid));
	}

	public function fetch_all_by_username($username) {
		return DB::fetch_all("SELECT * FROM %t WHERE username=%s", array($this->_table, $username));
	}

	public function fetch_all_by_uid_username($uid, $username) {
		return DB::fetch_all("SELECT * FROM %t WHERE uid=%d AND username=%s", array($this->_table, $uid, $username));
	}

	public function count_by_uid_username($uid, $username) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE uid=%d AND username=%s", array($this->_table, $uid, $username));
	}

	public function delete_by_uid_usernames($uid, $usernames) {
		DB::query("DELETE FROM %t WHERE uid=%d AND username IN (%n)", array($this->_table, $uid, $usernames));
	}

	public function update_reladata_by_uid_username($uid, $username, $value) {
		DB::query("UPDATE %t SET reladata=%s WHERE uid=%d AND username=%s", array($this->_table, $value, $uid, $username));
	}


	public function count_by_search($condition) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE 1 %i", array($this->_table, $condition));
	}

	public function fetch_all_by_search($condition, $start, $ppp) {
		return DB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY uid LIMIT %d, %d", array($this->_table, $condition, $start, $ppp));
	}

}

?>
