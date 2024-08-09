<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"> Master-Admin(Voter Acquisition) </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="master_admin/dashboard.php">Home <span class="sr-only">(current)</span></a></li>
		  <li><a href="master_admin/complaints.php">Manage Complaints</a></li>
          <li><a href="master_admin/todays_birthday.php">Today's Birthday</a></li>
		  <li><a href="master_admin/updatenews.php">Update News</a></li>
		  <li><a href="master_admin/updatecatagory.php">Add Category</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <?php if($login_session)
        {
            $status="Welcome ".$login_session;
            $url="http:./logout.php";
            $status1="Logout";
        }
        else
        {
            $status="Welcome Guest";
            $url="http:./login.php";
            $status1="Login";
        }
          ?>
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $status; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
		  <li><a href="./signup.php">Add User</a></li>
          <li><a href="./changepass.php">Change Password</a></li>
            <li role="separator" class="divider"></li>
          
            <li><a href="<?php echo  $url; ?>"><?php echo $status1; ?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>