<?php 
include 'includes/dbConnection.php';
session_start();
if (isset($_POST["action"])) {
    if ($_POST["action"]=="fetch") {
       $query = "
       SELECT * FROM tbl_students INNER JOIN tbl_grade
       ON tbl_grade.grade_id = tbl_students.student_grade_id
       ";

     if (isset($_POST["search"]["value"])) {
         $query .='
          WHERE tbl_students.student_name LIKE "%'.$_POST["search"]["value"].'%"
           OR tbl_students.student_roll_number LIKE "%'.$_POST["search"]["value"].'%"
           OR tbl_students.student_dob LIKE "%'.$_POST["search"]["value"].'%"
           ';
       }//end post searching

       if (isset($_POST["order"])) {
           $query .='
           ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'
           ';
       }else {
        $query .='
        ORDER BY tbl_students.student_id DESC
        ';
       }//end ordering post

       if ($_POST["length"] != -1) {
           $query .='
           LIMIT '.$_POST['start'].', '.$_POST['length'];
       }//end length check

       $statement = $connect->prepare($query);
       $statement->execute();
       $result = $statement ->fetchAll();
       $filtered_rows = $statement->rowCount();
       $data = array();
       foreach ($result as $row){
        $sub_array = array();
       $sub_array[] = $row["student_name"];
       $sub_array[] = $row["student_roll_number"];
       $sub_array[] = $row["student_dob"];
       $sub_array[] = $row["grade_name"];
       $sub_array[] = '<button type="button" name="view_student" 
       class="btn btn-info btn-sm view_student" id="'.$row["student_id"].'">View</button>';
       $sub_array[] = '<button type="button" name="edit_student" 
       class="btn btn-info btn-sm edit_student" id="'.$row["student_id"].'">Edit</button>';
       $sub_array[] = '<button type="button" name="delete_student" 
       class="btn btn-info btn-sm delete_student" id="'.$row["student_id"].'">Delete</button>';
       $data[] = $sub_array;
       }//end foreach
      $output = array(
        "draw" => intval($_POST["draw"]),
         "recordsTotal" => $filtered_rows,
        "recordsFiltered" => get_total_records($connect, 'tbl_students'),
      "data" => $data
   ); 
   echo json_encode($output);

    }//end action fetch
}//end isset action