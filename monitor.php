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

$table = "SELECT * FROM assign2devices ORDER BY id;";
$result = mysqli_query($conn,$table);
echo "<h3>DEVICES</h3>";
echo "<form action=\"\" method=\"post\"> ";
 if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
                      $id = $row["id"];
                      $IP = $row["IP"];
                      $PORT = $row["PORT"];
                      $COMMUNITY = $row["COMMUNITY"];
                      $Interfaces = $row["interfaces"];
                      echo " $IP,$PORT,$COMMUNITY</br>";
                      
                      $int = explode ("&",$Interfaces);
                      echo "<h3>INTERFACES</h3>";
                      foreach ($int as $x){
                      echo"<input type = \"checkbox\" name=\"value[]\" value=\"$x,$IP,$PORT,$COMMUNITY,$id\">$x <br>";
                      }
                     
}
}
echo "<h3>period of graph</h3>";
echo"<input type = \"checkbox\" name=\"graph[]\" value=\"-1h\">daily \n";
echo"<input type = \"checkbox\" name=\"graph[]\" value=\"-1w\">weekly \n"; 
echo"<input type = \"checkbox\" name=\"graph[]\" value=\"-1m\">monthly \n"; 
echo"<input type = \"checkbox\" name=\"graph[]\" value=\"-1y\">yearly \n"; 
 echo "</br><input type=\"submit\"></form>";


#interface graph

if (isset($_POST["value"]) && isset($_POST["graph"])){
$period = $_POST["graph"];
$per = $period[0];

$opts = array( "--start", "$per",
                   "--title= Graph ",
                    "--vertical-label=Bytes/sec","COMMENT: \\t\\t\\t\\tMAXIMUM\\t",
					"COMMENT:  AVERAGE\\t",
					"COMMENT:  LAST\\n",);
 foreach($_POST["value"]as $f){
 
 $EX = explode (",",$f);


$N = $EX[0];
$IP = $EX[1];
$PORT = $EX[2];
$COMMUNITY = $EX[3];
$id = $EX[4];



$file = "device$IP$PORT$COMMUNITY.rrd";
 $bytesin = "bytesIn".$N;
 $bytesout = "bytesOut".$N;
 
 $hexa = "#".dechex(rand(16, 255)).dechex(rand(16,  255)).dechex(rand(16,  255));
$hexa1 = "#".dechex(rand(16,255)).dechex(rand(16,  255)).dechex(rand(16,  255));
 
 array_push($opts,"DEF:inBytes$id$N=$file:bytesIn$N:AVERAGE",
                "DEF:outBytes$id$N=$file:bytesOut$N:AVERAGE",
                "VDEF:last_in$id$N=inBytes$id$N,LAST",
	        "VDEF:last_out$id$N=outBytes$id$N,LAST",
	        
		"LINE1:inBytes$id$N$hexa:inbytes-$IP-$N",
		"GPRINT:inBytes$id$N:MAX: %6.2lf %SBps",
		"GPRINT:inBytes$id$N:AVERAGE: %6.2lf %SBps",
		"GPRINT:inBytes$id$N:LAST: %6.2lf %SBps\\n",
		"LINE2:outBytes$id$N$hexa1:Outbytes-$IP-$N",
		"GPRINT:outBytes$id$N:MAX: %6.2lf %SBps ",
		"GPRINT:outBytes$id$N:AVERAGE: %6.2lf %SBps",
		"GPRINT:outBytes$id$N:LAST: %6.2lf %SBps\\n");
 
 }   
 $ret = rrd_graph ("graph.png",$opts);
              if( !is_array($ret) )
  {
    $err = rrd_error();
    echo "rrd_graph() ERROR: $err\n";
  }
 
 
 }
 echo "<div style=\"float: left; margin-right:30px;\">";
  echo "<img src=graph.png >";
  echo "</div>";
 
  echo "</div>";   
#graph device

