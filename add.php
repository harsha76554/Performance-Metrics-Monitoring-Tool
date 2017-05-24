<?php

//$host = "localhost";
//$username = "root";
//$password = "ubuntu";
//$database = "Devices";
//$port = "161";

require 'db.php';

// Create connection
$conn = mysqli_connect($host, $username,$password,$database,$port);

// Check connection
if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
} 
echo "Connected successfully";

//selecting table

$ctable = "CREATE TABLE IF NOT EXISTS assign2devices (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    IP varchar(30) NOT NULL,
    PORT int(11) NOT NULL,
    COMMUNITY varchar(255) NOT NULL,
    Interfaces varchar(48000) NOT NULL,
    UNIQUE key(IP,PORT,COMMUNITY)
    
)";


if (mysqli_query($conn,$ctable)){
             echo "created";
}else{
      echo "Error:".$insert."<br>". mysqli_error($conn); 
}

?>

<html>
<head>
     <title>Assignment-2 </title>
     <style type="text/css">
body
{
background: #E0E0E0;
}
</style>
</head>
<body>

<table style="width:60%" border="1" cellpadding="1" cellspacing="1">
    <tr>
    <th><a href='add.php'>ADD</a></th>
    <th><a href='delete.php'>DELETE</a></th>
    <th><a href='monitor.php'>MONITOR</a></th>
    
</tr>
</table>


<form action="" method="post">
<h3>Server</h3>

IP : <input type = "text" name="server"> <br>
<input type="submit">
</form>
<?php
if (isset($_POST["server"])){
$IP = $_POST["server"];
$insert = "INSERT IGNORE INTO asgn2 (IP) VALUES ('$IP');";

if (mysqli_query($conn, $insert)){
             echo "IP entered success";
}else{
      echo "Error:".$insert."<br>". mysqli_error($conn); 
}}
?>
<form action="" method="post">
<h3>Device</h3>

IP : <input type = "text" name="IP"> <br>
PORT : <input type = "text" name="PORT"> <br>
COMMUNITY : <input type = "text" name="COMMUNITY"> <br>
<input type="submit">
</form>
<?php
if (isset($_POST["IP"]) && isset($_POST["PORT"]) && isset($_POST["COMMUNITY"])){
$IP = $_POST["IP"];
$PORT = $_POST["PORT"];
$COMMUNITY = $_POST["COMMUNITY"];
$insert = "INSERT IGNORE INTO assign2devices (IP,PORT,COMMUNITY) VALUES ('$IP','$PORT','$COMMUNITY');";

if (mysqli_query($conn, $insert)){
             echo "IP entered success";
}else{
      echo "Error:".$insert."<br>". mysqli_error($conn); 
}

echo "$IP\n, $PORT\n, $COMMUNITY\n";

$a = snmpwalk("$IP:$PORT", "$COMMUNITY", "1.3.6.1.2.1.2.2.1.1"); 
echo "<form action=\"\" method=\"post\">
<h3>INTERFACES</h3>";
foreach ($a as $val) {
    $b = explode (" ", $val);
    echo"<input type = \"checkbox\" name=\"value[]\" value=\"$b[1],$IP,$COMMUNITY,$PORT\">$b[1] <br>";
    
}

echo "<input type=\"submit\">
</form>";
}

if (isset($_POST["value"])){
$push = array ();

foreach($_POST["value"]as $f){


$EX = explode (",",$f);

$N = $EX[0];
$IP = $EX[1];
$PORT = $EX[3];
$COMMUNITY = $EX[2];

array_push($push,$N);
 
}


$cra= implode ("&",$push);


$upd = "UPDATE assign2devices SET Interfaces='$cra' WHERE IP='$IP' AND PORT='$PORT' AND COMMUNITY='$COMMUNITY';";

if (mysqli_query($conn, $upd)){
            echo "IP entered success";
}else{
    echo "Error:".$upd."<br>". mysqli_error($conn); 
}


}

?>

</body>
</html>

