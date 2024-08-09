<?php
$login_session="";
$error="";
$show="display:none;";
$alert="";
include("conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['login_puser']))
{
header("Location:./dashboard.php");
exit;
}
if (isset($_POST['submitsignup']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$myusername=test_input($_POST['txtuname']);
		$myusermob=test_input($_POST['txtumob']);
		$address=test_input($_POST['txtaddress']);
		$bdate=test_input($_POST['txtbdate']);
		$email=test_input($_POST['txtemail']);
		$mypassword=test_input($_POST['inputPassword']);
		$confpass = test_input($_POST["inputPasswordConfirm"]);
		
		$currdate=date("Y/m/d");
			//$bdate=$row['bdate'];
			$diff = abs(strtotime($currdate) - strtotime($bdate));
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$d=date_parse_from_format("Y-m-d",$bdate);
			$m=$d["month"];
			$m1=date("m");
			$d=$d["day"];
			$d1=date("d");
			
		$sql="SELECT status FROM puser WHERE status=1 AND pumob='$myusermob' AND pupass='$mypassword'";
		$result = $conn->query($sql);
		if($result->num_rows>0){
				$_SESSION['login_puser']=$myusermob;
				$_SESSION['login_pass']=$mypassword;
				header("location:./dashboard.php");
				die();
		}
		else{
			$sql1="SELECT pumob FROM puser WHERE pumob='$myusermob' and status=1 ";
			$result = $conn->query($sql1);
			if ($result->num_rows > 0){
				$error=$myusermob." "."User Name Is Already Exist! ";
				$show="display:show;";
				$alert="alert alert-danger";
			}
			else if($years<=15){
				$error="Your Age is Less then 15";
				$show="display:show;";
				$alert="alert alert-danger";
			}
			else{
				if($mypassword===$confpass)
				{
					$sql = "INSERT INTO puser ( puname, pupass, pumob, bdate, buemail, address, regdate, status )
					VALUES ('$myusername', '$mypassword','$myusermob',  '$bdate', '$email', '$address', @now := now(), 1)";
					if ($conn->query($sql) === TRUE) {
					$error="User Is Addes successfully! <a href='./login.php'>Click Here To Login </a>";
					$show="display:show;";
					$alert="alert alert-success";
					}
					else{
					$error="Your signup is invalid";
					$show="display:show;";
					$alert="alert alert-danger";
					}
				}
				else
				{
				$error="Your Password and Confirm Password is Not Match!";
				$show="display:show;";
				$alert="alert alert-danger";
				}
			}
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
    <title>Registration</title>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.4.0/moment.min.js"></script>
<script type="text/javascript">
		

		function validation(){

			var user = document.getElementById('user').value;
			var mobileNumber = document.getElementById('mobileNumber').value;
			var bdate = document.getElementById('bdate').value;
			var d = new Date("2015-03");

			if(user == ""){
				document.getElementById('username').innerHTML =" ** Please fill the username field";
				return false;
			}
			if((user.length <= 2) || (user.length > 20)) {
				document.getElementById('username').innerHTML =" ** Username lenght must be between 2 and 20";
				return false;
			}
			if(!isNaN(user)){
				document.getElementById('username').innerHTML =" ** only characters are allowed";
				return false;
			}

			if(mobileNumber == ""){
				document.getElementById('mobileno').innerHTML =" ** Please fill the mobile NUmber field";
				return false;
			}
			if(isNaN(mobileNumber)){
				document.getElementById('mobileno').innerHTML =" ** user must write digits only not characters";
				return false;
			}
			if(mobileNumber.length!=10){
				document.getElementById('mobileno').innerHTML =" ** Mobile Number must be 10 digits only";
				return false;
			}

		}
	</script>

</head>
<body style="background-image: url('./img/login.jpg');background-repeat: no-repeat;background-attachment: fixed;
background-size: cover;">
<?php
include('./header.php');
?>
<div id="contactContainer">
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-3">
			</div>
            <div class="col-md-6 col-xs-12 well" style="padding:10px;">
			<h1 class="text-center contactHead gotham">Registration</h1>
			<div class="alert <?php echo $alert; ?>" role="alert" style="<?php echo $show; ?>"><?php echo $error; ?></div>
                <div class="row">
                    <form id="login" name="login" onsubmit="return validation()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="col-md-12">
                        <div class="form-group">
                        <label>Name <small>*</small></label>
                        <input name="txtuname" type="text" placeholder="Enter Name" id="user" required="" class="form-control" required>
						<span id="username" class="text-danger font-weight-bold"> </span>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <label>Mobile Number <small>*</small></label>
                        <input name="txtumob" class="form-control required " type="number" id="mobileNumber" placeholder="Enter Mobile" required>
						<span id="mobileno" class="text-danger font-weight-bold"> </span>
                        </div>
                        </div>
						<div class="col-md-12">
                            <div class="form-group">
                        <label>Password <small>*</small></label>
                        <input name="inputPassword" class="form-control required " type="password" placeholder="Enter Password" required>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Confirm Password <small>*</small></label>
                        <input name="inputPasswordConfirm" class="form-control required " type="password" placeholder="Confirm Password" required>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Address <small>*</small></label>
                        <textarea name="txtaddress" class="form-control required " type="text" required></textarea>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Birth Date <small>*</small></label>
                        <input name="txtbdate" class="form-control required " type="date" placeholder="Enter Birth date" required>
						<span id="bdatemsg" class="text-danger font-weight-bold"> </span>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Email Id <small>*</small></label>
                        <input name="txtemail" class="form-control required " type="email" id="bdate" placeholder="Enter Email Id" required>
                        </div>
                        </div>
                </div>
				<div class="row" style="padding-top:20px;">
                        <div class="col-md-12" align="center">
                            <div class="form-group">
								<input name="form_botcheck" class="form-control" type="hidden" value="" />
								<input type="submit" name="submitsignup" class="btn btn-primary" value="Register">
							</div>
                        </div>
				</div>
                    </form>
            </div>
        </div>
    </div>
</div>
<?php
include('./footer.php');
?>
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