echo "<div style=\"float:right; width:50%; \">";

$table1 = "SELECT * FROM asgn2 ORDER BY id;";
$result1 = mysqli_query($conn,$table1);
echo "<h3>DEVICES</h3>";
echo "<form action=\"\" method=\"post\"> ";
if (mysqli_num_rows($result1) > 0) {
     while($row1 = mysqli_fetch_assoc($result1)) {
     
                        $id = $row1["id"];
                      $IP = $row1["IP"];
                      echo "$id,$IP<br>";
                      echo"<input type = \"checkbox\" name=\"device[]\" value=\"$IP,$id\">$IP <br>";
                      
}
}
echo "<h3>parameter</h3>";
                      echo"<input type = \"checkbox\" name=\"parameter[]\" value=\"cpuload\">cpuload <br>";
                      echo"<input type = \"checkbox\" name=\"parameter[]\" value=\"uptime\">uptime <br>";
                      echo"<input type = \"checkbox\" name=\"parameter[]\" value=\"reqpersec\">reqpersec <br>";
                      echo"<input type = \"checkbox\" name=\"parameter[]\" value=\"bytespersec\">bytespersec <br>";
                      echo"<input type = \"checkbox\" name=\"parameter[]\" value=\"bytesperreq\">bytesperreq <br>";
echo "<h3>period of graph</h3>";
echo"<input type = \"checkbox\" name=\"graph1[]\" value=\"-1h\">daily \n";
echo"<input type = \"checkbox\" name=\"graph1[]\" value=\"-1w\">weekly \n"; 
echo"<input type = \"checkbox\" name=\"graph1[]\" value=\"-1m\">monthly \n"; 
echo"<input type = \"checkbox\" name=\"graph1[]\" value=\"-1y\">yearly \n"; 
echo "</br><input type=\"submit\"></form>";


if (isset($_POST["device"])&& isset($_POST["graph1"])&& isset($_POST["parameter"])){

$perio = $_POST["graph1"];
$tim = $perio[0];
echo "$tim<br>";
$opts1 = array( "--start", "$tim",
                   "--title= Graph ",
                    "--vertical-label=Bytes/sec","COMMENT: \\t\\t\\t\\tMAXIMUM\\t",
					"COMMENT:  AVERAGE\\t",
					"COMMENT:  LAST\\n",);
	foreach($_POST["device"]as $k){
                         
                         $EXP = explode (",",$k);
                         $IP = $EXP[0];
                         $id = $EXP[1];	
                         $file = "$IP.rrd";
                         $hexa = "#".dechex(rand(16, 255)).dechex(rand(16,  255)).dechex(rand(16,  255));
                         
                         foreach ($_POST["parameter"] as $para){
                         if (strcmp($para, "bytesperreq") == 0)
													{
													$l="SB";
													} 
													elseif (strcmp($para, "reqpersec") == 0)
													{
													$l="Srps";
													} 
													elseif (strcmp($para, "cpuload") == 0)
													{
													$l='S%%';
													} 
													else 
													{
													$l="SBps";
													} 
                         array_push($opts1,"DEF:$para$id=$file:$para$id:AVERAGE",
                "VDEF:last_$para$id=$para$id,LAST",
		"LINE1:$para$id$hexa:$para$id-$IP",
		"GPRINT:$para$id:MAX: %6.2lf %$l",
		"GPRINT:$para$id:AVERAGE: %6.2lf %$l",
		"GPRINT:$para$id:LAST: %6.2lf %$l\\n");
		}
	
}

$ret1 = rrd_graph ("graph1.png",$opts1);
              if( !is_array($ret1) )
  {
    $err = rrd_error();
    echo "rrd_graph() ERROR: $err\n";
  }
}
echo "<div style=\"float: left; margin-right:30px;\">";
  echo "<img src=graph1.png >";
  echo "</div>";
echo "</div>"; 
?>




</body>
</html>
