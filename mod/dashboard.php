<?php
// small dashboard
if (!isset['mod']) {
  die ("nu nu mod :9");
} 
echo "<h2>ip list</h2>";
$iusersfile = fopen("../ips.txt", "r") or die("unable to list ips");
echo fread($iusersfile,filesize("../ips.txt"));
fclose($iusersfile);
echo "<hr>";
?>
