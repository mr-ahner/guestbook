# GuestBook
Welcome to the GuestBook software. To run on your website, put guestbook.php on your server, plus two txt files, ips.txt, and messages.txt. And one folder /rt/. The folder
helps with rate limiting, and saves each and every users ip as a .txt file called "limit_$ip.txt", this saves the last time stamp of the poster, and sixty seconds later, it will allow them to post. If they try to post 
before the sixty seconds is up, it will just display on screen, "stop fucking spamming", and will till the sixty seconds are up. To ip-ban someone, create a file called bannedusers.txt in your rt directory, and put the users IP in it, it will display
a message that says "your banned ret*rd" with a anime picture laughting at them.

# Users
If you happen to use nazbook, please email me your website and I shall link it in the Live example section. email me at "tim@tim-ahner.com" timattim-ahnerdotcom.

# People
tim : https://tim-ahner.com       
ver-dev :

# Live example
https://tim-ahner.com/guestbook.php
