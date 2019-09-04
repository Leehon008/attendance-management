<?php
// Create Object of PDO class by connecting to Mysql database;
	
	$teachers = [];
	
	$sql = 'SELECT * FROM tbl_teacher ORDER BY teacher_id DESC';
	foreach( $database->query( $sql ) as $teacher ) {
		$teachers[] = array(
			'teacher_name'	=> $teacher['teacher_name'],
			'teacher_id'	=> $teacher['teacher_id'],
			'teacher_email'	=> $teacher['teacher_email']
		);
	}
	
	echo json_encode( $teachers );
	 
