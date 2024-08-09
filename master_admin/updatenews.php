<?php
$login_session="" ;
 $url="";
 $status="";
 $alert="";
 $show="";
 $error="";
 //include('lock.php');
include ("conn.php");
if (isset($_POST['submit'])){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$ptitle = test_input($_POST["txttitle"]);
		$sql="SELECT * FROM post WHERE ptitle='$ptitle' AND pstatus=1";		
		$result = $conn->query($sql);
		if($result->num_rows>0){
				$error="You have already posted News!";
				$show="display:show;";
				$alert="alert alert-danger";
		}
		else if(!isset($_FILES['userfile']))
		{
			$error="Please Select File To Upload!";
			$show="display:show;";
			$alert="alert alert-danger";
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
     $ptitle = test_input($_POST["txttitle"]);
     $pdesc = test_input($_POST["txtdesc"]);
     $pdate = test_input($_POST["txtpdate"]);
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
					$sql = "INSERT INTO post (ptitle, pdesc, pimgpath, pdate, pstatus, uid)
					VALUES ('$ptitle', '$pdesc', '$imgpath', '$pdate', '$status', $user_id)";		  
					include('./conn.php');
                    if($conn->query($sql)===TRUE){
                    $msg="<p>Post Is Submitted successfully!</p>";
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
 <title> Update News and Updates</title>
  <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

 <link rel="stylesheet" href="./resources/bootstrap-3.3.6-dist/css/bootstrap.min.css">
  <script src="./resources/bootstrap-3.3.6-dist/js/jquery.min.js"></script>
  <script src="./resources/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <script src="./sss.js"></script>
</head>
<body style="background-color:#ffeaea;">
<?php
include('./header.php');
?>




<div class="container" style="margin-top:20px">
<div class="row">

  <div class = "col-md-4">
<!--<div class="alert alert-success alert-sm" role="alert" id="signalert" style="display:show;">Well done! You successfully Signup!</div> -->
<div class="panel panel-info" style="border-color: #10191d;">
      <div class="panel-heading" align="center" style="color: #ffffff;background-color: #10191d;border-color: #10191d;">Update Live News </div>
      <div class="panel-body">
<div class="<?php echo $alert; ?>" role="alert" style="<?php echo $show; ?>"><?php echo $error; ?></div>
 <form enctype="multipart/form-data" data-toggle="validator" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-group">
   <label class="control-label">Enter News Tilte (Limit 100 Words)</label>
    <input class="form-control" type="text" id="txttitle" name= "txttitle" placeholder="Enter News Title" required>
  </div>
   <div class="form-group">
   <label class="control-label">Enter News Description (Limit 800 words)</label>
    <textarea class="form-control" type="text" id="txtdesc" name= "txtdesc"  rows="4" required> </textarea>
  </div>
  
   <div class="form-group">
    <label class="control-label">Enter Date (Format: yyyy-mm-dd)</label>
    <input class="form-control" type="date" id="txtpdate" name= "txtpdate" placeholder="Select Date" required>
  </div>
  <div class="form-group">
    <label class="control-label">Upload Photo</label>
     <input type="file" class="form-control" id="userfile" name="userfile" placeholder="File" required>
  </div>
  <div class="form-group" align="center">
    <button type="submit" class="btn btn-info" name="submit">Publish Post</button>
  </div>

</form>
</div> <!-- Close panel Body -->

</div> <!-- Close Panel -->

</div> <!-- Close Col -->

<div class="col-md-8">

<div class="panel panel-info" style="border-color: #10191d;">
      <div class="panel-heading" align="center" style="color: #ffffff;background-color: #10191d;border-color: #10191d;">News Details</div>
      <div class="panel-body">
        <div class='table-responsive'>
      <?php
      include('./conn.php');
      error_reporting(E_ALL);
      $sql = "SELECT * FROM post WHERE pstatus=1 ORDER BY pid DESC";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        // output data of each row
       
          echo "<table class='table table-striped'>
          <thead>
            <tr>
              <th>Image</th>
              <th>News Title</th>
              <th>News Description</th>
              <th>Event Date </th>
  
           </tr>
          </thead>


          <tbody>";
          while($row = $result->fetch_assoc()) {
            
           echo"<tr>";
             
              
              echo "<td><img src='".$row['pimgpath']."' height='150' width='150'/></td>";
              echo "<td>".$row['ptitle']."</td>";
              echo "<td>".$row['pdesc']."</td>";
              echo "<td>".$row['pdate']."</td>";

             
              echo  "<td> <button type='submit' class='btn btn-default btn-sm' onclick='delete_post(".$row['pid'].")' name ='btndel' id='btndel'> <span class='glyphicon glyphicon-trash'></span> Delete</button></td>";
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


<?php include('./footer.php');?>
</body>
</html>