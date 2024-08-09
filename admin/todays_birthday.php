<?php
$login_session="" ;
 $url="";
 $status="";
//include('lock.php');
include('sms.php');

?>
<?php
  //session_start();
  
// import connection file
include ("conn.php");

// define variables and set to empty values
   $uname = "";
   $pass = "";
   $currdate= ""; 
   $status=null;
   $errorc="";
  $showc="display:none;";
   $errorv="";
  $showv="display:none;";
  $alertc="";
  $alertv="";

  $error="";
  $show="display:none;";
  $alert="";
	if (isset($_GET['error'])) {
      $error=$_GET['error'];
      $show=$_GET['show'];
      $alert=$_GET['alert'];
    }
//**************************************************************************************************************************
if (isset($_GET['delalert'])) {
  $errorv="Alumni Deleted successfully!";
        $showv="display:show;";
        $alertv="alert alert-success";
  }
  if (isset($_GET['delfail'])) {
    $errorc="Password Invalid ! Record Is Not Deleted Try Again !";
    //$errorc='<b>'.$cname.'</b>'." "."Customer Name Is Not Exist!";
    $showc="display:show;";
    $alertc="alert alert-danger";
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
 <title>Today's Birthday  </title>
  <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

 <link rel="stylesheet" href="./resources/bootstrap-3.3.6-dist/css/bootstrap.min.css">
  <script src="./resources/bootstrap-3.3.6-dist/js/jquery.min.js"></script>
  <script src="./resources/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
  
       <script type="text/javascript">
  function printbill(){
    //alert("hiiiiiiiiiiii");
    var prtContent = document.getElementById("invoice");
    var WinPrint = window.open('Todays Cases', 'Todays Cases', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
   }
  </script>
  
  
  
</head>
<body style="background-color:#ffeaea;">
<?php
include('./header.php');
?>




<div class="container" style="margin-top:20px">
<div class="row">
    <div class="col-md-12">
      <div align="center" class="<?php echo $alertc; ?>" role="alert" style="<?php echo $showc; ?>"><?php echo $errorc; ?></div>
      <div align="center" class="<?php echo $alertv; ?>" role="alert" style="<?php echo $showv; ?>"><?php echo $errorv; ?></div>
    </div> <!-- close col-->
  </div> <!--close row-->
<div class="row">
<div class="col-md-12">

<div class="panel panel-info" style="border-color: #10191d;">
      <div class="panel-heading" align="center" style="color: #ffffff;background-color: #10191d;border-color: #10191d;">Todays Birthday Details</div>
      <div class="panel-body">
        <div class='table-responsive'>
      <?php
      //include('conn.php');
      error_reporting(E_ALL);
	  $count=0;
      $sql = "SELECT * FROM puser WHERE status=1 order by puid ASC";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        // output data of each row
       
          echo "<table class='table table-striped'>
          <thead>
            <tr>
              
              <tr>
              <th>#</th>
              <th>Name</th>
              <th>Mobile Number</th>
              <th>Birth Date</th>
              <th>Address</th>
              <th>Age</th>
              </tr>
              
           </tr>
          </thead>


          <tbody>";
          while($row = $result->fetch_assoc()) {
			$currdate=date("Y/m/d");
			$bdate=$row['bdate'];
			$diff = abs(strtotime($currdate) - strtotime($row['bdate']));
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$count++;
			$d=date_parse_from_format("Y-m-d",$bdate);
			$m=$d["month"];
			$m1=date("m");
			$d=$d["day"];
			$d1=date("d");
			if($m==$m1 && $d==$d1){
					echo"<tr>";
						echo "<td>".$count."</td>";
						echo "<td>".$row['puname']."</td>";
						echo "<td>".$row['pumob']."</td>";
						echo "<td>".$row['bdate']."</td>";
						echo "<td>".$row['address']."</td>";
						echo "<td>".$years."</td>";
						
					echo "</tr>";
					$var1="Atul Benke";
					$var2="MLA Junnar Taluka";	
	//$message="Hello ".$row['puname'].",Wish you a many many happy returns of the day.From - ".$var1.",".$var2.". Zelos Infotech";
	$message="Hello ".$row['puname'].",
Wish you a many many happy returns of the day.
From - ".$var1.",
".$var2.". Zelos Infotech";
	$mobile_number=$row['pumob'];;
	$temp_id="1107162200822966250";
		sentsms($message, $mobile_number, $temp_id);
	
			}
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