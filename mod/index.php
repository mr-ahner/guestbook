<?php
if (isset($_SESSION['mod'])) {
  die ("you are not a mod :)");
} 

echo "<h1>mod panel</h1>";

function banuser() {
  $banusersfile = fopen("../rt/bannedusers.txt", "a") or die("Unable to open file!");
  $ips = $_POST['ip'];
  $ip = $ips . "\n";
  fwrite($banusersfile, $ip);
  fclose($banusersfile);
  header ("Location: index.php");
}
banuser(); 

echo "<form method='post'>";
echo "<input type='text' name='ip'> <br/>";
echo "<input type='submit'>";
echo "</form>";

?>
