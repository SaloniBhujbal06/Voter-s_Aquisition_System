<?php
$login_session="" ;
$url="";
$status="";
include('conn.php');
//include('./lock.php');

?>
<?php
$today=date("Y-m-d");
$remcreditamt=0;
//total staff
$sql = "SELECT * FROM puser WHERE status=1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$bdcount=0;
	while($row = $result->fetch_assoc()) {
			$bdate=$row['bdate'];
			$d=date_parse_from_format("Y-m-d",$bdate);
			$m=$d["month"];
			$m1=date("m");
			$d=$d["day"];
			$d1=date("d");
			if($m==$m1 && $d==$d1){
				$bdcount++;
			}
	}
}
//Total Topstudents
$sql = "SELECT * FROM puser WHERE status = 1";
$query = $conn->query($sql);
$member = $query->num_rows;
//Total Topstudents
$sql = "SELECT * FROM complaints WHERE comstatus='Solved'";
$query = $conn->query($sql);
$totalcomplaints = $query->num_rows;
//todays
$sql = "SELECT * FROM complaints WHERE comdate='$today'";
$query = $conn->query($sql);
$todayscomplaints = $query->num_rows;
//Total gallery Photos
$sql = "SELECT * FROM post WHERE pstatus = 1";
$query = $conn->query($sql);
$totalpost = $query->num_rows;
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Voter Acquitision</title>
<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="./resources/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<script src="./resources/bootstrap-3.3.6-dist/js/jquery.min.js"></script>
<script src="./resources/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

<script src="./activemenu.js"></script>
<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
    m = date.getMonth(),
    y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'title'
        },
        buttonText: {
            today: 'today',
            month: 'month'
        }
        });


    });
</script>

<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
	.card{
	width: 100%;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	text-align: center;
	}
	.cardHeader{
		background-color: #4CAF50;
		color: white;
		padding: 10px;
		font-size: 40px;
	}
	.cardContainer{
		padding: 10px;
	}
		
</style>
</head>
<body id="dashboard" style="background-color:#ffeaea;">
<?php
include('./header.php');
?>

 <div class="container" style="margin-top: 10px">
<div class="row">

	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading" >
				
				<a href="#" style="text-decoration:none;color:black;">
			Member
					<span class="badge pull pull-right"><?php echo $member; ?></span>
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
		<div class="col-md-4">
			<div class="panel panel-info">
			<div class="panel-heading">
				<a href="#" style="text-decoration:none;color:black;">
					Post
					<span class="badge pull pull-right"><?php echo $totalpost ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<a href="#" style="text-decoration:none;color:black;">
					Solved Complents
					<span class="badge pull pull-right"><?php echo $totalcomplaints; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="card">
		<div class="cardHeader" >
		<h1><?php echo date('d'); ?></h1>
		</div>

		<div class="cardContainer">
		<p><?php echo date('l') .' '.date('d').', '.date('Y'); ?></p>
		</div>
		</div>
		<br/>

		<div class="card">
		<a href="#">
		<div class="cardHeader" style="background-color:#245580;">
		<h1><?php echo $bdcount; ?></h1>
		</div>

		<div class="cardContainer">
		<p>  Today's Total Birthday </p>
		</div></a>
		</div>
		<br/>
		
		<div class="card">
		<a href="#">
		<div class="cardHeader" style="background-color:#623b65;">
		<h1><?php echo $todayscomplaints; ?></h1>
		</div>

		<div class="cardContainer">
		<p> Today's Total Complents</p>
		</div>
		</a>
		</div>

	</div>

	<div class="col-md-8">
		<div class="panel panel-default" style="border-color: #10191d;">
			<div class="panel-heading" style="color: #ffffff;background-color: #10191d;border-color: #10191d;"> <i class="glyphicon glyphicon-calendar"></i> Voter Acquisition System</div>
			<div class="panel-body">
				<img src="./images/dashboard.jpg" class="img-responsive"/>
			</div>
		</div>
		
	</div>

	
</div> <!--/row-->

</div> <!-- Close Container -->
<?php include('./footer.php');?>
</body>
</html>