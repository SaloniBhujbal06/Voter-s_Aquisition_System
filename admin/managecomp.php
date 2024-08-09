<?php
$login_session="" ;
 $url="";
 $status="";
 //include('lock.php');
include ("conn.php");
  $error="";
  $show="display:none;";
  $alert="";
  if (isset($_GET['comid'])) {	
	$comid=$_GET['comid'];
    $sql1 = "SELECT * FROM complaints c, puser p, catagory ct WHERE ct.cid=c.cid AND p.puid=c.puid AND c.comid=$comid";
    $result = $conn->query($sql1);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
			$puname = $row['puname'];
			$pumob = $row['pumob'];
			$cat_name = $row['cat_name'];
			$comtitle = $row['comtitle'];
			$comdesc = $row['comdesc'];
			$exptime = $row['exptime'];    
			$priority = $row['priority']; 
			$comdate = $row['comdate']; 	
		}
	}
}
if (isset($_POST['sendreply'])){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $comid= test_input($_POST["txtcomid"]);
     $pumob = test_input($_POST["txtpumob"]);
     $exptime = test_input($_POST["txtexptime"]);
     $priority = test_input($_POST["txtpriority"]);
     $reply = test_input($_POST["txtreply"]);
     $comstatus = test_input($_POST["txtcomstatus"]);
	 $sql1="SELECT * FROM complaints WHERE comid=$comid and reply='$reply' and comstatus!='Pending'";
     $result = $conn->query($sql1);
      if ($result->num_rows > 0){
        $error="Reply Is Already Placed!";
        $show="display:show;";
        $alert="alert alert-danger";
	  }
	  else{
          $sql = "UPDATE complaints SET priority='$priority', exptime='$exptime', reply='$reply', comstatus='$comstatus' WHERE comid=$comid";
          if ($conn->query($sql) === TRUE) {
          $error=" Reply Is Sent successfully!";
          $show="display:show;";
          $alert="alert alert-success";
          }
          else{
          $error="Your Process is invalid";
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
<head>
 <title> Manage Complaints  </title>
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
<div class="container" style="margin-top:20px">
<div class="row">
  <div class = "col-md-3"></div>
  <div class = "col-md-6">
<!--<div class="alert alert-success alert-sm" role="alert" id="signalert" style="display:show;">Well done! You successfully Signup!</div> -->
<div class="panel panel-info" style="border-color: #10191d;">
      <div class="panel-heading" align="center" style="color: #ffffff;background-color: #10191d;border-color: #10191d;">Manage Compaints </div>
      <div class="panel-body">
	  <div class="<?php echo $alert; ?>" role="alert" style="<?php echo $show; ?>"><?php echo $error; ?></div>
 <form enctype="multipart/form-data" data-toggle="validator" role="form" method="post" action="./managecomp.php?comid=<?php echo $comid;?>">
  <div class="form-group">
   <label class="control-label">Citizen Name</label>
    <input class="form-control" type="text" name= "txtpname" value="<?php echo $puname; ?>" placeholder="Enter Name" readonly>
    <input class="form-control" type="hidden" name= "txtcomid" value="<?php echo $comid; ?>" placeholder="Enter Name" readonly>
  </div>  
    <div class="form-group">
   <label class="control-label">Mobile Number</label>
    <input class="form-control" type="text" id="txtpumob" name= "txtpumob" value="<?php echo $pumob; ?>" placeholder="Enter Mobile Number" readonly>
  </div>
  <div class="form-group">
   <label class="control-label">Category</label>
    <input class="form-control" type="text" id="tx" name= "tx" value="<?php echo $cat_name; ?>" readonly>
  </div>
  <div class="form-group">
   <label class="control-label">Compaint Title</label>
    <input class="form-control" type="text" id="tx" name= "tx" value="<?php echo $comtitle; ?>" readonly>
  </div>
  <div class="form-group">
   <label class="control-label">Compaint Description</label>
    <input class="form-control" type="text" id="tx" name= "tx" value="<?php echo $comdesc; ?>" readonly>
  </div>
  <div class="form-group">
   <label class="control-label">Compaint Description</label>
    <textarea class="form-control" type="text" id="tx" name= "tx" readonly><?php echo $comdesc; ?></textarea>
  </div>
  <div class="form-group">
   <label class="control-label">Expected Time </label>
    <input class="form-control" type="text" id="tx" name= "txtexptime" value="<?php echo $exptime; ?>">
  </div>
  <div class="form-group">
   <label class="control-label">Priority</label>
	<select class="form-control" name="txtpriority" required>
	<option value="">Select Priority</option>
	<option value="High">High</option>
	<option value="Medium">Medium</option>
	<option value="Low">Low</option>
	</select>
  </div>
  <div class="form-group">
   <label class="control-label">Reply or Update</label>
    <textarea class="form-control" type="text" id="tx" rows="4" name= "txtreply" required></textarea>
  </div>
  <div class="form-group">
   <label class="control-label">Complaints Stastus</label>
    <select class="form-control" name="txtcomstatus" required>
	<option value="">Select Status</option>
	<option value="Solved">Solved</option>
	<option value="Unsolved">Unsolved</option>
	<option value="Pending">Pending</option>
	<option value="Closed">Closed</option>
	</select>
  </div>
  <div class="form-group" align="center">
    <button type="submit" class="btn btn-info" name="sendreply">Send Reply</button>
  </div>
</form>
</div> <!-- Close panel Body -->
</div> <!-- Close Panel -->
</div> <!-- Close Col -->
</div> <!-- Close Container -->
<?php include('footer.php');?>
</body>
</html>