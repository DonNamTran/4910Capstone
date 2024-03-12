<?php include "../../../inc/dbinfo.inc"; ?>
<?php
        session_start();
        if(!$_SESSION['login'] != 0) {
            echo "Invalid page.<br>";
            echo "Redirecting.....";
            sleep(2);
            header( "Location: http://team05sif.cpsc4911.com/", true, 303);
            exit();
            //unset($_SESSION['login']);
        }
    ?>
<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d1;
  margin: 0;
  padding: 0;
  height: auto;
  width: auto;
}

h1 {
  text-align: left;
  margin-left: 5%;
  margin-top: 15%;
  font-family: "Monaco", monospace;
  /*font-size: 3em;*/
  font-size: 2.5vmax;
  color: #FEF9E6;
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #0A1247;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1.5%;
  margin-left: 2%
}

.grid-container {
  display: grid;
  grid-template-columns: 32% 32% 32%;
  gap: 30px;
  background-color: #fff5d1;
  padding: 10px;
}

.grid-container > div {
  background-color: #FEF9E6;
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}

/*form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

#hyperlink-wrapper {
  text-align: center;
  margin-top: 20px;
}

#hyperlink {
  text-align: center;
  justify-content: center;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
  margin-top: 10px;
}*/


form {
  text-align: center;
  margin: 20px 0px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 30%;
  padding: 12px 20px;
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
}

#hyperlink-wrapper {
  text-align: center;
  margin-top: 20px;
}

#hyperlink {
  text-align: center;
  justify-content: center;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
  margin-top: 10px;
}

.navbar {
  overflow: hidden;
  background-color: #FEF9E6;
  font-family: "Monaco", monospace;
  margin-bottom: -2.5%;
}

