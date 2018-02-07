<?php
/***************************
 *  Author  :   himanshu
 *  Date    :   13.12.17
 ***************************/
require('include/config.php');
$response = 'fail';
$content = array();
$message = array();
$error = array();
$siteUrl = 'http://babysoftblog.com/babs15/frame/';
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    define("ORDER_PREFIX","OD");
    $data = $_REQUEST;
    $action = $_REQUEST['action'];
    if($action=='get-frame'){
        $perpage = 10;
        $sq= "SELECT * FROM frame";
        $result = mysqli_query($conn,$sq);
        $totalResult = mysqli_num_rows($result);
        $totalPages = ceil($totalResult/$perpage);
        if(isset($data['page']) && !empty($data['page'])){
            $page = intval($data['page']);
            $page = ($perpage * $page) - $perpage;
        }else{
            $page = 0;
        }
        $sql = "SELECT id,frame_id,frame_image,frame_length,frame_rate,discount FROM frame ORDER BY id ASC LIMIT ".$page.','.$perpage;
        $query = mysqli_query($conn,$sql);
        if(mysqli_num_rows($query)>0){
            $response = 'success';
            while($row = mysqli_fetch_assoc($query)){
                $frameData[] = $row;
            }
            $content['dataResult'] = $frameData;
            $content['totalResult'] = $totalResult;
            $content['pageSize'] = $perpage;
            $content['totalPage'] = $totalPages;
            $error = '';
            $message = '';
        }else{
            $error = 'data_not_found';
            $message = 'no data found in this section.';
        }
    }elseif($action=='get-frame-detail'){
        if(isset($data['frameSerialId']) && !empty($data['frameSerialId'])){
            $frameSerialId  = $data['frameSerialId'];
            $sql = "SELECT id,frame_id,frame_image,frame_length,frame_rate,discount FROM frame WHERE id = '".$frameSerialId."'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                $content = $row;
                $response = "success";
                $error = '';
                $message = "frame detail is found.";
            } else {
                $error = 'data_not_found';
                $message = "frame detail is not found.";
            }
        }else{
            $error   = 'parameter_not_found';
            $message = "Frame id not found.";
        }
    }elseif ($action=='user-profile') {
        $first_name = 'himanshu';//mysqli_real_escape_string($conn,$data['firstName']);
        $last_name = 'vishu';//mysqli_real_escape_string($conn,$data['lastName']);
        $token_id = '164118414484894';//$data['tokenId'];
        $provider = 'facebook';//$data['provider'];
        $email = 'test.babysoft@gmail.com';//$data['email'];
        $phone_number = '15681156149';//$data['phoneNumber'];
        $profile_image = 'no-image.jpeg';//$data['profile_image'];
        $profile_link = 'www.facebook.com';//$data['profile_link'];
        $created_at = date('Y-m-d h:i:s');
        $sql = "INSERT into user(first_name,last_name,token_id,provider,email,phone_number,profile_image,profile_link,created_at)VALUES('".$first_name."','".$last_name."','".$token_id."','".$provider."','".$email."','".$phone_number."','".$profile_image."','".$profile_link."','".$created_at."')";
        if(mysqli_query($conn,$sql)){
            $userId = mysqli_insert_id($conn);
            if(isset($userId ) && !empty($userId)){
                $user_id = $userId;
                $address_type  = 'home'; // $data['address_type'];
                $address  = 'station road charbaag'; // $data['address'];
                $city  = 'Lucknow'; // $data['city'];
                $state = 'uttar pradesh'; // $data['state'];
                $country = 'india'; // $data['country'];
                $zipcode = '225026'; // $data['zipcode'];
                $created_at = date('Y-m-d h:i:s');
                $sql1 = "INSERT into user_address (user_id,address_type,address,city,state,country,zipcode,created_at)VALUES('".$user_id."','".$address_type."','".$address."','".$city."','".$state."','".$country."','".$zipcode."','".$created_at."')";
                mysqli_query($conn,$sql1);
            }
            $response = 'success';
            $message = "User profile create successfully.";
        }else{
            $error   = 'There are some error to create user profile';
            $message = "User profile is not create successfully.";
        }
    }elseif ($action=='login') {
        if(isset($data['token']) && !empty($data['token'])){
            $token = $data['token'];
            $sql = "SELECT * FROM user where token_id = '".$token."'";
            $result = mysqli_query($conn, $sql); 
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                $response = 'success';
                $content[] = $row;
                $message="login successfully.";
            } else {
               if(isset ($data['email']) && !empty ($data['email'])){
                   $email = $data['email'];
                   $sql1 = "SELECT * FROM user where email = '".$email."'";
                   $result1 = mysqli_query($conn, $sql1); 
                    if(mysqli_num_rows($result1)>0){
                        $row1 = mysqli_fetch_assoc($result1);
                        $response = 'success';
                        $content[] = $row1;
                        $message="login successfully.";
                    }else{
                        $error = "There are some error to login.";
                        $message = "Account is not exit";
                        if(isset($data['firstName']) && !empty($data['firstName']) && isset($data['lastName']) && !empty($data['lastName']) && isset($data['tokenId']) && !empty($data['tokenId']) && isset($data['provider']) && !empty($data['provider'])){
                            $first_name = mysqli_real_escape_string($conn,$data['firstName']);
                            $last_name = mysqli_real_escape_string($conn,$data['lastName']);
                            $token_id = $data['tokenId'];
                            $provider = $data['provider'];
                            $email = $data['email'];
                            $phone_number = $data['phoneNumber'];
                            $profile_image = 'no-image.jpeg';//$data['profile_image'];
                            $profile_link = $data['profile_link'];
                            $created_at = date('Y-m-d h:i:s');
                            $query = "INSERT into user(first_name,last_name,token_id,provider,email,phone_number,profile_image,profile_link,created_at)VALUES('".$first_name."','".$last_name."','".$token_id."','".$provider."','".$email."','".$phone_number."','".$profile_image."','".$profile_link."','".$created_at."')";
                            mysqli_query($conn,$query);
                            $response = 'success';
                            $message = "User profile create successfully.";
                            $userId = mysqli_insert_id($conn);
                            if(isset($userId) && !empty($userId )){
                                $query1 = "SELECT * FROM user where id = '".$userId."'";
                                $res = mysqli_query($conn,$query1);
                                if(mysqli_num_rows($res)>0){
                                    $row2 = mysqli_fetch_assoc($res);
                                    $content[] = $row2;
                                }
                            }
                        }else{
                            $error = "There are some error to create account.";
                            $message = "All fields requird";
                        }
                    }
                }else{
                    $error = "Tparameter_not_found.";
                    $message = "Account is not exit";
                } 
            }
        }else{
            $error = "parameter_not_found.";
            $message = "Invalid login credentials";
        }
    }elseif($action=='update-profile'){
        if(isset($data['userId']) && !empty($data['userId'])){
            $userId = $data['userId'];
            
            if(isset($data['firstName']) && !empty($data['firstName'])){
                $first_name = mysqli_real_escape_string($conn,$data['firstName']);
            }
            if(isset($data['lastName']) && !empty($data['lastName'])){
                $last_name = mysqli_real_escape_string($conn,$data['lastName']);
            }
            if(isset($data['phoneNumber']) && !empty($data['phoneNumber'])){
               $phone_number = $data['phoneNumber'];  
            }
            $sql = "SELECT id,first_name,last_name,email,phone_number FROM user where id = '".$userId."'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                $response = 'success';
                $error = '';
                $message = "User profile is found.";
                $content = mysqli_fetch_assoc($result);
                if(isset($data['firstName']) && !empty($data['firstName']) && isset($data['lastName']) && !empty($data['lastName']) && isset($data['phoneNumber']) && !empty($data['phoneNumber'])){
                    $query = "update user set first_name = '".$first_name."',last_name='".$last_name."',phone_number='".$phone_number."' where id = '".$userId."'";
                    if (mysqli_query($conn,$query)){
                        $response = 'success';
                        $message = "profile update successfully";
                    }
                }
            }else{
                $error = "data_not_found";
                $message = "User profile not found.";
            }
        }else{
            $error = "parameter_not_found";
            $message = "Invalid user id";
        }
    }elseif ($action=='get-order-history') {
        if(isset($data['userId']) && !empty($data['userId'])){
            $userId = $data['userId'];
            $sql = "SELECT frame.frame_image,order_data.id,order_data.order_number,order_data.order_status,order_data.created_at,order_data.image FROM frame LEFT JOIN order_data ON frame.id = order_data.frame_id WHERE user_id='".$userId."'";
            $query1 = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query1)>0){
                $query = "SELECT * FROM order_data where user_id='".$userId."'";
                $result = mysqli_query($conn, $query);
                $res = mysqli_num_rows($result);
                $content['noOfOrders'] = $res;
                $i = 0;
                while($row = mysqli_fetch_assoc($query1)){
                    //$content[] = $row;
                    $content['orders'][$i]['id'] = $row['id'];
                    $content['orders'][$i]['orderId'] = $row['order_number'];
                    $content['orders'][$i]['currentStatus'] = $row['order_status'];
                    $content['orders'][$i]['dateAssociated'] = date('d/m/Y', strtotime($row['created_at']));
                    $content['orders'][$i]['printImage'] = $row['image'];
                    $content['orders'][$i]['chosenFrame'] = $row['frame_image']; 
                    $i++;
                }
                $k =0;
                foreach($content['orders'] as $value){
                    $query123 = "SELECT id,order_id,date_associated,order_status FROM order_status where order_id ='".$value['id']."'";
                    $result123 = mysqli_query($conn,$query123);
                    if(mysqli_num_rows($result123)>0){
                        while ($row1 = mysqli_fetch_assoc($result123)){
                            $content['orders'][$k]['history'][]= $row1;
                        }
                    }
                $k++;
                }
                $response = "success";
                $error = '';
                $message = "Order history data found.";
            }else{
                $error   = '';
                $message ="Order history data not found.";
            }
        }else{
            $error   = 'parameter_not_found';
            $message = "Invalid user id .";
        }
    }elseif ($action=='upload-image') {
        if(isset($data['userId']) && !empty($data['userId']) && isset($_FILES) && !empty($_FILES)){
            $userId =  $data['userId'];
            $created_at = date('Y-m-d h:i:s');
            $randNumber = rand(0123456789,9999999999).uniqid();
            $fileExtension = getExtension($_FILES['file']['name']);
            $fileName = md5($randNumber).'.'.$fileExtension;
            $target_dir = "uplod_image/".$fileName;
            $target_file = $_FILES['file']['tmp_name'];
            move_uploaded_file($target_file, $target_dir);
            $query = "INSERT INTO images (user_id,image,created_at)VALUES('".$userId."','".$fileName."','".$created_at."')";
            if(mysqli_query($conn, $query)){
                $response = "success";
                $message = "image upload successfully";
                $error = '';
                $content = $siteUrl.'uplod_image/'.$fileName;
            }
        }else{
            $error = 'upload_error';
            $message = "There are some error to upload image.";
        }
    }elseif($action=='place-order'){
        $query = "SELECT order_number FROM order_data ORDER BY id DESC limit 1";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            $orderNumber = str_replace(ORDER_PREFIX.'-','',$row['order_number']);
            $orderNumber = $orderNumber+1;
            $order_number = str_pad($orderNumber,3,"0",STR_PAD_LEFT);
        }else{
            $order_number = ORDER_PREFIX.'-001';
        }
        if(isset($data['userId']) && !empty($data['userId']) && isset($data['frameId']) && !empty($data['frameId']) && isset($data['frameX']) && !empty($data['frameX']) && isset($data['frameY']) && !empty($data['frameY']) && isset($data['addressId']) && !empty($data['addressId']) && isset($data['amount']) && !empty($data['amount']) && isset($data['imageId']) && !empty($data['imageId']) &&isset($data['wastageFactor'])){
            $dataArray['user_id'] =   $data['userId'];
            $dataArray['image_id'] =  $data['imageId'];
            $dataArray['frame_id'] =  $data['frameId'];
            $dataArray['frameX'] =   $data['frameX'];
            $dataArray['frameY'] =   $data['frameY'];
            $dataArray['address_id'] =  $data['addressId'];
            $dataArray['amount'] = $data['amount'];
            $dataArray['wastage_factor'] = $data['wastageFactor'];
            $dataArray['transaction_id'] =  $data['transactionId'] = uniqid();
            $dataArray['order_status'] = $data['orderStatus'] = 'Placed';
            $dataArray['frame_length'] = $data['frameLength'];
            $dataArray['order_number'] = $order_number;
            $dataArray['created_at'] = date('Y-m-d h:i:s');
            if(insert('order_data',$dataArray)){
                $response = "success";
                $message = "order is placed successfully.";
                $error = '';
            }else{
                $error = 'sql_error';
                $message = "order is not placed successfully.";
            }
        }else{
            $error = 'parameter_not_found';
            $message = "parameters not found";
        }
    }elseif ($action=='add-user-address') {
        if(isset($data['userId']) && !empty($data['userId']) && isset($data['addressType']) && !empty($data['addressType']) && isset($data['address']) && !empty($data['address'])){
            $tableName = "user_address";// table Name
            $dataArray['user_id'] = $data['userId'];
            $dataArray['address_type'] = $data['addressType'];
            $dataArray['address'] = mysqli_real_escape_string($conn,$data['address']);
            $dataArray['city'] = $data['city'];
            $dataArray['state'] = $data['state'];
            $dataArray['country'] = $data['country'];
            $dataArray['zipcode'] = $data['zipcode'];
            $dataArray['landmark'] =  mysqli_real_escape_string($conn,$data['landmark']);
            $dataArray['created_at'] = date('Y-m-d h:i:s');
            if(insert($tableName,$dataArray)){
                $response = "success";
                $message = "User address Added successfully.";
                $error = '';
            } else {
                $error = 'sql_error';
                $message = "User address is not Added successfully.";
            }
        }else{
            $error = 'parameter_not_found.';
            $message = "parameters not found.";
        }
    }else {
        $message = 'Action not found.';
        $error = 'action_error';
    }
}else{
    $error   = 'action_not_found';
    $message = 'action not found.';
}
echo json_encode(array('response'=>$response,'content'=>$content,'error'=>$error,'message'=>$message));

function getExtension($fileName=NULL){
    if(!empty($fileName)){
        $strFileName = explode('.',$fileName);
        $extension = end($strFileName);
        return $extension;
    }
}
function insert($tableName = NULL,$dataArray = array()){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'usecase';
    $errorMessage = array();
    $conn = mysqli_connect($host, $user, $password, $database);
    $fieldlist=$vallist='';
    foreach ($dataArray as $key => $value) {
        $fieldlist.=$key.',';
        $vallist.='\''.urlencode($value).'\','; 
    }
    $fieldlist=substr($fieldlist, 0, -1);
    $vallist=substr($vallist, 0, -1);
    $query = "INSERT INTO ".$tableName."(".$fieldlist.") VALUES (".$vallist.")"; 
    if(mysqli_query($conn,$query)){
        return 'Success' ;
    }
}