<?php 
/*************************
 * Author : Mukesh Kumar
 * Date : 15.12.2017
**************************/
include('../include/config.php');
$action = $_REQUEST['action'];
$id = base64_decode($_REQUEST['id']);
if(isset($action) && !empty($action)){
    if($action == 'delete_frame'){
        $sql = "DELETE FROM frame WHERE id='".$id."'";
        if (mysqli_query($conn, $sql)) {
            $success =  "Record deleted successfully";
            header('location:frame.php?response='.$success);
        } else {
            $error = "Error deleting record: " . $conn->error;
            header('location:frame.php?response='.$error);
        }
    }
    if($action == 'delete_order'){
        $sql = "DELETE FROM order_data WHERE id='".$id."'";
        if (mysqli_query($conn, $sql)) {
            $success =  "Record deleted successfully";
            header('location:order_history.php?response='.$success);
        } else {
            $error = "Error deleting record: " . $conn->error;
            header('location:order_history.php?response='.$error);
        }
    }
}
?>