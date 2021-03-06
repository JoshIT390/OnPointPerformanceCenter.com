<?php
    include "../databaseInfo.php";

    // If first time logging in or inputted incorrect credentials
    if (!isset($_SESSION["admin_username"]) || !isset($_SESSION["member_username"])) {
        if (!isset($_POST["username"]) && !isset($_POST["password"])) {
            echo outputLoginForm("") . "\n";
        }
        else {
            // Saves username and password to session cookie if inputted correctly
            if (checkLogin(trim($_POST["username"]), $_POST["password"]) == "admin") {
                $_SESSION["admin_username"] = trim($_POST["username"]);
            }
            elseif (checkLogin(trim($_POST["username"]), $_POST["password"]) == "member") {
                $_SESSION["member_username"] = trim($_POST["username"]);
            }
            // Error if not inputted correctly
            else {
                echo outputLoginForm("login_error");
            }
        }   
    }
    
    // Outputs login form with username and password fields - passes to index.php
    function outputLoginForm($errorMessage) {
        $errorBanner;
        
        if ($errorMessage == "login_error") {
            $errorBanner = 
                "<div class='alert alert-dismissible alert-warning'>
                    Your username or password is incorrect. Please re-enter your credentials.
                </div>";
        }
        
        return '
            <div class="container">
                <div class="row-fluid">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <div class="well bs-component">
                            <form class="form-horizontal" method="post" action="./" id="sign_in">
                                <fieldset>
                                    <legend style="font-weight: bold; color:#ffffff">PORTAL SIGN IN</legend>' . 
                                    $errorBanner . 
                                    '<div class="form-group">
                                        <div class="col-lg-10">
                                            <input type="text" placeholder="Username" class="form-control" id="inputUsername" name="username" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAALZJREFUOBFjYKAANDQ0rGWiQD9IqzgL0BQ3IKMXiB8AcSKQ/waIrYDsKUD8Fir2pKmpSf/fv3+zgPxfzMzMSbW1tbeBbAaQC+b+//9fB4h9gOwikCAQTAPyDYHYBciuBQkANfcB+WZAbPP37992kBgIUOoFBiZGRsYkIL4ExJvZ2NhAXmFgYmLKBPLPAfFuFhaWJpAYEBQC+SeA+BDQC5UQIQpJYFgdodQLLyh0w6j20RCgUggAAEREPpKMfaEsAAAAAElFTkSuQmCC&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-10">
                                            <input type="password" placeholder="Password" class="form-control" id="inputPassword" name="password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAALZJREFUOBFjYKAANDQ0rGWiQD9IqzgL0BQ3IKMXiB8AcSKQ/waIrYDsKUD8Fir2pKmpSf/fv3+zgPxfzMzMSbW1tbeBbAaQC+b+//9fB4h9gOwikCAQTAPyDYHYBciuBQkANfcB+WZAbPP37992kBgIUOoFBiZGRsYkIL4ExJvZ2NhAXmFgYmLKBPLPAfFuFhaWJpAYEBQC+SeA+BDQC5UQIQpJYFgdodQLLyh0w6j20RCgUggAAEREPpKMfaEsAAAAAElFTkSuQmCC&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;" required />
                                        </div>
                                    </div></br>
                                    <div style="text-align: right">
                                        <div class="col-lg-10 col-lg-offset-2">                                       
                                            Forgot your password? Click <a href="../password">here</a>&nbsp;&nbsp;
                                            <input type="submit" class="btn btn-default" value="Login" />
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
            </div>';
    }

    // Checks inputted credentials against credentials in database, throws error if there's a login/connection issue
    function checkLogin($username, $password) {
        try {
            $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
            // Exceptions fire when occur
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $adminPasswordQuery = $connection->prepare('
                        SELECT PASSWORD FROM ' . ADMIN_CREDENTIAL_TABLE . ' 
                        WHERE EMAIL = :username');
            
            $adminPasswordQuery->execute(array('username' => $username));
            
            $adminPasswordResult = $adminPasswordQuery->fetch();
            // If no matches
            if (!$adminPasswordResult) {
                $memberPasswordQuery = $connection->prepare('
                        SELECT PASSWORD FROM ' . USER_CREDENTIAL_TABLE . ' 
                        WHERE MEMBER_EMAIL = :username AND ACTIVESTATUS = 1');
                
                $memberPasswordQuery->execute(array('username' => $username));
                $memberPasswordResult = $memberPasswordQuery->fetch();
                
                if (!$memberPasswordResult) {
                    return FALSE;
                }
                elseif (crypt($password, $memberPasswordResult[0]) === $memberPasswordResult[0]) {
                    return "member";
                }
            }
            else {
                // Checks to see if applying hashed password as salt onto inputted password and hashing equals to hashed password
                if (crypt($password, $adminPasswordResult[0]) === $adminPasswordResult[0]) {
                    return "admin";
                }
                else {
                    return FALSE;
                }
            }
        }
        // Script halts and throws error if exception is caught
        catch(PDOException $e) {
            echo "
            <div>
                Error: " . $e->getMessage() . 
            "</div>";
            
            return FALSE;
        }
    }
?>