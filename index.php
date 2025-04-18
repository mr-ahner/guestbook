
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
            <img class="pfp" src="https://files.catbox.moe/z4qhrw.png">
            <br />
            <div class="container">
            <h2>verbrechen</h2><br />
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
                //function displayMessages does as it says 
                // if it's empty, say it is, if not  display messages.
                function displayMessages() {
                    
                    $messages = file_get_contents("messages.txt");
                    
                    if (empty(trim($messages))) {
                        echo "No Guestbook Messages";
                    } else {
                        echo "" . nl2br($messages) . "</div>";
                    }
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
                displayMessages();
                echo "<br />";
                ?>
            </div>
        </center>
    </div>
</body>
</html>
