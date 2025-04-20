<?php
session_start();

function setMod($pass) {
  $cpassword = "123"; // put your password here, this IS NOT SECURE. DO NOT PUT A PASSWORD YOU USE HERE. For now I'll, mr-ahner, shall put 123 lulz
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
