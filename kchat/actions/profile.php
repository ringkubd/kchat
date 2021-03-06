<?php

/**
* KChat -
* Author Ganesh Kandu
* Contact kanduganesh@gmail.com 
*/

class profile extends action{
	function action(){
		if($this->data['user']['uname'] != $_POST['uname']){
			return false;
		}
		$arr = array(
			'profile' => array(
				'fname' => $_POST['fname'],
				'lname' => $_POST['lname'],
				'uname' => $this->data['user']['uname'],
				'password' => $_POST['password']
			)
		);
		
		if($_POST['password'] !== $_POST['repassword']){
			echo "Password Doesn't match";
		}
		
		$stmt = $this->data['pdo']->prepare("SELECT * FROM {$this->dbprefix}users where uname =:uname;");
		$stmt->execute(array('uname' => $this->data['user']['uname']));
		$row = $stmt->fetch();
		if(empty($arr['profile']['password'])){
			$arr['profile']['password'] = $row['password'];
		}
		if(isset($row['uname'])){
			$sql = "UPDATE {$this->dbprefix}users SET fname = :fname,lname = :lname,password = :password WHERE uname = :uname;";
			$stmt = $this->data['pdo']->prepare($sql);
			$stmt->execute($arr['profile']);
			session::setSession($this->data,$row);
		}else{
			echo "There is no such user";
		}
	}
}