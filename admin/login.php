<?php
include '../config/config.php';
include './includes/dbConnection.php';
//include '../helpers/format_helper.php';

session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo SITE_TITTLE; ?></title>
        <!-- Bootstrap core CSS -->
        <link href="../libraries/css/bootstrap.min.css" rel="stylesheet">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../libraries/css/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <!--custom stylesheet -->
        <link href="../libraries/css/custom_style.css " rel="stylesheet"/>
        <link href="../libraries/css/bootstrap4.min.css " rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="../libraries/css/floating-labels.css" rel="stylesheet">
       <script src="../libraries/js/jquery.min.js"></script>
        <script src="../libraries/js/dataTables.min.js"></script>
        <script src="../libraries/js/bootstrap4.min.js"></script>
        <script src="../libraries/js/bootstrap.min.js"></script>
        <script src="../libraries/js/jquery.dataTables.min.js"></script>
        <script src="../libraries/js/popper.min.js"></script> 
       <script src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"></script>
    </head>
    <body>
        <form class="form-signin" method="post" id="admin_login_form">
            <div class="text-center mb-4">
                <img class="mb-4" src="../images/1.jpg" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Admin Login</h1>
            </div>

            <div class="form-group">
                <label>Enter Username</label><br/>
                <input type="text" id="admin_user_name" name="admin_user_name" class="form-control" placeholder="Admin Username" />
                <span id="error_admin_user_name" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label>Enter Username</label><br/>
                <input type="password" id="admin_password" name="admin_password" class="form-control" placeholder="Password" />
               <span id="error_admin_password" class="text-danger"></span>
            </div>

            <div class="form-group">
                <input class="btn btn-info" type="submit" value="Login" id="admin_login" name="admin_login" />
            </div>
            <p class="mt-5 mb-3 text-muted text-center">&copy; <?php echo SITE_AUTHOR; ?></p>
        </form>
    </body>
    <script>
    $(document).ready(function(){
        $('#admin_login_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url: "check_admin_login.php",
                method:"POST",
                data: $(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#admin_login').val('Validate...');
                    $('#admin_login').attr('disabled', 'disabled');
                },
                success:function(data) {
                    if (data.success){
                        location.href = "<?php echo $base_url; ?>admin";
                    }
            
                    if (data.error){
                        $('#admin_login').val('Login');
                        $('#admin_login').attr('disabled', false);
                        if (data.error_admin_user_name !== ''){
                        $('#error_admin_user_name').text(data.error_admin_user_name);
                        } else{
                            $('#error_admin_user_name').text('');
                        }
                    
                        if (data.error_admin_password !== ''){
                            $('#error_admin_password').text(data.error_admin_password);
                        } else {
                            $('#error_admin_password').text('');
                        }
                    }
                }
            });
        });
    });
</script>
</html>
