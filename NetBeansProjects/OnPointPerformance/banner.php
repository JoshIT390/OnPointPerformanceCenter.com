<?php
	define("DB_HOST_NAME", "mysql.dnguyen94.com");
    define("DB_USER_NAME", "ad_victorium");
    define("DB_PASSWORD", "MT8AlJAM");
    define("DB_NAME", "onpoint_performance_center_lower");
    
    try{
    $connection = new PDO("mysql:host=" . DB_HOST_NAME . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER_NAME, DB_PASSWORD);
    // Exceptions fire when occur
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = $connection->prepare('SELECT * FROM BANNER');
    $query->execute();
    //$result = $query->fetch_row();
    //var_dump($result);
    }
    catch(PDOException $e) {
            echo "
            <div>
                Error: " . $e->getMessage() . 
            "</div>";
            
            return FALSE;
        }
        
    for ($count=0; $count<1; $count++) 
	{
      $result = $query->fetch();
	  if($result[1] >= date("Y-m-d") ){
	  echo "<div class='alert alert-dismissible alert-danger' style = 'text-align:center;'>";
	  echo "<h1><Strong>" . $result[2] . ":</strong> " . $result[3] . "</h1>";
	  echo "</div>";
	  echo "</br>";
	  } 
	  else {
	  } 
	 }
?>