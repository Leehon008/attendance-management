<?php
include './includes/header.php';

?>
<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">Student List</div>
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span class="text-success" id="message_operation"></span>
          
           <!-- <table id="teacher_tables">
            </table> -->
          
              
            <table class="table table-striped table-bordered" id="student_table">
                    <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Roll No.</th>
                        <th>Date Of Birth</th>
                        <th>Grade</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                  
              </table> 
            </div>
        </div>
    </div>
</div>


<?php 
include '../includes/footer.php';
?>
<script>
$(document).ready(function(){
    var dataTable = $('#student_table').DataTable({
        "processing": true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url: "student_action.php",
            method: "POST",
            data:{action:"fetch"},
        }
    });
});
</script>
