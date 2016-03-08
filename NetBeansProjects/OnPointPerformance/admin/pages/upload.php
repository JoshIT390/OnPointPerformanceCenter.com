<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
    
    // Redirects to login page if haven't logged in or trying to access page as admin
    if (isset($_SESSION['member_username'])){
        unset($_SESSION['member_username']);
    }
    elseif (!isset($_SESSION['admin_username'])) {
        header("Location: ../../login");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OPPC Admin Page</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    
    <link href="inline.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">On Point Performance Administration Page</a>
            </div>
            
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../../login/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            
                        </li>
                        <li>
                            <a href="./"><i class="fa fa-dashboard fa-fw"></i> Member Management</a>
                        </li>
                        <li>
                            <a href="./calendar.php"><i class="fa fa-table fa-fw"></i> Manage Calendar</a>
                        </li>
                        <li>
                            <a href="./email.php"><i class="fa fa-edit fa-fw"></i> Email Members</a>
                        </li>
						<li>
                            <a href="./applications.php"><i class="fa fa-edit fa-fw"></i> View Applications</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Website Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="./bannerm.php">Front Page Banner</a>
                                </li>
                                <li>
                                    <a href="./announcementsm.php">Front Page Announcements</a>
                                </li>
								<li>
                                    <a href="./formsm.php">Forms</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Forms</h1>
						<p>
                                                    <?php
                                                    $target_dir = "../../forms/";
                                                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                    $uploadOk = 1;
                                                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                                    // Check if file already exists
                                                    if (file_exists($target_file)) {
                                                        echo "Sorry, file already exists.";
                                                        $uploadOk = 0;
                                                    }
                                                    // Allow certain file formats
                                                    if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
                                                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                                        $uploadOk = 0;
                                                    }
                                                    // Check if $uploadOk is set to 0 by an error
                                                    if ($uploadOk == 0) {
                                                        echo "Sorry, your file was not uploaded.";
                                                    // if everything is ok, try to upload file
                                                    } else {
                                                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                                            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded and can now be accessed from the Forms Page.";
                                                        } else {
                                                            echo "Sorry, there was an error uploading your file.";
                                                        }
                                                    }
                                                        $filename = $_POST['filename'];
							$servername = "mysql.dnguyen94.com";
							$username = "ad_victorium";
							$password = "MT8AlJAM";
							$database = "onpoint_performance_center_lower";

							// Create connection
							$conn = mysqli_connect($servername, $username, $password, $database);

							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}
                                                        $query = "INSERT INTO FORMS (NAME, PDF) VALUES ('$filename', '". basename( $_FILES["fileToUpload"]["name"]) ."');";
							$result = mysqli_query($conn, $query );
                                                    ?>
                                                </p>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>