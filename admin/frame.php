<?php 
/*================Author : Mukesh Kumar====================*/
/*================Date : 15.12.2017========================*/
$title = 'Frame List';
include('header.php'); 
$sql = "SELECT * FROM frame ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    //$row = mysqli_fetch_assoc($result);
} else {
    $error =  "There is no record in this section";
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo  $title; ?><a href="add_frame.php" title="Add Frame" class="pull-right"><i class="fa fa-plus-circle  fa-fw"></i></a></h1>
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo  $title; ?>
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
                                <th>Frame id</th>
                                <th>Frame Image</th>
                                <th>Frame Length</th>
                                <th>Frame Rate</th>
                                <th>Discount</th>
                                <th>Created date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="odd gradeX">
                                <td><?php echo $row['frame_id']; ?></td>
                                <td><img src="uploads/<?php echo $row['frame_image']; ?>" alt="" height="100" width="100"></td>
                                <td><?php echo $row['frame_length']; ?></td>
                                <td><?php echo $row['frame_rate']; ?></td>
                                <td><?php echo $row['discount']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td><a href="edit_frame.php?id=<?php echo base64_encode($row['id']) ?>" title="" class="btn btn-success" onclick="return confim('Are You Sure..')">Edit</a>
                                    <a href="delete.php?action=delete_frame&id=<?php echo base64_encode($row['id']) ?>" title="" onclick="return confirm('Are You Sure to delete this ?');" class="btn btn-danger">Delete</a></td>
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
	    responsive: true,
         "aaSorting": [],
	});
});
</script>	