<?php
$login_session="";
$error="";
$show="display:none;";
$alert="";
$error1="";
$show1="display:none;";
$alert1="";
include("conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['login_puser']))
{
header("Location:./dashboard.php");
exit;
}
if (isset($_POST['submitlogin']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$myusername=test_input($_POST['txtuname']);
		$mypassword=test_input($_POST['inputPassword']);
		$sql="SELECT * FROM puser WHERE status=1 AND pumob='$myusername' AND pupass='$mypassword'";
		$result = $conn->query($sql);
		if($result->num_rows>0){
			while($row = $result->fetch_assoc()) {
                die();
				$pumob=$row['pumob'];
				$pupass=$row['pupass'];
				$status=$row['status'];
			}
			if($pumob==$myusername && $pupass==$mypassword && $status==1)
			{
				$_SESSION['login_puser']=$pumob;
				$_SESSION['login_pass']=$pupass;
				header("location:./dashboard.php");
				exit();
			}
			else{
				$error="Your Login Name or Password is invalid";
				$show="display:show;";
				$alert="alert alert-danger";
			}
		}
		else{
			$error="Your Login Name or Password is invalid";
			$show="display:show;";
			$alert="alert alert-danger";
		}
	}
}

if (isset($_POST['submitforgotpass']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$myusername=addslashes($_POST['txtuname']);
		$sql="SELECT cust_mob, password FROM customer WHERE status=1 AND cust_mob='$myusername'";
		$result = $conn->query($sql);
		if($result->num_rows>0){
			while($row = $result->fetch_assoc()) {
				$password = $row['password'];
				$cust_mob = $row['cust_mob'];
			}
			//sms code for owner start from here....
			$message="Hello Your User Name: ".$cust_mob." AND Password: ".$password." Thank You";
			sentsms($message, $cust_mob,$temp_id);
			// sms code close here...
			$error1="Your Password is sent on your Mobile number: ".$myusername;
			$show1="display:show;";
			$alert1="alert alert-success";
		}
		else{
			$error1=$myusername." User Mobile Number Is Not Exist! Please Create New Account!";
			$show1="display:show;";
			$alert1="alert alert-danger";
				
		}
	}
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from adsspirits.com/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jan 2018 07:38:33 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login </title>
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/normalize.css" >
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/video.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Galada" rel="stylesheet">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="icon" type="image/ico" sizes="16x16" href="img/favicon.ico">
    <link rel="manifest" href="manifest.html">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
	
	<script type="text/javascript">
function showpass(){
    var btnval=document.getElementById("btnshowpass").innerHTML;
    if(btnval=="Show")
    {
        document.getElementById("inputPassword").type="text";
		document.getElementById("btnshowpass").innerHTML="Hide";
    }
	else{
		document.getElementById("inputPassword").type="password";
		document.getElementById("btnshowpass").innerHTML="Show";
	}
}
</script>

</head>
<body style="background-image: url('./img/login.jpg');background-repeat: no-repeat;background-attachment: fixed;
background-size: cover;">
<img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.thequint.com%2Fnews%2Flaw%2Felection-commission-linking-voter-id-aadhaar-without-consent-reveals-rti&psig=AOvVaw0UVe7N2mtCrIrucqlJXcsf&ust=1711257315154000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCLChurbQiYUDFQAAAAAdAAAAABAF" alt="">
<?php
include('./header.php');
?>
<div id="contactContainer">
    <div class="container">

        <br>
        <div class="row">
            <div class="col-md-3 col-xs-12" style="padding:10px;"></div>
            <div class="col-md-6 col-xs-12" style="padding:10px;">
			<div class="well">
			<h1 class="text-center contactHead gotham">Login</h1>
			<div class="alert <?php echo $alert; ?>" role="alert" style="<?php echo $show; ?>"><?php echo $error; ?></div>
			<p>If you are already Sign up click on login button otherwise press the sign up button</p>
                <div class="row">
                    <form id="login" name="login" action="dashboard.php" method="post"><!--<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>-->
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Mobile Number <small>*</small></label>
                            <input name="txtuname" id="txtuname" class="form-control required " type="number" placeholder="Enter Mobile" autocomplete="off" required>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="input-group">
								<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
								<span class="input-group-addon" id="btnshowpass" onclick="showpass()">Show</span>
							</div>
                        </div>
                </div>
				<div class="row" style="padding-top:20px;">
                        <div class="col-md-6" align="center">
                            <div class="form-group">
								<input name="form_botcheck" class="form-control" type="hidden" value="" />
								
								<input type="submit" name="submitlogin" class="btn btn-primary" value="LOGIN">
							</div>
                        </div>
						<div class="col-md-6" align="center">
                            <div class="form-group">
						<input name="form_botcheck" class="form-control" type="hidden" value="" />
						<a href="./registration.php"><button type="button" name="forgotpassword" class="btn btn-block btn-dark btn-theme-colored btn-sm mt-20 pt-10 pb-10" data-loading-text="Please wait...">Signup</button></a>                    
						</div>
                        </div>
				</div>
                    </form>
            </div>
            </div>
			<div class="col-md-6 col-xs-12" style="padding:10px; display:none;">
			<div class="well">
			<h1 class="text-center contactHead gotham">Forgot Password</h1>
			<div class="alert <?php echo $alert1; ?>" role="alert" style="<?php echo $show1; ?>"><?php echo $error1; ?></div>
			<p>If You are already register and forgot password just enter your registered mobile number we will send your password SMS on your mobile. </p>
                <div class="row">
                <form id="forgotpasswordfrm" name="forgotpasswordfrm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="col-md-12">
                            <div class="form-group">
								<label>Mobile Number <small>*</small></label>
								<input name="txtuname" id="txtuname" class="form-control required " type="number" placeholder="Enter Mobile" autocomplete="off" required>
							</div>
                        </div>
                </div>
				<div class="row" style="padding-top:20px;" align="center">
                            <div class="form-group">
								<input name="form_botcheck" class="form-control" type="hidden" value="" />
								<button type="submit" name="submitforgotpass" class="btn btn-block btn-dark btn-theme-colored btn-sm mt-20 pt-10 pb-10" data-loading-text="Please wait...">Get Password</button>                    						
							</div>
				</div>
                    </form>
            </div>
            </div>
			
        </div>
    </div>
</div>

<!-- / FOOTER -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
<script src="js/owl.carousel.min.js"></script>
<link rel="stylesheet"  href="css/owl.carousel.css"/>
<link rel="stylesheet"  href="css/owl.transitions.css"/>
<link rel="stylesheet"  href="css/owl.theme.css"/>
<script src="js/main.js"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(e) {
        $('#contactForm').validate({
            // Specify the validation rules
            rules: {
                name: "required",
                email:"required",
                contact:"required",
                message:"required",
            },
            // Specify the validation error messages
            messages: {
                name: "Please enter name",
                email:"Please enter email",
                contact:"Please enter contact",
                message:"Please enter message",
            },
            submitHandler: function(form) {
                var postData = $("#contactForm").serializeArray();
                var formURL = $("#contactForm").attr("action");
                $.ajax(
                        {
                            url : "./php/contact.php",
                            type: "POST",
                            data : postData,
                            dataType:'json',
                            success:function(data, textStatus, jqXHR)
                            {
                                $("#msg").hide();
                                if(data.response_code==1)
                                {
                                    $("#msg").show().html('Thank You We Will Contact You Very Soon');
                                }
                                else
                                {
                                    $("#msg").show().html(data.response_message);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown)
                            {
                                //if fails
                            }
                        });
                //STOP default action
                return false;
            }
        });
    });
</script>
</body>
<!-- Mirrored from adsspirits.com/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jan 2018 07:38:46 GMT -->
</html>