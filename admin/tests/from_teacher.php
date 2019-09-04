<?php
include 'includes/header.php';

//code for selecting teachers
// $sql = "SELECT * FROM tbl_teacher ";
//$statement = $connect ->prepare($sql);
//$statement->execute();
//$result = $statement ->fetchAll(PDO::FETCH_OBJ); 
?>

<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">Teacher List</div>
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span class="text-success" id="message_operation"></span>
              <table class="table table-striped table-bordered" id="teacher_table">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Teacher Name</th>
                        <th>Email Address</th>
                        <th>Grade</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                  <tbody>

                  <!--  <?php foreach($result as $person): ?>
                      <tr>
                        <td><?= $person->teacher_image; ?></td>
                        <td><?= $person->teacher_name; ?></td>
                        <td><?= $person->teacher_emailId; ?></td>
                        <td><?= $person->teacher_grade_id; ?></td>
                        <td><a href="delete.php?id=<?= $person->teacher_id ?>" class='btn btn-info'>View</a></td>
                        <td>
                          <a href="edit.php?id=<?= $person->teacher_id ?>" class="btn btn-info">Edit</a>
                         </td>
                         <td><a onclick="return confirm('Are you sure you want to delete this entry?')" href="delete.php?id=<?= $person->teacher_id ?>" class='btn btn-danger'>Delete</a></td>
                      </tr>
                    <?php endforeach; ?> -->
                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

</body>
<div class="modal" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="teacher_form" enctype="multipart/form-data">
            <div class="modal-content">
                <!--modal header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!--modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Teacher Name <span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="teacher_name" name="teacher_name" />
                           <span id="error_teacher_name" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Address<span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="teacher_address" name="teacher_address"></textarea>
                                <span id="error_teacher_address" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email Address<span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="teacher_emailid" name="teacher_emailid" />
                                <span id="error_teacher_emailid" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Password<span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" id="teacher_password" name="teacher_password" />
                                <span id="error_teacher_password" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Qualification<span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="teacher_qualification" name="teacher_qualification" />
                                <span id="error_teacher_qualification" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Grade<span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <select class="form-control" id="teacher_grade_id" name="teacher_grade_id">
                                    <option value="">Select Grade</option>
                                    <?php
                                    echo load_grade_list($connect);
                                    ?>
                                </select>
                                <span id="error_teacher_grade_id" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Date Of Joining
                                <span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <input type="date" name="teacher_doj" id="teacher_doj" class="form-control" />
                                <span id="error_teacher_doj" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Image
                                <span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <input type="file" name="teacher_image" id="teacher_image"/>
                                <span class="text-muted">Only .jpg and .png allowed</span><br/>
                                <span id="error_teacher_image" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="hidden_teacher_image" name="hidden_teacher_image"/>
                    <input type="hidden" name="teacher_id" id="teacher_id"  />
                    <input id="action" name="action" type="hidden" value="Add" />
                    <input id="button_action" name="button_action" type="submit" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!--view Modal -->
<div class="modal fade" id="viewModal" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Teacher Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="teacher_details">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function () {
      fetchUser(); //This function will load all data on web page when page load
 function fetchUser() // This function will fetch data from table and display under <div id="result">
 {
  var action = "Load";
  $.ajax({
   url : "pdf.php", //Request send to "action.php page"
   method:"POST", //Using of Post method for send data
   data:{action:action}, //action variable data has been send to server
   success:function(data){
    $('#teacher_table').html(data); //It will display data under div tag with id result
   }
  });
 }
       
$('#teacher_doj').datepicker({
       format :  'yyyy-mm-dd',
        autoclose: true,
        container: '#formModal modal-body'
    });

    function clear_field() {
        $('#teacher_form')[0].reset();
        $('#error_teacher_name').text('');
        $('#error_teacher_address').text('');
        $('#error_teacher_emailid').text('');
        $('#error_teacher_password').text('');
        $('#error_teacher_qualification').text('');
        $('#error_teacher_doj').text('');
        $('#error_teacher_image').text('');
        $('#error_teacher_grade_id').text('');
    }

    $('#add_button').click(function () {
        $('#modal_title').text('Add Teacher');
        $('#button_action').val('Add');
        $('#action').val('Add');
        $('#formModal').modal('show');
        clear_field();
    });

    $('#teacher_form').on('submit',function(event){
        event.preventDefault();
        $.ajax({
            url: "teacher_action.php",
            method:"POST",
            data:new FormData(this),
            dataType:"json",
            contentType:false,
            processData:false,
            beforeSend:function(){
                $('#button_action').attr('disabled','disabled');
                $('#button_action').val('Validate.....');
                   },
                   success:function(data){
                    $('#button_action').attr('disabled',false);
                    $('#button_action').val($('#action').val());
                    if (data.success) {
                       $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
                    clear_field();
                  //  dataTable.ajax.reload();
                    $('#formModal').modal('hide');
                   }
              
                   if (data.error) {
                     if (data.error_teacher_name != '') {
                        $('#error_teacher_name').text(data.error_teacher_name);
                     }
                     else{
                        $('#error_teacher_name').text('');
                     }
                      if (data.error_teacher_address != '') {
                        $('#error_teacher_address').text(data.error_teacher_address);
                     }
                     else{
                        $('#error_teacher_address').text('');
                     }
                      if (data.error_teacher_emailid != '') {
                        $('#error_teacher_emailid').text(data.error_teacher_emailid);
                     }
                     else{
                        $('#error_teacher_emailid').text('');
                     }
                      if (data.error_teacher_password != '') {
                        $('#error_teacher_password').text(data.error_teacher_password);
                     }
                     else{
                        $('#error_teacher_password').text('');
                     }
                      if (data.error_teacher_qualification != '') {
                        $('#error_teacher_qualification').text(data.error_teacher_qualification);
                     }
                     else{
                        $('#error_teacher_qualification').text('');
                     }
                      if (data.error_teacher_doj != '') {
                        $('#error_teacher_doj').text(data.error_teacher_doj);
                     }
                     else{
                        $('#error_teacher_doj').text('');
                     }
                      if (data.error_teacher_image != '') {
                        $('#error_teacher_image').text(data.error_teacher_image);
                     }
                     else{
                        $('#error_teacher_image').text('');
                     }
 
                   }
               }
        })
    });

    var teacher_id ='';
    $(document).on('click','.view_teacher',function(){
        teacher_id = $(this).attr('id');
        $.ajax({
            url:"teacher_action.php",
            method:"POST",
            data:{
                action:'single_fetch',teacher_id:teacher_id
            },
            success:function(data){
                $('#viewModal').modal('show');
                $('#teacher_details').html(data);
            }
        })
    });
        });
</script>
</html>