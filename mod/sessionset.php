<?php
session_start();
require ("helpme.php");
function setMod($pass) {
  $cpassword = $fuckyou; // in helpme.php define this variable for password 
  if ($pass === $cpassword) {
    $_SESSION['mod'] = true;
    return "mod is in session";
  } else {
    return "not true password :(";
  }
}
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $message = setMod($_POST['password']);
}

?>
<form method="post">
    <input type="password" name="password" placeholder="mod password">
    <button type="submit">set mod</button>
</form>
<p><?php echo htmlspecialchars($message); ?></p>
<hr>
<pre>
<?php

var_dump($_SESSION)
?>
</pre>
