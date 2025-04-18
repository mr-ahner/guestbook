<?php
//pagination newest.
$messages = array_reverse(file('messages.txt', FILE_IGNORE_NEW_LINES)); //latest first
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

    <meta name="robots" content="index, follow">

    <link rel="canonical" href="">

    <link rel="icon" href="" type="image/x-icon">
</head>
<body>
    <div class="content">
        <center>
            <div class="container">
                <?php
                // guestbook!
                ini_set('display_errors', '1');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);
                //function sendMessage does as it says 
                // if $_POST then it does so
                function sendMessage() {
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $username = ($_POST['username']);
                        $message = ($_POST['message']);
                        $date = date('Y-m-d');  
                        $messagesFile = fopen("messages.txt", "a") or die("Unable to open file!");
                        $txt = "<div class='message'>" . $username . ": " . $message . "\n at: " . $date . "\n </div>";
                        fwrite($messagesFile, $txt);
                        fclose($messagesFile);
                            header("Location: index.php");
                
                    }
                }
                sendMessage();
                // func displayMessages is currently commeted out, due to pagination. Just keeping this here for my mental sake.
                //function displayMessages() {
                    
                   // $messages = file_get_contents("messages.txt");
                    
                   // if (empty(trim($messages))) {
                     //   echo "No Guestbook Messages";
                 //   } else {
                     //   echo "" . nl2br($messages) . "</div>";
               //     }
                }
                ?>
                <style>
                body {cursor: -webkit-default cursor: default;}

                    input {
                        border-radius: 10px;
                        color: red;
                        border: 1px dotted red;
                        background-color: black;
                        cursor: -webkit-default cursor: default;
                    }
                    .message {
                         border: 1px dotted red;
                        width: fit-content;
                            color: red;
                            transition: all 0.3s ease;
                            cursor: -webkit-default cursor: default;
                        }
                        
                    .message:hover {
                            transform: scale(1.5); 
                            cursor: -webkit-default cursor: default;
                            background-color:black;
                    }
                </style>
                <h2>&#x1F449;&#x1F448;</h2>
                <form method="POST" action="">    
                    <input type="text" name="username" placeholder="Username">
                    <br />
                    <input type="text" name="message" placeholder="Message">
                    <br />
                    <input type="hidden" name="date">
                    <br />
                    <input type="submit" value="Send Message!">
                </form>
                
                <?php
                echo"<h3>GuestBook Messages</h3>";
                if (empty($msgshow)) {
                    echo "no gb messages";
                } else {
                    foreach ($msgshow as $msg) {
                        echo "<p>$msg</p>";
                    }
                }
                echo "<br />";
             echo "<div class='pagination'>";
                for ($i = 1; $i <= $total_p; $i++) {
                    if ($i === $page) {
                        echo "<strong>$i</strong>";
                    } else {
                        echo "<a href='?page=$i'>$i</a>";
                    }
                }
                echo "</div>";
                ?>
            </div>
        </center>
    </div>
</body>
</html>
