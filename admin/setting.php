<?php  
/*================Author : Mukesh Kumar====================*/
/*================Date : 15.12.2017========================*/


    $title = 'Setting';
	include('header.php');
	if(isset($_POST) && !empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
		$old_password = $_POST['old_password'];
        $new_password = $_POST['confirm_password'];

        $sql = "SELECT id FROM admin WHERE password='".md5($old_password)."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
           $row = mysqli_fetch_assoc($result);
        } else {
            $error =  "Invalid password";
        }
        if(empty($error)){
            $sql = "UPDATE admin SET password='".md5($new_password)."',updated_at='".date('Y-m-d h:i:s')."' WHERE id='".$row['id']."'";
            if (mysqli_query($conn, $sql)) {
                $success =  "Update Password successfully";
            } else {
                $error =  "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
	} 

?>






<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $title; ?> <a href="#" title=""><i class="fa fa-cogs   fa-fw"></i></a></h1>
        </div>
        <?php if(!empty($error)): ?>
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> <?php echo $error; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if(!empty($success)): ?>
		<div class="col-sm-12">
            <div class="alert alert-success alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> <?php echo $success; ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- /.col-lg-12 -->
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change Password
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form method="post" action="" id="setting_form"  enctype="multipart/form-data">
                    	<div class="form-group">
                            <label>Old Password</label>
                    	 	<input type="password" name="old_password" class="form-control required" value="" placeholder="Old Password">
                    	</div>
                        
                        <div class="form-group">
                            <label>New Password</label>
                               <input type="password" name="new_password" id="new_password" class="form-control required" value="" placeholder="New Password">
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control required" value="" placeholder="Confirm Password">
                        </div>
                    	 
                    	 <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
<?php include('footer.php'); ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#setting_form').validate({
             rules: {
                new_password: "required",
                confirm_password: {
                  equalTo: "#new_password"
                }
            }
        })
    });
</script>