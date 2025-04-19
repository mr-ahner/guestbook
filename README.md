# GuestBook
Welcome to the GuestBook software. To run on your website, put guestbook.php on your server, plus two txt files, ips.txt, and messages.txt. And one folder /rt/. The folder
helps with rate limiting, and saves each and every users ip as a .txt file called "limit_$ip.txt", this saves the last time stamp of the poster, and sixty seconds later, it will allow them to post. If they try to post 
before the sixty seconds is up, it will just display on screen, "stop fucking spamming", and will till the sixty seconds are up. I'm currently working on IP banning.
