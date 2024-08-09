<?php
include('conn.php');
$login_session="";
if($login_session)
{
	$status="Welcome ".$login_session;
	$url="#";
	$status1="Logout";
	$url1="http:./logout.php";
}
else
{
	$status="Welcome Guest | Signup";
	$url="http:./registration.php";
	$status1="Login";
	$url1="http:./login.php";
}
?>

<div class="header-top bg-theme-color-2 sm-text-center gotham" style="background-color:#0093dd;">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="widget no-border m-0">
              <ul class="list-inline">
                <li class="m-0 pl-10 pr-10"> <i style="color:#fff;" class="fa fa-phone"></i> <a style="color:#fff;" class="text-white" href="tel:7972978029">7972978029</a> </li>
                <li class="m-0 pl-10 pr-10"> <i style="color:#fff;" class="fa fa-envelope"></i> <a style="color:#fff;" class="text-white" href="mailto:mayurigund220@gmail.com">mayurigund220@gmail.com</a> </li>
              </ul>
            </div>
          </div>
          <div class="col-md-8">
            <div class="widget no-border m-0">
              <ul class="list-inline text-right sm-text-center">
		<li>
				<li class="text-white"><a style="color:#fff;" class="text-white" href="./master_admin/index.php" target="self">Master Admin Login</a></li>
                </li>
				<li style="color:#fff;" class="text-white">|</li>
				<li class="text-white"><a style="color:#fff;" class="text-white" href="./admin/index.php" target="self">Admin Login</a></li>
                </li>
				<li style="color:#fff;" class="text-white">|</li>			  <li>
				<li class="text-white"><a style="color:#fff;" class="text-white" href="<?php echo  $url; ?>"><?php echo $status; ?></a></li>
                </li>
				<li style="color:#fff;" class="text-white">|</li>
				<li>
				<li class="text-white"><a style="color:#fff;" class="text-white" href="<?php echo  $url1; ?>"><?php echo $status1; ?></a></li>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

<nav class="navbar navbar-default ">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" style="padding-left:50px;" href="index.php">Voter Acquisition </a> </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav nav-big navbar-right">
                <li ><a href="login.php">Home<span class="sr-only">(current)</span></a> </li>
                <li><a href="postcomplaint.php">Post Complaints</a> </li>
                <li><a href="mycomplaints.php">Complaints History </a> </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>