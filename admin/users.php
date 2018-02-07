<?php 
/*================Author : Mukesh Kumar====================*/
/*================Date : 15.12.2017========================*/


    
$title = 'User List';

include('header.php'); 

$sql = "SELECT * FROM user ORDER BY created_at";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
   // $row = mysqli_fetch_assoc($result);
} else {
    $error =  "There is no record in this section";
}
?>



<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Users<a href="#" title=""><i class="fa fa-users   fa-fw"></i></a></h1>
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <?php if(!empty($_REQUEST['response'])) {?>
                    <div class="col-sm-12">
                        <div class="alert alert-success alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>Response!</strong> <?php echo $_REQUEST['response']; ?>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if(!empty($error) ){ ?>
                    <div class="col-sm-12">
                        <div class="alert alert-danger alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>Error!</strong> <?php echo $error; ?>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="frameListTabel">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Provider</th>
                                <th>Created date</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="odd gradeX">
                                <td><?php echo $row['first_name'].' '.$row['last_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                <td><?php echo $row['provider']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <!-- <td><a href="edit_user.php?id=<?php echo $row['id'] ?>" title="" class="btn btn-danger">Edit</a>
                                    <a href="delete.php?action=delete_user&id=<?php echo $row['id'] ?>" title="" class="btn btn-success">Delete</a></td> -->
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
<?php include('footer.php'); ?>






<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function() {
	$('#frameListTabel').DataTable({
	    responsive: true
	});
});
</script>	