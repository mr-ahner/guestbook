<?php
// this part blocks mobile users, you can keep it, I use it.
// function mobile() {
//     return preg_match('/Mobile|Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']);
// }  

// if (mobile()) {
//   die("I don't like mobile users >:(");
// }

// for banned users, add ip it /rt/bannedusers.txt.
$bannedip = $_SERVER['REMOTE_ADDR'];
$banned = file(__DIR__  . '/rt/bannedusers.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (in_array($bannedip, $banned)) {
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <title>Banned</title>
        <style>
            body { background: black; color: red; font-size: 30px;}
        </style>
    </head>
    <body>
        <center>
        your banned retard
        <br>
        <img src="https://files.catbox.moe/dmj4wp.gif">
        </center>
    </body>
</html>');
    
}


function ipInRange($ip, $cidr) {
list($subnet, $mask) = explose('/', $cidr);
return (ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == (ip2long($subnet) & ~((1 << (32 - $mask)) - 1));
}
/
/* 
THIS IS FOR BLOCKING IP RANGES. YOU NEED A .ZONE FILE FOR THE COUNTRY. https://www.ipdeny.com/ipblocks/ IS WHERE I GOT MY .ZONE FILES
ON MY WEBSITE, I CURRENTLY BLOCK NO COUNTRY, BUT THAT MIGHT CHANGE.
function countryip($ip) { 
// .zone is for the ip ranges
$isrealcidrs = file(__DIR__ . '.zone', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($isrealcidrs as $cidr) {
if (ipInRange($ip, $cidr)) {
  return true;
}
}
return false; 
}

$ip = $_SEVER['REMOTE_ADDR'];
if (countryip($ip)) {
  http_response_code(403);
  exit ("Denied. I dislike where you live. :3 <br> <img src='https://files.catbox.moe/egvrmh.png'>");
}
*/
// to stop bots don't mind the referer I am working on that.
$useragent = $_SERVER['HTTP_USER_AGENT'];
//$referer =$_SERVER['HTTP_REFERER'];
if(empty($useragent) || strpos($useragent, 'curl') !== false || strpos($useragent, 'bot') !== false) {
    die ("no bots allowed");
}
function storeuseragent() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $uafile = "./rt/useragents.txt";
    $openfile = fopen($uafile, "a");
    if ($openfile) {
        fwrite($openfile, $useragent . PHP_EOL);
        fclose($openfile);
    } else {
        error_log("Could not open file for writing: $uafile");
    }
}

// error reporting is not good really for production, but if you are getting 500s, uncomment this.
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
//pagination newest.
$messages = array_reverse(file('messages.txt')); //latest first
$mppage = 10;
$total_m = count($messages);
$total_p = ceil($total_m / $mppage);

$page =  isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($total_p, $page)); // stays for 10

$start = ($page - 1) * $mppage;
$msgshow = array_slice($messages, $start, $mppage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title></title>
    <meta name="robots" content="index, follow">
          <style>
            body {
            cursor: -webkit-default
            cursor: default; 
            background-color:BLACK; 
            color: red;
            }
            input, textarea {
            border-radius: 10px;
            color: red;
            border: 1px dotted red;
            background-color: black;
            cursor: -webkit-default cursor: default;
            }
            .messages {
            width: fit-content;
            color: red;
            cursor: -webkit-default cursor: default;
            }
    </style>
    <link rel="canonical" href="">

    <link rel="icon" href="" type="image/x-icon">
</head>
<body>
    <div class="content">
        <center>
            <div class="container">
                <?php
                // guestbook!
                //function sendMessage does as it says 
                // if $_POST then it does so
                function sendMessage() {
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $file = "messages.txt";
                        // this banned word list is for lulz, you can delete this if you want idc
                        $words = ['idiot', 'dumbhead', 'dumbass'];
                        $replacement  = "fucking idiot dumbass";
                        if(file_exists($file)) {
                          $contents = file_get_contents($file);
                          foreach($words as $word) {
                          $content = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', $replacement, $contents);
                          }
                          file_put_contents($file, $contents);
                        } else {
                          echo "file not foudn:(";
                        }
                        $username = ($_POST['username']);
                        $message = ($_POST['message']);
                        $ip = $_SERVER['REMOTE_ADDR']; //mainly for the bots, and for future ip-banning, but you can get rid of this, just // it out.
                        $rl = 60; // rate limiting
                        $ip = preg_replace('/[^0-9a-fA-F.:]/', '_', $_SERVER['REMOTE_ADDR']); // gets ip
                        $rf = __DIR__ . "/rt/limit_$ip.txt"; // gets rt dir
                        if (file_exists($rf)) { // checking if it exists
                            $lps = (int)file_get_contents($rf);
                            $ct = time();
                            if ($ct - $lps < $rl) {
                                die("stop fucking spamming");
                            }
                        }
                        file_put_contents($rf, time());
                        $humantest = $_POST['skibidi']; //if a bot fills out a form, they will fill out everything, the user will not, becuase this is hidden, allowing me to see what is a bot and what is not. 
                        $date = date('Y-m-d');  
                        if ($humantest !== "") {
                           $username = "BOT (GET OFF MY SITE)";
                        } else {
                            $username = htmlspecialchars($username);
                            $message = htmlspecialchars($message);
                        }
                        $ipfile = fopen("ips.txt", "a") or die("Unable to open file!");
                        $ips = $username . ":" . $ip . "\n";
                        fwrite($ipfile, $ips);
                        fclose($ipfile);
                        $messagesFile = fopen("messages.txt", "a") or die("Unable to open file!");
                        $txt = $username . ": " . $message . " at: " . $date . "\n";
                        fwrite($messagesFile, $txt);
                        file_put_contents($rf, time());
                        fclose($messagesFile);
                        header("Location: index.php");
                
                    }
                }
                sendMessage();
                ?>
                <h2>&#x1F449;&#x1F448;</h2>
                <form method="POST" action="">    
                    <input type="text" name="username" placeholder="Username">
                    <br />
                    <textarea type="text" name="message" placeholder="Message"></textarea>
                    <br />
                    <input type="hidden" name="date">
                    <input type="text" name="skibidi" style="display:none" autocomplete="off">
                    <input type="submit" value="Send Message!">
                </form>
                
                <?php
                echo "<div class='messages'>";
                echo"<h3>GuestBook Messages</h3>";
                if (empty($msgshow)) {
                    echo "no gb messages";
                } else {
                    foreach ($msgshow as $msg) {
                        echo "<p>$msg</p>";
                    }
                }
                echo "<br />";
                echo "<br>";
                for ($i = 1; $i <= $total_p; $i++) {
                    if ($i === $page) {
                        echo "<strong>$i</strong>";
                    } else {
                        echo "<a href='?page=$i'>$i</a>";
                    }
                }
                echo "</div>";
                $htter = "hits.txt";
                $hots = file_exists($htter) ? (int)file_get_contents($htter) : 0;
                $hots++;
                file_put_contents($htter, $hots);
                echo "guestbook has been viewed $hots times.";
                ?>
            </div>
        </center>
    </div>
</body>
</html>
