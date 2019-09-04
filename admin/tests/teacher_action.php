<?php
include 'includes/dbConnection.php';
session_start();
if (isset($_POST["action"])){
    if ($_POST["action"] == 'fetch'){
       $query = "SELECT * FROM tbl_teacher INNER JOIN tbl_grade 
                ON tbl_grade.grade_id = tbl_teacher.teacher_grade_id ";
       if (isset($_POST["search"]["value"])){
           $query .= 'WHERE tbl_teacher.teacher_name LIKE "%'.$_POST["search"]["value"].'%"
           OR tbl_teacher.teacher_emailid LIKE "%'.$_POST["search"]["value"].'%"
           OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%"
           ';
       }
       if (isset($_POST["order"])){
           $query .= 'ORDER BY '.$_POST['order']['0']['column'].''.$_POST['order']['0']['dir'].'';
       }
       else {
           $query .= 'ORDER BY tbl_teacher.teacher_id DESC';
       }
       if ($_POST["length"] != -1){
           $query .= 'LIMIT '.$_POST['start'].','.$_POST['length'];
        }
       $statement = $connect ->prepare($query);
       $statement->execute();
       $result = $statement ->fetchAll();
       $data = array();
       $filtered_rows = $statement->rowCount();
       foreach ($result as $row){
           $sub_array = array();
           $sub_array[] = '<img src="teacher_image/'.$row["teacher_image"].'" 
           class="img-thumbnail" width="75" />';
           $sub_array["teacher_name"] = $row["teacher_name"];
           $sub_array["teacher_emailid"] = $row["teacher_emailid"];
           $sub_array["grade_name"] = $row["grade_name"];
           $sub_array["teacher_id"] = '<button type="button" name="view_teacher" 
           class="btn btn-info btn-sm view_teacher" id="'.$row["teacher_id"].'">View</button>';
           $sub_array["teacher_id"] = '<button type="button" name="edit_teacher" 
           class="btn btn-info btn-sm edit_teacher" id="'.$row["teacher_id"].'">Edit</button>';
           $sub_array["teacher_id"] = '<button type="button" name="delete_teacher" 
           class="btn btn-info btn-sm delete_teacher" id="'.$row["teacher_id"].'">Delete</button>';
           $data[] = $sub_array;
           }
       $output = array(
           "draw" => intval($_POST["draw"]),
           "recordsTotal" => $filtered_rows,
           "recordsFiltered" => get_total_records($connect, 'tbl_teacher'),
           "data" => $data
       ); 
    }
    
    //for the add, edit and delete
    if ($_POST["action"] == "Add" || $_POST["action"]== "Edit") {
        $teacher_name='';
        $teacher_address='';
        $teacher_emailid='';
        $teacher_password='';
        $teacher_grade_id='';
        $teacher_qualification='';
        $teacher_doj='';
        $teacher_image='';
        $error_teacher_name='';
        $error_teacher_address='';
        $error_teacher_emailid='';
        $error_teacher_password='';
        $error_teacher_grade_id='';
        $error_teacher_qualification='';
        $error_teacher_doj='';
        $error_teacher_image='';
        $error = 0;

        $teacher_image = $_POST["hidden_teacher_image"];
        if ($_FILES["teacher_image"]["name"] != '') {
            $file_name = $_FILES["teacher_image"]["name"];
            $tmp_name = $_FILES["teacher_image"]["tmp_name"]; 
            $extension_array = explode(".",$file_name);
            $extension = strtolower($extension_array[1]);
            $allowed_extension=array('jpg','png');
            if (!in_array($extension,$allowed_extension)) {
                $error_teacher_image = 'Invalid Image Format';
                $error++;
            } else {
                $teacher_image = uniqid().'.'.$extension;
                $upload_path = 'teacher_image/'.$teacher_image;
                move_uploaded_file($tmp_name,$upload_path);
            }
            
        } else {
         //   if ($teacher_image != '') {
                $error_teacher_image = 'Image is required!!' ;
                $error++;
          //   }
        }
        if (empty($_POST["teacher_name"])) {
            $error_teacher_name = 'Teacher Name is Required';
          $error++;
        } else {
            $teacher_name = $_POST["teacher_name"];
        }
        //end teacher name
        if (empty($_POST["teacher_address"])) {
            $error_teacher_address = 'Teacher Address is Required';
            $error++;
        } else {
            $teacher_address = $_POST["teacher_address"];
        } //end address

        if ($_POST["action"] == "Add") {
            if (empty($_POST["teacher_emailid"])) {
                $error_teacher_emailid = 'Teacher Email is Required';
                $error++;
            } else {
                if (!filter_var($_POST["teacher_emailid"], FILTER_VALIDATE_EMAIL)) {
                    $error_teacher_emailid = 'Invalid email format';
                    $error++;
                }else {            
                $teacher_emailid = $_POST["teacher_emailid"];
                }
            } //end email
            if (empty($_POST["teacher_password"])) {
                $error_teacher_password = 'Teacher Password is Required';
                $error++;
            } else {
                $teacher_password = $_POST["teacher_password"];
            }//end password
            
        } //end email and pass validation 
        if (empty($_POST["teacher_grade_id"])) {
            $error_teacher_grade_id = 'Grade is Required';
            $error++;
        } else {
            $teacher_grade_id = $_POST["teacher_grade_id"];
        }//end grade id
        if (empty($_POST["teacher_qualification"])) {
            $error_teacher_qualification = 'Teacher Qualification Field is Required';
            $error++;
        } else {
            $teacher_qualification = $_POST["teacher_qualification"];
        }//end teacher qualification
        if (empty($_POST["teacher_doj"])) {
            $error_teacher_doj = 'Date Of Joining is Required';
            $error++;
        } else {
            $teacher_doj = $_POST["teacher_doj"];
        }//end doj
        if ($error > 0) {
            $output = array(
                'error' => true,
                'error_teacher_name'=> $error_teacher_name,
                'error_teacher_address'=> $error_teacher_address,
                'error_teacher_emailid'=> $error_teacher_emailid,
                'error_teacher_password'=> $error_teacher_password,
                'error_teacher_grade_id'=> $error_teacher_grade_id,
                'error_teacher_qualification'=> $error_teacher_qualification,
                'error_teacher_doj'=> $error_teacher_doj,
                'error_teacher_image'=> $error_teacher_image
        );
        } else {
            if ($_POST["action"] == "Add") {
                $data = array(
                    ':teacher_name' => $teacher_name, 
                    ':teacher_address' => $teacher_address,
                    ':teacher_emailid' => $teacher_emailid,
                    ':teacher_password' => password_hash($teacher_password,PASSWORD_DEFAULT),
                    ':teacher_grade_id' => $teacher_grade_id,
                    ':teacher_qualification' => $teacher_qualification,
                    ':teacher_doj' => $teacher_doj,
                    ':teacher_image' => $teacher_image
                );
                $query = "
                INSERT INTO tbl_teacher
                    (teacher_name,teacher_address,teacher_emailid,teacher_password,
                    teacher_qualification,teacher_doj,teacher_image,teacher_grade_id)
                SELECT * FROM (SELECT :teacher_name,:teacher_address,:teacher_emailid,
                    :teacher_password,:teacher_qualification,:teacher_doj,:teacher_image,:teacher_grade_id) as temp
                WHERE NOT EXISTS (
                    SELECT teacher_emailid FROM 
                    tbl_teacher WHERE teacher_emailid = :teacher_emailid
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
                            'error_teacher_emailid' => 'Email Already Exists'
                        );
                    }//end  of row count
                    
                }//end of
            }//end post=add
        }//end error check
          
    } //end of post isset action
    
   echo json_encode($output);
}
