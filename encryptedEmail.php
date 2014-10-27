<!doctype html>

<html>
  
  <head>
    <title>Encrypted Email</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootswatch/3.0.0/cerulean/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  </head>
  
  <body>
    <div class="container">
      <div class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand"><b>willie618</b></a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li>
                <a href="index.php">Home</a>
              </li>
              <li>
                <a href="downloads.php">Downloads</a>
              </li>
              <li class="active">
                <a href="encryptedEmail.php">Encrypted Email</a>
              </li>
              <li>
                <a href="about.php">About</a>
              </li>
              <li>
                <a href="contact.php">Contact</a>
              </li>
            </ul>
          </div>
          <div class="row"></div>
        </div>
      </div>
          <div class="container">
      <header>
        <h1>Encrypted Email</h1>
      </header>
      <div class="container">
        <form action="displayEmail.php" method="POST">
          <div class="row">
            <div class="col-xs-6 col-md-4">
              <input type="email" class="form-control input-sm" placeholder="Email Address" name="email" maxlength="255">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 col-md-4">
              <input type="password" class="form-control input-sm" placeholder="Email Password" name="epass" maxlength="255">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 col-md-4">
              <input type="password" class="form-control input-sm" placeholder="Account Password" name="apass" maxlength="255">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-2 col-md-4">
              <input type="submit" class="btn btn-primary" name="login" value="Login"/>
            </div>
          </div>
        </form>
      </div>
  </body>
</html>

<?php

$db_server = "mysql.willie618.com";
//$db_server = "encryptedEmail.db";
$db_user = "encryptemail";
$db_pass = "testpass";

$db_connection = mysql_connect($db_server, $db_user, $db_pass);

if(!$db_connection) {
  $errmsg = mysql_error($db_connection);
  echo "Connection failed: " . $errmsg . "<br />";
  exit(1);
}
else
  echo "Connection succeeded.<br />";

$db_name = "willie618_db";
$db_query = "SELECT email_address FROM user";

mysql_select_db($db_name, $db_connection);
$rs = mysql_query($db_query, $db_connection) or die(mysql_error());
$num = mysql_num_fields($rs);

echo "<table border=1 cellspacing=1 cellpadding=2>";

$f = 0;
$field = mysql_field_name($rs, 0);
echo "<tr>";
while($f < $num) {
  echo "<td><B>".mysql_field_name($rs, $f)."</B></td>";
  $f++;
}
echo "</tr>";

while($row = mysql_fetch_row($rs)) {
  echo "<tr>";
  $i = 0;
  while($i < $num) {
    if(!is_null($row[$i])) {
      echo "<td>".$row[$i]."</td>";
    }
    else {
      echo "<td>N/A</td>";
    }
    $i++;
  }
  echo "</tr>";
}
echo "</table>";

mysql_close($db_connection);

echo "Connection closed.<br />";
?>
