<?php
include 'includes/dbConnection.php';
session_start();

$output ='';
if (isset($_POST["action"])){
    if ($_POST["action"]  == "fetch"){
        $query = "SELECT * FROM tbl_grade";
 //       if (isset($_POST["search"]["value"])){
   //         $query .= 'WHERE grade_name LIKE "%'.$_POST["search"]["value"].'%"';
     //   }
      //  if (isset($_POST["order"])){
        //    $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '
          //      .$_POST['order']['0']['dir'].' ';
        //}
        //else{
          //  $query .= 'ORDER BY grade_id DESC';
        //}
      //  if ($_POST["length"] != -1){
        //    $query .= 'LIMIT '.$_POST['start'].', '.$_POST['length'];
        //}
        $statement =$connect ->prepare($query);
        $statement->execute();
        $result =$statement->fetchAll();
        $data = array();
        $filtered_rows =$statement->rowCount();
        foreach ($result as $row){
            $sub_array = array();
            $sub_array []=$row["grade_name"];
            $sub_array [] = '<button type="button" name="edit_grade" 
            class="btn btn-primary btn-sm edit_grade" id="'.$row["grade_id"].'">Edit</button>';
            $sub_array [] = '<button type="button" name="delete_grade" 
            class="btn btn-primary btn-sm delete_grade" id="'.$row["grade_id"].'">Delete</button>';
            $data[] =$sub_array;
        }

        $output = array(
          "draw" => intval($_POST["draw"]),
          "recordsTotal" => get_total_records($connect,
          'tbl_grade'),
          "recordsFiltered" => $filtered_rows,
          "data" => $data
        );

       echo json_encode($output);
    }//end fetching

    if ($_POST["action"]== 'Add' || $_POST["action"] == "Edit"){
        $grade_name ='';
        $error_grade_name ='';
        $error = 0;

        if (empty($_POST["grade_name"])){
            $error_grade_name = 'Grade Name is Required';
            $error++;
        }
        else{
            $grade_name=$_POST["grade_name"];
        }
        if ($error > 0){
            $output = array(
                'error' => true,
                'error_grade_name' => $error_grade_name
            );
        }
        else{
            if ($_POST["action"] == "Add"){
                $data = array(
                    ':grade_name' => $grade_name
                );
                $query = "INSERT INTO tbl_grade (grade_name)
                SELECT * FROM (SELECT :grade_name) as temp
                WHERE NOT EXISTS (
                SELECT grade_name FROM tbl_grade WHERE grade_name =:grade_name) 
                LIMIT 1 ";
                $statement=$connect->prepare($query);
                if ($statement->execute($data)){
                    if ($statement->rowCount() > 0){
                        $output = array(
                            'success' => 'Data Added Successfully',
                        );
                    }else{
                        $output = array(
                            'error' => true,
                            'error_grade_name' => 'Grade Name Already Exists'
                        );
                    }
                }
            } #end of add
            
        #}
            if ($_POST["action"] == "Edit"){
              $data = array(
                  ':grade_name' => $grade_name,
                  ':grade_id' =>  $_POST["grade_id"]
                );
              $query = "UPDATE tbl_grade 
              SET grade_name = :grade_name,
              grade_id = :grade_id
              WHERE grade_id =  '".$_POST["grade_id"]."'
              ";
                $statement =$connect->prepare($query);
                if($statement->execute($data)){
                    $output = array(
                        'success' => 'Data Added Successfully',
                    );
                }
            }  //end edit
       #  echo json_encode($output);
        }//end error check

      echo json_encode($output);
    }#end edit or add

    if ($_POST["action"]== "single_fetch") {
        $query = "
         SELECT * FROM tbl_grade
         WHERE grade_id = '".$_POST["grade_id"]."'
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
                     <th>Grade Name</th>
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
        SELECT * FROM tbl_grade WHERE grade_id ='".$_POST["grade_id"]."'
        ";
        $statement=$connect->prepare($query);
        if ($statement->execute()) {
            $result =$statement->fetchAll();
            foreach ($result as $row) {
                $output = array();
                $output["grade_name"]=$row["grade_name"];
                $output["grade_id"]=$row["grade_id"];
            }//foreach
            echo json_encode($output);
        }//end statement execute
    }//end edit fetch
    
    if ($_POST["action"] == "delete") {
        $query = "
        DELETE FROM tbl_grade
        WHERE grade_id = '".$_POST["grade_id"]."'
        ";
        $statement=$connect->prepare($query);
        if ($statement->execute()) {
            echo 'Data Deleted Successfully';
        }
     }//end delete action
     
}