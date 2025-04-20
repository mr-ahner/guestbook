<?php
session_start();

function setMod($pass) {
  $cpassword = "123"; // put your password here, this IS NOT SECURE. DO NOT PUT A PASSWORD YOU USE HERE. For now I'll, mr-ahner, shall put 123 lulz
  if ($password === $cpassword) {
    $_SESSION['mod'] = true;
    return "mod is in session";
  } else {
    return "not true password :(";
  }
}


?>
<form method="post">
    <input type="password" name="password" placeholder="mod password">
    <button type="submit">set mod</button>
</form>
