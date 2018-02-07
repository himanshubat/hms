<?php 
/*================Author : Mukesh Kumar====================*/
/*================Date : 15.12.2017========================*/
include('../include/config.php');
if(isset($_SESSION['Auth']) && !empty($_SESSION['Auth'])){
    header('location:dashboard.php');
}
    if(isset($_POST) && !empty($_POST)){
        $post = $_POST;
        $sql = "SELECT * FROM admin WHERE username='".$post['username']."' AND password='".md5($post['password'])."' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['Auth'] = $row;
            if($post['remember'] == 'yes'){
                setcookie('Auth', $row['username'], time() + (86400 * 30), "/"); // 86400 = 1 day
            }
            if(isset($_SESSION['Auth']) && !empty($_SESSION['Auth'])){
                if($_COOKIE['request']){
                    $request_uel = $_COOKIE['request'];
                    header('location:'.$request_uel.'');
                }else{
                    header('location:dashboard.php');
                }
            }
        } else {
            $error = 'Invalid Username or Password';
        }
    }else{
        $error = '';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css" media="screen">
        label.error {
            font-size: 10px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?php if(!empty($error)): ?>
                <div class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error!</strong> <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" method="post" id="login_form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control required" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control required" placeholder="Password" name="password" type="password">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="yes">Remember Me
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#login_form').validate({

            })
        });
    </script>
</body>
</html>
