<?php
include 'includes/dbConnection.php';
session_start();
if (isset($_POST["action"])){
    if ($_POST["action"] == "fetch"){
       $query = "SELECT * FROM tbl_teacher INNER JOIN tbl_grade 
                ON tbl_grade.grade_id = tbl_teacher.teacher_grade_id ";
       if (isset($_POST["search"]["value"])){
           $query .= 'WHERE tbl_teacher.teacher_name LIKE "%'.$_POST["search"]["value"].'%"
           OR tbl_teacher.teacher_emailId LIKE "%'.$_POST["search"]["value"].'%"
           OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%"
           ';
       }
       //if (isset($_POST["order"])){
         // $query .= 'ORDER BY '.$_POST["order"]["0"]["column"].''.$_POST["order"]["0"]["dir"].'';
       //}
       //else {
         //$query .= 'ORDER BY tbl_teacher.teacher_id DESC';
       //}
       //if (isset($_POST["length"]) != -1){
        //  $query .= 'LIMIT '.$_POST["start"].','.$_POST["length"];
      //  }
    //    $tquery = "SELECT * FROM tbl_teacher ORDER BY teacher_id DESC";
       $statement = $connect ->prepare($query);
       $statement->execute();
       $result = $statement ->fetchAll();
       $data = array();
      // $output= '';
       $filtered_rows = $statement->rowCount();

       //trying to fetch using my code style
       //$output .='
            //<tr>
            //<th width="40%">Teacher Name</th>
            //<th width="40%">Address Name</th>
           // <th width="10%">Update</th>
           // <th width="10%">Delete</th>
         //   </tr>       ';
       //if ($filtered_rows > 0) {
           //foreach ($result as $row) {
            //$output .= '
            //<tr>
             //<td>'.$row["teacher_name"].'</td>
             //<td>'.$row["teacher_address"].'</td>
             //<td><button type="button" id="'.$row["teacher_id"].'" class="btn btn-warning btn-xs update">Update</button></td>
             //<td><button type="button" id="'.$row["teacher_id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
           // </tr>
         //   ';  
       //    }
     //  } else {
         //   $output .= '
           // <tr>
           //   <td align="center">Data not Found</td>
         //   </tr>       ';
       //}
      // echo json_encode($output);
       //ending my trial here

      foreach ($result as $row){
         $sub_array = array();
        $sub_array[] = '<img src="teacher_image/'.$row["teacher_image"].'" 
        class="img-thumbnail" width="75" />';
        $sub_array[] = $row["teacher_name"];
        $sub_array[] = $row["teacher_emailId"];
        $sub_array[] = $row["grade_name"];
        $sub_array[] = '<button type="button" name="view_teacher" 
        class="btn btn-info btn-sm view_teacher" id="'.$row["teacher_id"].'">View</button>';
        $sub_array[] = '<button type="button" name="edit_teacher" 
        class="btn btn-info btn-sm edit_teacher" id="'.$row["teacher_id"].'">Edit</button>';
        $sub_array[] = '<button type="button" name="delete_teacher" 
        class="btn btn-info btn-sm delete_teacher" id="'.$row["teacher_id"].'">Delete</button>';
        $data[] = $sub_array;
        }
       $output = array(
         "draw" => intval($_POST["draw"]),
          "recordsTotal" => get_total_records($connect, 'tbl_teacher'),
         "recordsFiltered" => $filtered_rows,
       "data" => $data
    ); 
    echo json_encode($output);
    }//end fetching data 
    
    //for the add, edit and delete
    if ($_POST["action"] == "Add" || $_POST["action"]== "Edit") {
        $teacher_name='';
        $teacher_address='';
        $teacher_emailId='';
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
                $teacher_emailId = $_POST["teacher_emailid"];
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
                    ':teacher_emailid' => $teacher_emailId,
                    ':teacher_password' => password_hash($teacher_password,PASSWORD_DEFAULT),
                    ':teacher_grade_id' => $teacher_grade_id,
                    ':teacher_qualification' => $teacher_qualification,
                    ':teacher_doj' => $teacher_doj,
                    ':teacher_image' => $teacher_image
                );
                $query = "
                INSERT INTO tbl_teacher
                    (teacher_name,teacher_address,teacher_emailId,teacher_password,
                    teacher_qualification,teacher_doj,teacher_image,teacher_grade_id)
                SELECT * FROM (SELECT :teacher_name,:teacher_address,:teacher_emailid,
                    :teacher_password,:teacher_qualification,:teacher_doj,:teacher_image,:teacher_grade_id) as temp
                WHERE NOT EXISTS (
                    SELECT teacher_emailId FROM 
                    tbl_teacher WHERE teacher_emailId = :teacher_emailid
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

            if ($_POST["action"] == "Edit") {
              $data = array(
                ':teacher_id'=>$_POST["teacher_id"],
                ':teacher_name' => $teacher_name, 
                ':teacher_address' => $teacher_address,
                ':teacher_emailId' => $teacher_emailId,
                ':teacher_password' => $teacher_password,
                ':teacher_grade_id' => $teacher_grade_id,
                ':teacher_qualification' => $teacher_qualification,
                ':teacher_doj' => $teacher_doj,
              )  ;
              $query = "
              UPDATE tbl_teacher 
              (teacher_id,teacher_name,teacher_address,teacher_emailId,
              teacher_password,teacher_grade_id,teacher_qualification,
              teacher_doj)
              SET
              (':teacher_id','$teacher_name','$teacher_address','$teacher_emailId',
              '$teacher_password','$teacher_grade_id','$teacher_qualification','$teacher_doj')
              ";
              $statement=$connect->prepare($query);
              if ($statement->execute($data)) {
                  $output = array(
                      'success' => 'Data Edited Successfully'
                  );
              }
            }//end edit
        }//end error check
        echo json_encode($output);
    } //end of post isset action
    
    if ($_POST["action"]== "single_fetch") {
        $query = "
         SELECT * FROM tbl_teacher
         INNER JOIN tbl_grade
         ON tbl_grade.grade_id = tbl_teacher.teacher_grade_id
         WHERE tbl_teacher.teacher_id = '".$_POST["teacher_id"]."'
        ";
        $statement =$connect->prepare($query);
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            $output = '
            <div class="row">
            ';
            foreach ($result as $row) {
            $output .='
            <div class="col-md-3">
              <img src="teacher_image/'.$row["teacher_image"].'" 
              class="img-thumbnail" />
            </div>
            <div class="col-md-9">
                <table class="table">
                    <tr>
                     <th>Name</th>
                     <td>'.$row["teacher_name"].'</td>
                    </tr>
                    <tr>
                     <th>Address</th>
                     <td>'.$row["teacher_address"].'</td>
                    </tr>
                    <tr>
                     <th>Email Address</th>
                     <td>'.$row["teacher_emailId"].'</td>
                    </tr>
                    <tr>
                     <th>Qualification</th>
                     <td>'.$row["teacher_qualification"].'</td>
                    </tr>
                    <tr>
                     <th>Date Of Joining</th>
                     <td>'.$row["teacher_doj"].'</td>
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
        SELECT * FROM tbl_teacher WHERE teacher_id ='".$_POST["teacher_id"]."'
        ";
        $statement=$connect->prepare($query);
        if ($statement->execute()) {
            $result =$statement->fetchAll();
            foreach ($result as $row) {
                $output["teacher_name"]=$row["teacher_name"];
                $output["teacher_address"]=$row["teacher_address"];
                $output["teacher_emailId"]=$row["teacher_emailId"];
                $output["teacher_password"]=$row["teacher_password"];
                $output["teacher_qualification"]=$row["teacher_qualification"];
                $output["teacher_doj"]=$row["teacher_doj"];
                $output["teacher_image"]=$row["teacher_image"];
                $output["teacher_grade_id"]=$row["teacher_grade_id"];
                $output["teacher_id"]=$row["teacher_id"];

            }//foreach
            echo json_encode($output);
        }//end statement execute
    }//end edit fetch
 
    if ($_POST["action"] == "delete") {
       $query = "
       DELETE FROM tbl_teacher
       WHERE teacher_id = '".$_POST["teacher_id"]."'
       ";
       $statement=$connect->prepare($query);
       if ($statement->execute()) {
           echo 'Data Deleted Successfully';
       }
    }//end delete action
}