.navbar a {
  float: left;
  font-size: 16px;
  font-family: "Monaco", monospace;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #fff5d1;
;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.menu { 
  float: none;
  color: black;
  font-size: 16px;
  margin: 0;
  text-decoration: none;
  display: block;
  text-align: left;
} 
.menu a{ 
  float: left;
  overflow: hidden;
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 12px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
} 

.point_info {
  font-size: 16px;
  color: black;
  font-family: monospace;
  margin: 0;
  position: absolute; 
  top: 0px; 
  right: 5px;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 160px;
  background-color: #ff5e6c;
}
</style>
</head>
<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
  </div>
</div>

<body>

<div class="point_info">
    <body>
    Your Points: 
    <?php 
        if(strcmp($_SESSION['account_type'], "driver") != 0) {
            echo "Unavailable";
        }else{
            $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
            $database = mysqli_select_db($connection, DB_DATABASE);
            
            $username = $_SESSION['username'];
            
            $result2 = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_username = '$username' AND driver_archived=0");
            
            while($info=$result2->fetch_assoc()) {
                echo $info['driver_points'];
            }
            
            
        }
    ?><br>
    Dollar->Point: 
    <?php 
        //get sponsor name
        $currSponsor = $_SESSION['user_data'][$_SESSION['account_type']."_associated_sponsor"];
        $username = $_SESSION['user_data'][$_SESSION['account_type']."_username"];
        //var_dump($currSponsor);
        //make new connection
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        
        $result2 = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username = '$currSponsor'");
        
        while($rows=$result2->fetch_assoc())
        {
            echo "$" . $rows['organization_dollar2pt'] . ":1";
        }
    ?>
</div>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Catalog</h1>
   </div>
</div>
<ul>
  <li>
    <div class="dropdown" style="margin-top: .75%" >
      <button class="dropbtn" style="background-color: #FEF9E6"><p style="font-size: 1vmax">Sort By Type</p> 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/catalog/catalog_home.php?type=all"><p style="font-size: 1vmax">See All</p></a>
        <a href="/S24-Team05/catalog/catalog_home.php?type=movie"><p style="font-size: 1vmax">See Movies</p></a>
        <a href="/S24-Team05/catalog/catalog_home.php?type=album"><p style="font-size: 1vmax">See Albums</p></a>
      </div>
    </div>
  </li>
  <li>
    <div class="dropdown" style="margin-top: .75%" >
      <button class="dropbtn" style="background-color: #FEF9E6"><p style="font-size: 1vmax">Sort By Name</p> 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/catalog/catalog_home.php?type=a-z"><p style="font-size: 1vmax">Sort A-Z</p></a>
        <a href="/S24-Team05/catalog/catalog_home.php?type=z-a"><p style="font-size: 1vmax">Sort Z-A</p></a>
      </div>
    </div>
  </li>
  <li>
    <div class="dropdown" style="margin-top: .75%" >
      <button class="dropbtn" style="background-color: #FEF9E6"><p style="font-size: 1vmax">Sort By Date</p> 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/catalog/catalog_home.php?type=newest"><p style="font-size: 1vmax">Newest First</p></a>
        <a href="/S24-Team05/catalog/catalog_home.php?type=oldest"><p style="font-size: 1vmax">Oldest First</p></a>
      </div>
    </div>
  </li>
  <li>
    <div class="dropdown" style="margin-top: .75%" >
      <button class="dropbtn" style="background-color: #FEF9E6"><p style="font-size: 1vmax">Sort By Popularity</p> 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/catalog/catalog_home.php?type=mostpopular"><p style="font-size: 1vmax">Most Popular</p></a>
        <a href="/S24-Team05/catalog/catalog_home.php?type=leastpopular"><p style="font-size: 1vmax">Least Popular</p></a>
      </div>
    </div>
  </li>
</ul>
<?php
  // Get the type to sort by (albums, movies etc.)
  if (isset($_GET['type'])) {
    $type = $_GET['type'];
  } else {
      $type = 'all';
  }

  // Reload the page differently based on the type
  if ($type === 'movie') {
    // Get items in the catalog
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' AND catalog_item_type = 'movie'");
  } elseif ($type === 'album') {
    // Get items in the catalog
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' AND catalog_item_type = 'album'");
  } elseif($type === 'a-z') {
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' ORDER BY catalog_item_name");
  } elseif($type === 'z-a') {
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' ORDER BY catalog_item_name DESC");
  } elseif($type === 'newest') {
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' ORDER BY catalog_item_release_date DESC");
  } elseif($type === 'oldest') {
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' ORDER BY catalog_item_release_date");
  } elseif($type === 'mostpopular') {
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' ORDER BY catalog_purchases DESC");
  } elseif($type === 'leastpopular') {
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor' ORDER BY catalog_purchases");
  }  else {
    // Get items in the catalog
    $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$currSponsor'");
  }

?>
<div class = "grid-container">
  <?php
  while($rows=$result->fetch_assoc())
  {
  ?>
    <div class = "item">
    <?php

      $item_name = $rows['catalog_item_name'];
      $artist_name = $rows['catalog_item_artist'];
      $item_price = $rows['catalog_item_point_cost'];
      $item_release_date = $rows['catalog_item_release_date'];
      $rating = $rows['catalog_item_rating'];
      $item_type = $rows['catalog_item_type'];

      $item_image = base64_encode(file_get_contents($rows['catalog_item_image']));
      echo '<h2><img src="data:image/jpeg;base64,'.$item_image.'"></h2>';
      if($item_type == "album") {
        echo "<p>Album Name: $item_name</p>";
        echo "<p>Artist Name: $artist_name</p>";
        echo "<p>Album Point Cost: $item_price</p>";
      } else if ($item_type == "movie") {
        echo "<p>Movie Name: $item_name</p>";
        echo "<p>Director: $artist_name</p>";
        echo "<p>Movie Point Cost: $item_price</p>";
      }
      echo "<p>Release Date: $item_release_date</p>";
      if($rating != NULL) {
        echo "<p>Content Advisory Rating: $rating</p>";
      }

      // Store data for buy now button
      ?>
      <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/buy_now.php" method="post">
            <input type="hidden" name="item_image" value="<?= $rows['catalog_item_image'] ?>">
            <input type="hidden" name="item_name" value="<?= $item_name ?>">
            <input type="hidden" name="item_artist" value="<?= $artist_name ?>">
            <input type="hidden" name="item_price" value="<?= $item_price ?>">
            <input type="hidden" name="item_release_date" value="<?= $item_release_date ?>">
            <input type="hidden" name="advisory_rating" value="<?= $rating ?>">
            <input type="hidden" name="item_type" value= "<?= $item_type?>">
            <input type="submit" class="link" value="Buy Now"/>
      </form>
    </div>
    <?php
  }
  ?>
</div>
</body>

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>
</body>
</html>