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
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" type="image/x-icon">
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
                <a class="navbar-brand" href="index.php">On Point Performance Administration Page</a>
            </div>
            
             <!-- /.navbar-header -->
             
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="./profile/"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="../../"><i class="fa fa-home fa-fw"></i> Public Website</a>
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
                            <a href="./index.php"><i class="fa fa-users fa-fw"></i> Member Management</a>
                        </li>
                        <li>
                            <a href="./adminslist.php"><i class="fa fa-users fa-fw"></i> Admin Management</a>
                        </li>
                        <li>
                            <a href="./calendar.php"><i class="fa fa-calendar fa-fw"></i> Manage Calendar</a>
                        </li>
                        <li>
                            <a href="./email.php"><i class="fa fa-envelope-o fa-fw"></i> Email Members</a>
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
                        <?php
                            include "../../databaseInfo.php";
                        
                            define("TARGET_DIR", "../../forms/");

                            if (!empty($_POST["formName"]) && !empty($_FILES["fileUpload"]["name"])) {
                                if (!file_exists(TARGET_DIR . $_FILES["fileUpload"]["name"])) {
                                    if (checkExtension(pathinfo($_FILES["fileUpload"]["name"], PATHINFO_EXTENSION))) {
                                        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], TARGET_DIR . $_FILES["fileUpload"]["name"])) {
                                            if (submitInformation(trim($_POST["formName"]), $_FILES["fileUpload"]["name"])) {
                                                displayForm("success", "");
                                            }
                                            else {
                                                unlink(TARGET_DIR . basename( $_FILES["fileUpload"]["name"]));
                                                displayForm("fail_submit", $_POST["formName"]);
                                            }
                                        }
                                        else {
                                            displayForm("fail_upload", $_POST["formName"]);
                                        }
                                    }
                                    else {
                                        displayForm("fail_file_ext", $_POST["formName"]);
                                    }
                                }
                                else {
                                    displayForm("fail_file_exist", $_POST["formName"]);
                                }
                            }
                            else {
                                displayForm("", "");
                            }
                            
                            function checkExtension($fileExtension) {
                                if (strcasecmp($fileExtension, "doc") != 0) {
                                    if (strcasecmp($fileExtension, "docx") != 0) {
                                        if (strcasecmp($fileExtension, "pdf") != 0) {
                                            return FALSE;
                                        }
                                        else {
                                            return TRUE;
                                        }
                                    }
                                    else {
                                        return TRUE;
                                    }
                                }
                                else {
                                    return TRUE;
                                }
                            }
                        
                            function submitInformation($submittedFormName, $submittedFilePath) {                                
                                try {
                                    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
                                    // Exceptions fire when occur
                                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $announcementSubmit = $connection->prepare(
                                            'INSERT INTO ' . FORMS_TABLE . ' (NAME, PDF) 
                                            VALUES (:submittedFormName, :submittedFilePath)');

                                    $announcementSubmit->execute(array(
                                        ':submittedFormName' => $submittedFormName,
                                        ':submittedFilePath' => $submittedFilePath,
                                    ));
                                }

                                // Script halts and throws error if exception is caught
                                catch(PDOException $e) {
                                    echo "
                                    <div>
                                        Error: " . $e->getMessage() . 
                                    "</div>";

                                    return FALSE;
                                }

                                return TRUE;
                            }
                            
                            function displayForm($status, $submittedFormName) {
                                $notice = "";

                                if ($status == "success") {
                                    $notice = 
                                        "<div class='alert alert-success alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            Form information and file successfully submitted.
                                        </div>";
                                }
                                elseif ($status == "fail_file_exist") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            The uploaded file already exists. Please choose a different file or rename your file and try again.
                                        </div>";
                                }
                                elseif ($status == "fail_file_ext") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            The uploaded file is not a supported format. Please choose a different file or convert your file to the below requirements and try again.
                                        </div>";
                                }
                                elseif ($status == "fail_upload") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            There was a problem with the file upload. The form information was not submitted. Please try again.
                                        </div>";
                                }
                                elseif ($status == "fail_submit") {
                                    $notice = 
                                        "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            There was a problem submitting the form. Please try again.
                                        </div>";
                                }

                                echo 
                                    '<div>  
                                        <h3> Add Form</h3>' . 
                                        $notice . '
                                        <form action="addform.php" method="post" enctype="multipart/form-data">
                                            Form Name: <input type="text" name="formName" value="' . htmlentities($submittedFormName, ENT_QUOTES) . '" required />
                                            <hr />
                                            <div>
                                                <h4>Form Upload</h4>
                                                Requirements:
                                                <ul>
                                                    <li>DOC, DOCX, or PDF format</li>
                                                    <li>Not already uploaded</li><br />
                                                </ul>  
                                                <input type="file" name="fileUpload" id="imageUpload" required />
                                            </div>
                                            <hr />
                                            <input type="submit" value="Submit" class="btn btn-default" />
                                        </form>
                                    </div>';
                            }
                        ?>
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
