</head>
<body class="">
<div role="navigation" class="navbar navbar-default navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="dashboard.php" class="navbar-brand">Billing Soft</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="dashboard.php">Home</a></li>
          </ul>
         <ul class="nav navbar-nav navbar-right logged-in-button">
         <?php 
              if($_SESSION['userid']) { ?>
                <li class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Logged in <?php echo $_SESSION['user']; ?>
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Account</a></li>
                    <li><a href="logout.php?action=logout">Logout</a></li>		  
                  </ul>
                </li>
              <?php } ?>
         </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
	<div class="container-fluid" style="min-height:100vh;">