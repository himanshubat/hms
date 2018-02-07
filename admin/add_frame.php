<?php 
/*================Author : Mukesh Kumar====================*/
/*================Date : 15.12.2017========================*/
ob_start();
    $title = 'Add Frame';
	include('header.php');
	if(isset($_POST) && !empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_FILES) && !empty($_FILES)){
			$temp = explode(".", $_FILES["frame_image"]["name"]);
			$filename = round(microtime(true)).$_POST['frame_id'] . '.' . end($temp);
			$target_dir = "uploads/";
			$target_file = $target_dir . $filename;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["frame_image"]["tmp_name"]);
			    if($check !== false) {
			        $uploadOk = 1;
			    } else {
			        $error =  "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			if (file_exists($target_file)) {
			    $error=  "Sorry, file already exists.";
			    $uploadOk = 0;
			}
			if ($_FILES["frame_image"]["size"] > 500000) {
			    $error = "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    $error =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			if ($uploadOk == 0) {
			    //$error =  "Sorry, your file was not uploaded.";
			} else {
			    if (move_uploaded_file($_FILES["frame_image"]["tmp_name"], $target_file)) {
			    } else {
			        $error =  "Sorry, there was an error uploading your file.";
			    }
			}
		}else{
			$filename = 'no-image.png';
		}
		/*insert query to insert data to database*/
		if(empty($error)){
			$sql = "INSERT INTO frame (frame_id, frame_image, frame_length,frame_rate,discount,created_at) 
					VALUES ('".$_POST['frame_id']."', '".$filename."', '".$_POST['frame_length']."','".$_POST['frame_rate']."','".$_POST['discount']."','".date('Y-m-d h:i:s')."')";
			if (mysqli_query($conn, $sql)) {
			    $success =  "New record created successfully";
                header('location:frame.php?response='.$success);
			} else {
			    $error =  "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		/*insert query to insert data to database*/
	} 

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo  $title; ?> <a href="#" title=""><i class="fa fa-codepen  fa-fw"></i></a></h1>
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
        <div class="col-sm-2">
            <center><img id="imgholder" src="uploads/15133240785.jpg" class="img-responsive" alt="">
            <big>Frame Image</big></center>
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo  $title; ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form method="post" action="" id="add_frame_form" enctype="multipart/form-data">
                    	 <div class="form-group">
                            <label>Frame Id</label>
                    	 	<input type="text" name="frame_id" class="form-control required"  placeholder="Frame Id">
                    	 </div>

                    	 <div class="form-group">
                            <label>Frame Image</label>
                    	 	<input type="file" name="frame_image" id="frame_image" class="form-control required"  placeholder="Frame Image">
                    	 </div>
                    	
                    	<div class="form-group">
                            <label>Frame Length</label>
                    	 	<input type="text" name="frame_length" class="form-control required"  placeholder="Frame Length">
                    	 </div>

                    	 <div class="form-group">
                            <label>Frame Rate</label>
                    	 	<input type="text" name="frame_rate" class="form-control required"  placeholder="Frame Rate">

                    	 </div>

                    	 <div class="form-group">
                            <label>Discount</label>
                    	 	<input type="text" name="discount" class="form-control"  placeholder="Discount">
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
        $('#add_frame_form').validate({
           
        })
    });

    /*preview image before upload*/
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imgholder').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    }
    $("#frame_image").change(function () {
    readURL(this);
    });
    /*preview image before upload*/
</script>