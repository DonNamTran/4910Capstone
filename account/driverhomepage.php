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
  color: #FF0000;
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

form {
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
}
</style>
</head>
<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>About</h1>
      <h1> </h1>
      <h1>Page</h1>
   </div>
</div>
    <?php
        session_start();
        if(!$_SESSION['login'] && strcmp($_SESSION['account_type'], "driver") != 0) {
            echo "Invalid page.<br>";
            echo "Redirecting.....";
            sleep(5);
            header( "Location: http://team05sif.cpsc4911.com/", true, 303);
            exit();
            //unset($_SESSION['login']);
        } else {

        }

        list($name, $password) = explode(':', $_COOKIE['remember_user']);
        echo "<script>console.log($name);console.log($password);</script>";
    ?>
</body>

</html>