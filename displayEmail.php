<?php
$email_username = $_POST['email'];
$email_password = $_POST['epass'];
$account_password = $_POST['apass'];
$public;
$e_private;
$d_private;

echo $email_username . "</br>";
echo $email_password . "</br>";
echo $account_password . "</br>";

$db_server = "mysql.willie618.com";
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
$db_query = "SELECT * FROM user WHERE email_address='" . $email_username . "';";

mysql_select_db($db_name, $db_connection);
$rs = mysql_query($db_query, $db_connection) or die(mysql_error());
$num = mysql_num_rows($rs);
if($num == 0) {
	echo "Email address not found.</br>";
}
else {
	$row = mysql_fetch_row($rs);
	$public = $row[1];
	$e_private = $row[2];
	$d_private = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $account_password, base64_decode($e_private), MCRYPT_MODE_ECB);
	echo $public . "</br>";
	echo $d_private . "</br>";
}

mysql_close($db_connection);

echo "MySQL connection closed.<br />";

//Source code from: http://stackoverflow.com/questions/15242455/connect-gmail-through-php-imap

$hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
$inbox = imap_open($hostname,$email_username,$email_password) or die('Cannot connect to Gmail: ' . imap_last_error());
$emails = imap_search($inbox,'ALL');

if($emails){
	$output = "";
	rsort($emails);
	foreach($emails as $email_number) {
		$overview = imap_fetch_overview($inbox, $email_number, 0);
		$message = imap_fetchbody($inbox,$email_number,2);

	    $output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
	    $output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
	    $output.= '<span class="from">'.$overview[0]->from.'</span>';
	    $output.= '<span class="date">on '.$overview[0]->date.'</span>';
	    $output.= '</div>';

	    $output.= '<div class="body">'.$message.'</div>';
	}

	echo $output;
}

imap_close($inbox);

echo "IMAP connection closed.<br />";

?>