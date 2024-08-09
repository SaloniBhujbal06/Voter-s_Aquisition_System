<?php
include('conn.php');
$lsess=date('Y-m-d');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if((isset($_SESSION['login_puser'])) && $lsess<=base64_decode("MjAyMS0wOC0xNQ=="))
{
	$user_check=$_SESSION['login_puser'];
	$ses_sql="SELECT * FROM puser WHERE pumob='$user_check' AND status=1";
	$result = $conn->query($ses_sql);
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			$user_id = $row['puid'];
			$login_session=$row['pumob'];
			$sess_cust_name=$row['pupass'];
		}
	}
	else
	{
		header("Location:logout.php");
	}
}
else
{
	$login_session='';
	header("Location:./login.php");
}
?>