<?php
session_start();
if (!isset($_SESSION['mod'])) {
  die("you are not a mod :)");
}

echo "<h1>mod panel</h1>";

function banuser() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ip']) && isset($_POST['action']) && $_POST['action'] === 'ban') {
    $banusersfile = fopen("../rt/bannedusers.txt", "a") or die("Unable to open file!");
    $ips = trim($_POST['ip']);
    $ip = $ips . "\n";
    fwrite($banusersfile, $ip);
    fclose($banusersfile);
    header("Location: index.php");
    exit;
  }
}

function unbanuser() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ip']) && isset($_POST['action']) && $_POST['action'] === 'unban') {
    $file = "../rt/bannedusers.txt";
    $ipToRemove = trim($_POST['ip']);

    if (file_exists($file)) {
      $banned = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $updated = array_filter($banned, fn($line) => trim($line) !== $ipToRemove);

      file_put_contents($file, implode("\n", $updated) . "\n");
    }

    header("Location: index.php");
    exit;
  }
}
// call the funcs
banuser();
unbanuser();
?>
<form method='post'>
  <input type='text' name='ip' placeholder='IP'><br/>
  <input type='hidden' name='action' value='ban'>
  <input type='submit' value='Ban user'>
</form>
<?php
$banned_users = "../rt/bannedusers.txt";
if(file_exists($banned_users)) {
      $banned_users2 = file($banned_users, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      if(count($banned_users2) > 0) {
        echo "<ul>";
        foreach ($banned_users2 as $ip) {
            $safe = htmlspecialchars($ip);
            echo "<li>$safe
             <form method='post' style='display:inline'>
          <input type='hidden' name='ip' value='$safe'>
          <input type='hidden' name='action' value='unban'>
          <input type='submit' value='Unban'>
        </form>
      </li>";
    }
        echo "</ul>";
    } else {
        echo "no banned users";
    }
} else {
    echo "no banned users";
}
?>
