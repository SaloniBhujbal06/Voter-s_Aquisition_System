<?php
$error="";
$show="display:none;";
$alert="";
include("conn.php");
//include("lock.php");
if (isset($_POST['submitcomp'])){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$comtitle=test_input($_POST['txttitle']);
		$sql="SELECT comstatus FROM complaints WHERE comstatus='Pending' AND comtitle='$comtitle' AND puid=$user_id";
		$result = $conn->query($sql);
		if($result->num_rows>0){
				$error="You have already posted complaint!";
				$show="display:show;";
				$alert="alert alert-danger";
		}
		if(!isset($_FILES['userfile']))
		{
			$msg= postcomp();
			$error=$msg;
			$show="display:show;";
			$alert="alert alert-info";
		}
		else
		{
			try {
			$msg= upload();
			$error=$msg;
			$show="display:show;";
			$alert="alert alert-info";
			}
			catch(Exception $e) {
			echo $e->getMessage();
			$error="Sorry, could not upload file";
			$show="display:show;";
			$alert="alert alert-danger";
			}
		}
	}
}
function upload() {
	include("lock.php");
	$msg=null;
    $comtitle=test_input($_POST['txttitle']);
		$cid=test_input($_POST['txtcat']);
		$comdesc=test_input($_POST['txtdesc']);
		$exptime=test_input($_POST['txtexptime']);
		$priority=test_input($_POST['txtpriority']);
		$city=test_input($_POST['city']);
		$address=test_input($_POST['address']);
        $user_id =test_input($_POST['user_id']);
	$status=1;
	$today=date('Y-m-d');
    $maxsize = 1000000; //set to approx 300 KB
    if($_FILES['userfile']['error']==UPLOAD_ERR_OK) {
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
            if( $_FILES['userfile']['size'] < $maxsize) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {
                    $imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));
					$temp = explode(".", $_FILES["userfile"]["name"]);
					$newfilename = $user_id."_".date("Ymdhis").'.' . end($temp);
					move_uploaded_file($_FILES["userfile"]["tmp_name"],"./uploads/".$newfilename);
					$imgpath="uploads/".$newfilename;
					$sql = "INSERT INTO complaints ( comtitle, comdesc, priority, exptime, comdate, city, caddress, imgpath, comstatus, cid, puid )
			VALUES ('$comtitle', '$comdesc', '$priority', '$exptime', @now := now(), '$city', '$address', '$imgpath','Pending', $cid, $user_id )";
					include('./conn.php');
                    if($conn->query($sql)===TRUE){
                    $msg="<p>Complaint Is Submitted successfully!</p>";
                    }
                }
                else
                    $msg="<p>Uploaded file is not an image.</p>";
            }
            else {
                $msg='Photo File exceeds the Maximum File limit, Maximum File limit is '.$maxsize.' bytes, File '.$_FILES['userfile']['name'].' is '.$_FILES['userfile']['size'].' bytes';
                }
        }
        else
		{
            $msg="Photo File not uploaded successfully.";
		}
    }
    else {
        $msg= file_upload_error_message($_FILES['userfile']['error']);
		$msg=postcomp();
    }
    return $msg;
}
function file_upload_error_message($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}
function postcomp() {
	include('./lock.php');
	$msg=null;
	$comtitle=test_input($_POST['txttitle']);
	$cid=test_input($_POST['txtcat']);
	$comdesc=test_input($_POST['txtdesc']);
	$exptime=test_input($_POST['txtexptime']);
	$priority=test_input($_POST['txtpriority']);
	$city=test_input($_POST['city']);
	$address=test_input($_POST['address']);
    $user_id=test_input($_POST['user_id']);
	$status=1;
	$today=date('Y-m-d');
	$imgpath="#";
	$sql = "INSERT INTO complaints ( comtitle, comdesc, priority, exptime, comdate, city, caddress, imgpath, comstatus, cid, puid )
	VALUES ('$comtitle', '$comdesc', '$priority', '$exptime', @now := now(), '$city', '$address', '$imgpath','Pending', $cid, $user_id )";
	include('./conn.php');
	if($conn->query($sql)===TRUE){
		$msg="<p>Complaint Is Submitted successfully!</p>";
	}
	return $msg;
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
    <title>Post Complaint</title>
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
<body>
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
			<h1 class="text-center contactHead gotham">Post Complaint</h1>
			<div class="alert <?php echo $alert; ?>" role="alert" style="<?php echo $show; ?>"><?php echo $error; ?></div>
                <div class="row">
                    <form enctype="multipart/form-data" id="comp" name="comp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="col-md-12">
                            <div class="form-group">
							<select class="form-control" id="txtcat" name="txtcat">
							<option value="">Select Category</option>
							<?php
							$query1 = "SELECT cid, cat_name from catagory where status=1";
							$result = $conn->query($query1);
								while($row = $result->fetch_assoc()) {
								echo "<option value='".$row['cid']."'>".$row['cat_name']."</option>";
								}
							?>
							</select>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <label>Title <small>*</small></label>
                        <input name="txttitle" class="form-control required " type="text" placeholder="Enter Title" required>
                        </div>
                        </div>
						<div class="col-md-12">
                            <div class="form-group">
							<label class="control-label">Priority</label>
								<select class="form-control" name="txtpriority" required>
								<option value="">Select Priority</option>
								<option value="High">High</option>
								<option value="Medium">Medium</option>
								<option value="Low">Low</option>
								</select>
							</div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Expected Time <small>*</small></label>
                        <input name="txtexptime" class="form-control required " type="text" placeholder="Expected Time" required>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Complaint Description <small>*</small></label>
                        <textarea name="txtdesc" class="form-control required " type="text" required></textarea>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>City <small>*</small></label>
                        <input name="city" class="form-control required " type="text" placeholder="City" required>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Address / Location <small>*</small></label>
                        <textarea name="address" class="form-control required " type="text" required></textarea>
                        </div>
                        </div>
						<div class="col-md-12">
                        <div class="form-group">
                        <label>Upload Photo / Document <small>*</small></label>
                        <input type="file" class="form-control" id="userfile" name="userfile" placeholder="File">
                        </div>
                        </div>
                </div>
				<div class="row" style="padding-top:20px;">
                        <div class="col-md-12" align="center">
                            <div class="form-group">
								<input name="form_botcheck" class="form-control" type="hidden" value="" />
								<input type="submit" name="submitcomp" class="btn btn-primary" value="Post">
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