<?php
$login_session="" ;
$url="";
$status="";
//include('lock.php');
include ("conn.php");

if (isset($_POST['submitbystatus'])){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$comstatus = test_input($_POST["txtcomstatus"]);
		$sql = "SELECT * FROM complaints c, puser p, catagory ct WHERE ct.cid=c.cid AND p.puid=c.puid AND comstatus='$comstatus'  ORDER BY FIELD(priority,'High','Medium','Low')";
	}
}
else if (isset($_POST['submitbycat'])){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$cid = test_input($_POST["txtcat"]);
		$sql = "SELECT * FROM complaints c, puser p, catagory ct WHERE ct.cid=c.cid AND p.puid=c.puid AND c.cid='$cid'  ORDER BY FIELD(priority,'High','Medium','Low')";
	}
}
else if (isset($_POST['submitbyaddress'])){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$city = test_input($_POST["city"]);
		$sql = "SELECT * FROM complaints c, puser p, catagory ct WHERE ct.cid=c.cid AND p.puid=c.puid AND c.city='$city'  ORDER BY FIELD(priority,'High','Medium','Low')";
	}
}
else{
	$sql = "SELECT * FROM complaints c, puser p, catagory ct WHERE ct.cid=c.cid AND p.puid=c.puid AND comstatus='Pending'  ORDER BY FIELD(priority,'High','Medium','Low')";
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
<head>
<title> Complaints  </title>
<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./resources/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<script src="./resources/bootstrap-3.3.6-dist/js/jquery.min.js"></script>
<script src="./resources/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
</head>
<body style="background-color:#ffeaea;">
<?php
include('./header.php');
?>
<div class="fluid-container" style="margin-top:20px">
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-info" style="border-color: #10191d;">
		<div class="panel-heading" align="center" style="color: #ffffff;background-color: #10191d;border-color: #10191d;">Search Marketing Person  </div>
		<div class="panel-body">
			<form class="form-inline" data-toggle="validator" name="sub" id="sub" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="col-md-4" >
					<div class="form-group">
						<select class="form-control" name="txtcomstatus">
						<option value="">Select Status</option>
						<option value="Solved">Solved</option>
						<option value="Unsolved">Unsolved</option>
						<option value="Pending">Pending</option>
						<option value="Closed">Closed</option>
						</select>
					</div>
					<div class="form-group" align="center">
					<button type="submit" class="btn btn-info" id ="submitbystatus" name="submitbystatus">Search By Status</button>
					</div>
				</div>
				<div class="col-md-4" >
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
					<div class="form-group" align="center">
					<button type="submit" class="btn btn-info auto" id ="submitbycat" name="submitbycat">Search By Category</button>
					</div>
				</div>
				<div class="col-md-4" >
					<div class="form-group">
							<select class="form-control" id="city" name="city">
							<option value="">Select City</option>
							<?php
							$query1 = "SELECT city from complaints GROUP BY city";
							$result = $conn->query($query1);
								while($row = $result->fetch_assoc()) {
								echo "<option value='".$row['city']."'>".$row['city']."</option>";
								}
							?>
							</select>
                        </div>
					<div class="form-group" align="center">
					<button type="submit" class="btn btn-info" id ="submitbyaddress" name="submitbyaddress">Search By City</button>
					</div>
				</div>
			</form>
	</div> <!-- Close panel Body -->
	</div> <!-- Close Panel -->
	</div> <!-- Close Col -->
</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-info" style="border-color: #10191d;">
    <div class="panel-heading" align="center"style="color: #ffffff;background-color: #10191d;border-color: #10191d;">Complaints/ Invitation Details</div>
    <div class="panel-body">
        <div class='table-responsive'>
    <?php
    include('./conn.php');
    error_reporting(E_ALL);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>
        <thead>
            <tr>
            <th>Uploaded Doc</th>
            <th>Citizen Name</th>
            <th>Category</th>
            <th>Complaint Title</th>
            <th>Compaint's Description</th>
            <th>Expected Time</th>
            <th>Priority</th>
            <th>Replay</th>
            <th>Address</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>";
        while($row = $result->fetch_assoc()) {
            echo"<tr>";
            echo "<td><a href='../".$row['imgpath']."' target='self'>Click Here</a></td>";
            echo "<td>".$row['puname']."</td>";
            echo "<td>".$row['cat_name']."</td>";
            echo "<td>".$row['comtitle']."</td>";
            echo "<td>".$row['comdesc']."</td>";
            echo "<td>".$row['exptime']."</td>";
            echo "<td>".$row['priority']."</td>";
            echo "<td>".$row['reply']."</td>";
			echo "<td>".$row['caddress']."</td>";
            echo "<td>".$row['comstatus']."</td>";
            echo "<td>".$row['comdate']."</td>";
            echo  "<td> <a href='managecomp.php?comid=".$row['comid']."'> <button type='submit' class='btn btn-default btn-sm' name ='btndel' id='btndel'> <span class='glyphicon glyphicon-ok'></span> Manage</button></a></td>";
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
    </div><!-- Close panel Body -->
</div> <!-- Close Panel -->
</div>
</div> <!-- Close Row -->
</div> <!-- Close Container -->
<?php include('footer.php');?>
</body>
</html>