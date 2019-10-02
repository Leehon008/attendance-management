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
           ORDER BY '.$_POST["order"]["0"]["column"].' '.$_POST["order"]["0"]["dir"].'
           ';
       }else {
        $query .='
        ORDER BY tbl_students.student_id DESC
        ';
       }//end ordering post

       if ($_POST["length"] != -1) {
           $query .='
           LIMIT '.$_POST["start"].', '.$_POST["length"];
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

if ($_POST["action"] == "Add" || $_POST["action"]== "Edit" ) {
    $student_name='';
    $student_roll_number='';
    $student_dob='';
    $student_grade_id ='';
    
    $error_student_name='';
    $error_student_roll_number='';
    $error_student_dob='';
    $error_student_grade_id ='';
    $error = 0;

    if (empty($_POST["student_name"])) {
        $error_student_name = 'Student Name is Required';
      $error++;
    } else {
        $student_name = $_POST["student_name"];
    }    //end student name

    if (empty($_POST["student_roll_number"])) {
        $error_student_roll_number = 'Student Roll Number is Required';
        $error++;
    } else {
        $student_roll_number = $_POST["student_roll_number"];
    } //end student_roll_number

    if (empty($_POST["student_dob"])) {
        $error_student_dob = 'student dob is Required';
        $error++;
    } else {
        $student_dob = $_POST["student_dob"];
    }//end student_dob

    if (empty($_POST["student_grade_id"])) {
        $error_student_grade_id = 'Student grade Field is Required';
        $error++;
    } else {
        $student_grade_id = $_POST["student_grade_id"];
    }//end student_grade_id

    if ($error > 0) {
        $output = array(
            'error' => true,
            'error_student_name'=> $error_student_name,
            'error_student_roll_number'=> $error_student_roll_number,
            'error_student_dob'=> $error_student_dob,
            'error_student_grade_id'=> $error_student_grade_id,
        );
    } else {
        
        if ($_POST["action"] == "Add") {
            $data = array(
                ':student_name' => $student_name, 
                ':student_roll_number' => $student_roll_number,
                ':student_dob' => $student_dob,
                ':student_grade_id' => $student_grade_id
            );
            $query = "
            INSERT INTO tbl_students
                (student_name,student_roll_number,student_dob,student_grade_id)
            SELECT * FROM (SELECT :student_name,:student_roll_number,:student_dob,:student_grade_id) as temp
            WHERE NOT EXISTS (
                SELECT student_roll_number FROM 
                tbl_students WHERE student_roll_number = :student_roll_number
            ) LIMIT 1
            ";
            $statement = $connect->prepare($query);
            if ($statement->execute($data)) {
                if ($statement->rowCount() > 0) {
                    $output = array(
                        'success' => 'Data Added Successfully'
                    ) ; 
                } else {
                    $output = array(
                        'error' => true, 
                        'error_student_roll_number' => 'Student Roll Number Exists'
                    );
                }//end  of row count
            }//end of add
            
            if ($_POST["action"] == 'Edit') {
                $data = array(
                    ':student_name' => $student_name, 
                    ':student_roll_number' => $student_roll_number,
                    ':student_dob' => $student_dob,
                    ':student_grade_id' => $student_grade_id,
                    ':student_id' => $_POST["student_id"]
                )  ;
                $query = "UPDATE tbl_students 
                SET  student_name = :student_name,
                student_roll_number = :student_roll_number,
                student_dob = :student_dob,
                student_grade_id = :student_grade_id
                WHERE student_id = :student_id
                ";
                $statement=$connect->prepare($query);
                if ($statement->execute($data)) {
                    $output = array(
                        'success' => 'Data Edited Successfully'
                    );
                }
            }//end edit 
        }//end post=add
    #    echo json_encode($output);
    }//end error check

    echo json_encode($output);
} //end of post isset action

if ($_POST["action"]== "single_fetch") {
    $query = "
     SELECT * FROM tbl_students
     INNER JOIN tbl_grade
     ON tbl_grade.grade_id = tbl_students.student_grade_id
     WHERE tbl_students.student_id = '".$_POST["student_id"]."'
    ";
    $statement =$connect->prepare($query);
    if ($statement->execute()) {
        $result = $statement->fetchAll();
        $output = '
        <div class="row">
        ';
        foreach ($result as $row) {
        $output .='
        <div class="col-md-9">
            <table class="table">
                <tr>
                 <th> Student Name</th>
                 <td>'.$row["student_name"].'</td>
                </tr>
                <tr>
                 <th>Roll Number</th>
                 <td>'.$row["student_roll_number"].'</td>
                </tr>
                
                <tr>
                 <th>Date Of Birth</th>
                 <td>'.$row["student_dob"].'</td>
                </tr>
                <tr>
                 <th>Grade</th>
                 <td>'.$row["grade_name"].'</td>
                </tr>
            </table>
        </div>
        ';
        }//end foreach
        $output .= '</div>';
        echo $output;
    }//end statement execute
}//end single fetch

if ($_POST["action"]=="edit_fetch") {
    $query ="
    SELECT * FROM tbl_students WHERE student_id ='".$_POST["student_id"]."'
    ";
    $statement=$connect->prepare($query);
    if ($statement->execute()) {
        $result =$statement->fetchAll();
        foreach ($result as $row) {
            $output["student_name"]=$row["student_name"];
            $output["student_roll_number"]=$row["student_roll_number"];
            $output["student_dob"]=$row["student_dob"];
            $output["student_grade_id"]=$row["student_grade_id"];
            $output["student_id"]=$row["student_id"];

        }//foreach
        echo json_encode($output);
    }//end statement execute
}//end edit fetch

if ($_POST["action"] == "delete") {
   $query = "
   DELETE FROM tbl_students
   WHERE student_id = '".$_POST["student_id"]."'
   ";
   $statement=$connect->prepare($query);
   if ($statement->execute()) {
       echo 'Data Deleted Successfully';
   }
}//end delete action

}//end isset action

