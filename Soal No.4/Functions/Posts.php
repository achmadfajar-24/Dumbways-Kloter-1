<?php

include('Queries/Connection.php');

class Posts extends Connection
{
	
	public function index(){
		$posts = $this->dbconn->prepare('SELECT * from school_tb');
		$posts->execute();
		$data = $posts->fetchAll();
		return $data;
	}

	public function create($npsn, $name_school, $address, $logo_school = [], $level, $status, $user_id){
		$file_name = $logo_school['name'];
		$directory = $logo_school['tmp_name'];

		$target_file = "Functions/Images/". basename($file_name);

		

		$create = $this->dbconn->prepare('INSERT INTO school_tb (npsn, name_school, address, logo_school, school_level, status_school, user_id) VALUES (?,?,?,?,?,?,?)');

		$create->bindParam(1, $npsn);
		$create->bindParam(2, $name_school);
		$create->bindParam(3, $address);
		if(move_uploaded_file($directory, $target_file)){
			$create->bindParam(4, $file_name);
		}
		$create->bindParam(5, $level);
		$create->bindParam(6, $status);
		$create->bindParam(7, $user_id);

		$create->execute();
		return $create->rowCount();
	}

	public function show($id){
		$sql = 'SELECT school_tb.*, user.name, user.email FROM  school_tb JOIN user ON school_tb.user_id = user.id';
		$show = $this->dbconn->prepare($sql);
		$show->bindParam(1, $id);
		$show->execute();
		return $show->fetch();
	}

	public function edit($id){
		$edit = $this->dbconn->prepare('SELECT * from school_tb where id=?');
		$edit->bindParam(1, $id);
		$edit->execute();
		return $edit->fetch();
	}

	public function update($npsn, $name_school, $address, $logo_school = [], $level, $status){
		$file_name = $logo_school['name'];
		$directory = $logo_school['tmp_name'];

		$target_file = "Functions/Images/". basename($file_name);
		$update = $this->dbconn->prepare('UPDATE school_tb set npsn=?, name_school=?, address=?, logo_school=?, school_level=?, status_school=? where id=?');

		$update->bindParam(1, $npsn);
		$update->bindParam(2, $name_school);
		$update->bindParam(3, $address);
		if(move_uploaded_file($directory, $target_file)){
			$create->bindParam(4, $file_name);
		}
		$update->bindParam(5, $level);
		$update->bindParam(6, $status);

		$update->execute();
		return $update->rowCount();
	}

	public function delete($id){
		$delete = $this->dbconn->prepare('DELETE from school_tb where id=?');

		$delete->bindParam(1, $id);

		$delete->execute();
		return $delete->rowCount();
	}
}

?>