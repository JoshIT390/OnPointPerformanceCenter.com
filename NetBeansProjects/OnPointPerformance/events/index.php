<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>On Point Performance Center</title>
        <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
        
        <!-- FLEXSLIDER IMPORTS -->
        <link rel="stylesheet" href="./slideshow.css" type="text/css">
        <!-- END FLEXSLIDER IMPORTS -->
    </head>
    <body>
        <div class="wrap">
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                       <a href="../"> <img src="../assets/images/Logo.png" style="width:220px; height:50px;float: left;"> </a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="../">Home</a></li>
                            <li><a href="../about/">About Us</a></li>
                            <li><a href="../apply/">Apply</a></li>
                            <li class="active"><a href=><span class="sr-only">(current)</span>Events</a></li>
                            <li><a href="../merchandise/">Merchandise</a></li>
                            <li><a href="../contact/">Contact Us</a></li>
                        </ul>    
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                                if (isset($_SESSION['member_username'])){
                                    echo '<li><a href="../members">' . $_SESSION['member_username'] . '</a></li>';
                                    echo '<li><a href="../login/logout.php">Logout</a></li>';
                                }
                                if (isset($_SESSION['admin_username'])){
                                    echo '<li><a href="../admin">' . $_SESSION['admin_username'] . '</a></li>';
                                    echo '<li><a href="../login/logout.php">Logout</a></li>';                            
                                }
                                elseif (!isset($_SESSION['member_username']) && !isset($_SESSION['admin_username'])) {
                                    echo '<li><a href="../login">Log In</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                    <a> <img src="../assets/images/red slash.png" style="width:100%; height:15px;float: left;"> </a>
                </div>
            </nav>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

            <!-- FLEXSLIDER -->
            <div class="container">
                <div id="captioned-gallery" >
                    <figure class="slider">
                        <figure>
                            <img src="../assets/images/eventsImage.jpg" style="height:auto;" />
                            <figcaption>
                                <h1>Upcoming Events</h1>
                                <h4>Come join us for these special events</h4>
                            </figcaption>
                        </figure>
                    </figure>
                </div>
            </div>
            <!-- END FLEXSLIDER -->


            <div class="container">
                <p class='linez' style="padding-bottom:20px;padding-top: 20px;font-size: 12pt;">On Point Performance Center hosts seminars throughout the year. 
                    For these seminars, we will bring in subject matter experts that will provide knowledge and training on topics such as strength training, functional medicine, nutrition for the athlete, active shooter training, self-defense and more. 
                    The seminars are usually open to the public and will often feature presenters who are well-known in the national and international physical training and tactical communities.</p>
            <!--<div class="jumbotron" style="text-align: center;">
                    <h1>Upcoming Events</h1>
                    <p>Come join us.</p>
                </div>
            -->
                <?php include 'events.php'; ?>
            </div>
        </div>
        <?php include ("../assets/virtual/footer.inc"); ?>
    </body>
</html>
