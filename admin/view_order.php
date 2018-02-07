<?php 
/**************************
 * Author : Mukesh Kumar
 * Date : 15.12.2017
*************************/
ob_start();
$title = 'View Order Detail';
include('header.php'); 
$option = array('Placed'=>'Placed','In-Progress'=>'In-Progress','Completed'=>'Completed','Out For Delivery'=>'Out For Delivery');
?>
        <div id="page-wrapper">
            <?php
                if(isset($_GET['id']) && !empty($_GET['id'])){ 
                    $id = base64_decode($_GET['id']);
                    $sql = "SELECT * FROM order_data LEFT JOIN user_address ON user_address.user_id = order_data.user_id LEFT JOIN user ON user.id = order_data.user_id where order_data.id = '".$id."'";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result)>0){
                            $row = mysqli_fetch_assoc($result);
                        }
                    }else{
                        $error = "sql error";
                    }
                }
                if(isset($_POST['submit'])){
                    if(isset($_GET['id']) && !empty($_GET['id']) && isset($_POST['status']) && !empty($_POST['status'])){
                        $order_id = base64_decode($_GET['id']);
                        $status = $_POST['status'];
                        $date_associated = date('Y-m-d', strtotime($row['created_at']));
                        $created_at = date('Y-m-d h:i:s');
                        $query = "INSERT INTO order_status(order_id,order_status,date_associated,created_at)VALUES('".$order_id."','".$status."','".$date_associated."','".$created_at."')";
                        if(mysqli_query($conn,$query)){
                            $query1 = "UPDATE order_data SET id = '".$order_id."', order_status ='".$status."' where id = '".$order_id."'";
                            mysqli_query($conn,$query1);
                            $success =  "Update order status successfully";
                            header("Refresh: 2;order_history.php");
                        } else {
                            $error =  "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }else{
                        $errorMsg = "Please select status.";
                    }
                }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo  $title; ?> <a href="order_history.php" ><i class="fa  fa-shopping-cart  fa-fw"></i></a></h1>
                </div>
                <?php if(!empty($success)): ?>
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> <?php echo $success; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($errorMsg)): ?>
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>ERROR!</strong> <?php echo $errorMsg; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- /.col-lg-12 -->
                <div class="col-sm-6">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo  $title; ?> 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form method="post"  enctype="multipart/form-data">
                    	<div class="form-group">
                            <label>Order Number</label>
                            <input type="text" name="orderId" value="<?php echo (isset($row['order_number']))?$row['order_number']:''; ?>" class="form-control"  placeholder="Order Id" readonly="readonly" />
                    	</div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstName" value="<?php echo (isset($row['first_name']))?$row['first_name']:''; ?>" class="form-control"  placeholder="First Name" readonly="readonly">
                    	</div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastName" value="<?php echo (isset($row['last_name']))?$row['last_name']:''; ?>" class="form-control"  placeholder="Last Name" readonly="readonly">
                    	</div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" readonly="readonly"><?php echo (isset($row['address']))?$row['address']:''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" value="<?php echo (isset($row['city']))?$row['city']:''; ?>" placeholder="City" readonly="readonly" />
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" value="<?php echo (isset($row['state']))?$row['state']:''; ?>" placeholder="State" readonly="readonly"/>
                        </div> 
                        <div class="form-group">
                            <label>Country</label>
                            <input type ="text" class="form-control" value="<?php echo (isset($row['country']))?$row['country']:''; ?>" placeholder="Country" readonly="readonly"/>
                        </div>
                        <div class="form-group">
                            <label>Zipcode</label>
                            <input type ="text" class="form-control" value="<?php echo (isset($row['zipcode']))?$row['zipcode']:''; ?>" placeholder="Zipcode" readonly="readonly"/>
                        </div>
                    	<div class="form-group">
                            <label>Frame X</label>
                            <input type="text" name="FrameX" value="<?php echo (isset($row['frameX']))?$row['frameX']:''; ?>"  class="form-control"  placeholder="FrameX" readonly="readonly" />
                    	</div>

                    	<div class="form-group">
                            <label>Frame Y</label>
                            <input type="text" name="FrameY" value="<?php echo (isset($row['frameY']))?$row['frameY']:''; ?>" class="form-control"  placeholder="FrameY" readonly="readonly"/>
                    	</div>

                    	<div class="form-group">
                            <label>Frame Length</label>
                            <input type="text" name="frameLength" value="<?php echo (isset($row['frame_length']))?$row['frame_length']:''; ?>" class="form-control"  placeholder="Frame Length" readonly="readonly" />
                    	</div>
                        <div class="form-group">
                            <label>Wastage Factor</label>
                            <input type="text" name="wastageFactor" value="<?php echo (isset($row['wastage_factor']))?$row['wastage_factor']:''; ?>" class="form-control"  placeholder="Wastage Factor" readonly="readonly">
                    	</div>
                        <div class="form-group">
                            <label>Order status</label>
                            <select class="form-control" name="status">
                                <option value="">please Select</option>
                                <?php foreach($option as $key=>$value){ ?>
                                <?php if(isset($row['order_status']) && ($value==$row['order_status'])){ ?>
                                <option value="<?php echo $row['order_status']; ?>" selected="selected"><?php echo $row['order_status']; ?></option>
                               <?php }else{?>
                                <option value="<?php echo $value;?>"><?php echo $value?></option>
                               <?php }}?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default" name="submit">Submit</button>
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