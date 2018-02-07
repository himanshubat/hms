<?php 
/*================Author : Mukesh Kumar====================*/
/*================Date : 15.12.2017========================*/
$title = 'Order History';
include('header.php'); 
$sql = "SELECT order_data.id, order_data.order_number,order_data.image,user.first_name,user.last_name,order_data.transaction_id,order_data.order_status,order_data.created_at FROM order_data LEFT JOIN user ON order_data.user_id = user.id ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
} else {
    $error =  "There is no record in this section";
}
?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo  $title; ?><a href="dashboard.php" ><i class="fa  fa-history  fa-fw"></i></a></h1>
            </div>
            <!-- /.col-lg-12 -->
            <?php if(!empty($error) ){ ?>
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error!</strong> <?php echo $error; ?>
                </div>
            </div>
            <?php }else{ ?>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo  $title; ?>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="frameListTabel">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Order Id</th>
                                    <!--<th>Image</th>-->
                                    <th>Transaction Id</th>
                                    <th>Order Status</th>
                                    <th>Created date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $row['first_name'].' '.$row['last_name'] ?></td>
                                    <td><?php echo $row['order_number'] ?></td>
                                    <!--<td><?php // echo $row['image'] ?></td>-->
                                    <td><?php echo $row['transaction_id'] ?></td>
                                    <td><?php echo $row['order_status'] ?></td>
                                    <td><?php echo $row['created_at'] ?></td>
                                    <td><a href="view_order.php?id=<?php echo base64_encode($row['id']) ?>" title="" class="btn btn-success">View</a>
                                    <a href="delete.php?action=delete_order&id=<?php echo base64_encode($row['id']) ?>" title="" onclick="return confirm('Are You Sure to delete this ?')" class="btn btn-danger">Delete</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <?php } ?>
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