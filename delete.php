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

<?php
require 'db.php';
//$host = "localhost";
//$username = "root";
//$password = "ubuntu";
//$database = "Devices";
//$port = "161";



// Create connection
$conn = mysqli_connect($host, $username,$password,$database,$port);

// Check connection
if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
} 
echo "Connected successfully";
echo "<div style=\"float:left; width:50%\">";
$table = "SELECT * FROM asgn2 ORDER BY id;";
$result = mysqli_query($conn,$table);
$aid = array();
echo "<h3>SERVERS</h3>";
echo "<form action=\"\" method=\"post\"> ";
if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
                      $id = $row["id"];
                      $IP = $row["IP"];
                      

                      echo"<input type = \"checkbox\" name=\"value[]\" value=\"$id,$IP\">$IP <br>";

}

}
echo "</br><input type=\"submit\"></form>";
if (isset($_POST["value"])){

            foreach ($_POST["value"] as $f){
                                $exp = explode (",",$f);
                                $id = $exp[0];
                                $IP = $exp[1];
                                
                                array_push ($aid,$id);
            }
}
foreach ($aid as $id){
$sql = "DELETE FROM asgn2 WHERE id=$id";
$result1 = mysqli_query($conn,$sql);
}
echo "</div>";

echo "<div style=\"float:right; width:50%; \">";

$table1 = "SELECT * FROM asgn2devices ORDER BY id;";
$result1 = mysqli_query($conn,$table1);
$aid1 = array();
echo "<h3>DEVICES</h3>";
echo "<form action=\"\" method=\"post\"> ";
if (mysqli_num_rows($result1) > 0) {
     while($row = mysqli_fetch_assoc($result1)) {
     
                      $id = $row["id"];
                      $IP = $row["IP"];
                      $PORT = $row["PORT"];
                      $COMMUNITY = $row["COMMUNITY"];
                      $Interfaces = $row["Interfaces"];
                      
                       
                    $int = explode (",",$Interfaces);
                      
                      
                      echo"<input type = \"checkbox\" name=\"value1[]\" value=\"$IP,$PORT,$COMMUNITY,$id\">$IP <br>";
                                                 
                      
                      
     }
     }
echo "</br><input type=\"submit\"></form>";

if (isset($_POST["value1"])){

            foreach ($_POST["value1"] as $m){
                            
                            $exp1 = explode (",",$m);
                                $IP = $exp1[0];
                                $PORT = $exp1[1];
                                $COMMUNITY = $exp1[2];
                                $id = $exp1[3];
                                array_push ($aid1,$id);
                                echo "$id<br>";
}
}
foreach ($aid1 as $id){
$sql1 = "DELETE FROM asgn2devices WHERE id=$id";
$result2 = mysqli_query($conn,$sql1);
}
echo "</div>";

?>
