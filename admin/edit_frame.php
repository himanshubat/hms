<?php  
/*================Author : Mukesh Kumar====================*/
/*================Date : 15.12.2017========================*/
    ob_start();
    $title = 'Edit Frame';
    include('header.php');
    /*fetch data using this id*/
    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
        $id = base64_decode($_REQUEST['id']);
        $sql1 = "SELECT * FROM frame WHERE id='".$id."'";
        $result1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($result1) > 0) {
           $row1 = mysqli_fetch_assoc($result1);
        } else {
            $error =  "There is no record in this section";
        }
    }else{
        $error =  "Invalid request";
    }
    /*fetch data using this id*/
    if(isset($_POST) && !empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_FILES['frame_image']) && !empty($_FILES['frame_image']) && $_FILES["frame_image"]["size"] > 0){
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
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $error =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
               // $error =  "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["frame_image"]["tmp_name"], $target_file)) {
                } else {
                    $error =  "Sorry, there was an error uploading your file.";
                }
            }
        }else{
            $filename = $row1['frame_image'];
        }
        /*Update query to Update data to database*/
        if(empty($error)){
            $sql = "UPDATE frame SET frame_id='".$_POST['frame_id']."',frame_image='".$filename."',frame_length='".$_POST['frame_length']."',frame_rate='".$_POST['frame_rate']."',discount='".$_POST['discount']."',updated_at='".date('Y-m-d h:i:s')."' WHERE id='".$id."'";
            if (mysqli_query($conn, $sql)) {
                    $success =  "Update record successfully";
                    header('location:frame.php?response='.$success);
                } else {
                    $error =  "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        /*Update query to Update data to database*/
    } 
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo  $title; ?> <a href="#" title=""><i class="fa fa-pencil  fa-fw"></i></a></h1>
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
        <?php if(isset($row1) && !empty($row1)){ ?>
        <div class="col-sm-2">
           <center><img id="imgholder" src="uploads/<?php echo $row1['frame_image']; ?>" class="img-responsive" alt="">
            <big>Frame Image</big></center>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo  $title; ?> 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form method="post"  enctype="multipart/form-data">
                    	<div class="form-group">
                            <label>Frame Id</label>
                    	 	<input type="text" name="frame_id" value="<?php echo $row1['frame_id']; ?>" class="form-control"  placeholder="Frame Id">
                    	</div>

                    	<div class="form-group">
                            <label>Frame Image</label>
                    	 	<input type="file" name="frame_image" id="frame_image" value="<?php echo $row1['frame_image']; ?>" class="form-control"  placeholder="">
                    	</div>
                    	
                    	<div class="form-group">
                            <label>Frame Length</label>
                    	 	<input type="text" name="frame_length" value="<?php echo $row1['frame_length']; ?>" class="form-control"  placeholder="Frame Length">
                    	</div>

                    	<div class="form-group">
                            <label>Frame Rate</label>
                    	 	<input type="text" name="frame_rate" value="<?php echo $row1['frame_rate']; ?>" class="form-control"  placeholder="Frame Rate">
                    	</div>

                    	<div class="form-group">
                            <label>Discount</label>
                    	 	<input type="text" name="discount" value="<?php echo $row1['discount']; ?>" class="form-control"  placeholder="Discount">
                    	</div>
                    	<button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <?php }?>
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