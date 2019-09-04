<?php
include '../includes/Database.php';
include '../includes/dbConnection.php';
$db = new Database();
$pass=password_hash("pass",PASSWORD_DEFAULT);
$user="Lee";

$query = "INSERT INTO tbl_admin(admin_id,admin_user_name,admin_password)
 VALUES (0,'$user','$pass')";

$statement =$connect->prepare($query);
if ($statement->execute()){
    echo '<script>alert("Added successfully")</script>';
    header('location:teacher.php?msg='.urlencode("Record added successfully"));
}
