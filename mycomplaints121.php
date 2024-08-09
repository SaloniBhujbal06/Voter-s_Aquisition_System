<?php
$error="";
$show="display:none;";
$alert="";
include("conn.php");
//include("lock.php");
if (isset($_POST['submitcomp']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$comtitle=test_input($_POST['txttitle']);
		$cid=test_input($_POST['txtcat']);
		$comdesc=test_input($_POST['txtdesc']);
		$exptime=test_input($_POST['txtexptime']);
		$priority=test_input($_POST['txtpriority']);
		$sql="SELECT comstatus FROM complaints WHERE comstatus='Pending' AND comtitle='$comtitle' AND puid=$user_id";
		$result = $conn->query($sql);
		if($result->num_rows>0){
				$error="You have already posted complaint!";
				$show="display:show;";
				$alert="alert alert-danger";
		}
		else{
			$sql = "INSERT INTO complaints ( comtitle, comdesc, priority, exptime, comdate, comstatus, cid, puid )
			VALUES ('$comtitle', '$comdesc', '$priority', '$exptime', @now := now(), 'Pending', $cid, $user_id )";
			if ($conn->query($sql) === TRUE) {
			$error="Complaint Is Posted successfully! Thank You!";
			$show="display:show;";
			$alert="alert alert-success";
			}
			else{
			$error="Your signup is invalid";
			$show="display:show;";
			$alert="alert alert-danger";
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
   <title>My Complaint</title>
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
    <div class="fluid-container">
  
        <br>
        <div class="row">
            <div class="col-md-12 col-xs-12 well" style="padding:20px;">
			<h1 class="text-center contactHead gotham">My Complaint</h1>
                <div class="row">
<div class='table-responsive'>
      <?php
      include('./conn.php');
      error_reporting(E_ALL); 
	$sql = "SELECT * FROM complaints c, puser p, catagory ct WHERE ct.cid=c.cid AND p.puid=c.puid AND p.puid=$user_id";	  
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          echo "<table class='table table-striped'>
          <thead>
            <tr>
              <th>Citizen Name</th>
              <th>Category</th>
              <th>Complaint Title</th>
              <th>Compaint's Description</th>
              <th>Expected Time</th>
              <th>Priority</th>
              <th>Reply</th>
              <th>Status</th>
              <th>Date</th>
           </tr>
          </thead>
          <tbody>";
          while($row = $result->fetch_assoc()) {
           echo"<tr>";
              echo "<td>".$row['puname']."</td>";
              echo "<td>".$row['cat_name']."</td>";
              echo "<td>".$row['comtitle']."</td>";
              echo "<td>".$row['comdesc']."</td>";
              echo "<td>".$row['exptime']."</td>";
              echo "<td>".$row['priority']."</td>";
              echo "<td>".$row['reply']."</td>";
              echo "<td>".$row['comstatus']."</td>";
              echo "<td>".$row['comdate']."</td>";
              //echo  "<td> <a href='managecomp.php?comid=".$row['comid']."'> <button type='submit' class='btn btn-default btn-sm' name ='btndel' id='btndel'> <span class='glyphicon glyphicon-ok'></span> Manage</button></a></td>";
           echo "</tr>";
         }
          echo"</tbody>
      </table>";
        }  
        else {
         echo "0 results";
        }
        $conn->close();
        ?>
      </div>
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