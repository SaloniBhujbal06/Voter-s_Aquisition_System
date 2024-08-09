<?php
$now=date('Y-m-d');
//include('lock.php');
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from adsspirits.com/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jan 2018 07:38:33 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Dashboard</title>
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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
		<?php
		$sql = "SELECT * FROM post WHERE pstatus=1 Order by pid DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            echo"<div class='col-md-6 col-xs-12' style='padding:10px;'>
				<div class='well'>
						<div style='border:ridge ;padding:10px;background-color:#f5f3ec;'>
						<img src='./master_admin/".$row['pimgpath']."' style='width:100%'/>
						<h4>".$row['ptitle']."</h4>
						<p>".$row['pdesc']."</p>
						<p>Date: ".$row['pdate']."</p>
						</div>
				</div>
            </div>";
		}
	}
?>
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