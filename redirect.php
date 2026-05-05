<?php

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use IP2Location\Database;
use Vectorface\Whip\Whip;
// Import StrGen
use PHLAK\StrGen;

session_start();
require_once './config/config.php';

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

$file = BASE_PATH . '/data/json/visitors.json';

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

$whip = new Whip();
$clientAddress = $whip->getValidIpAddress();

$records = $db->lookup($clientAddress, Database::ALL);

$pdo = new PDO('sqlite:' . BASE_PATH . '/data/db/visitors.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create the 'visitors' table if it doesn't exist
$pdo->exec("CREATE TABLE IF NOT EXISTS visitors (
    session_id TEXT PRIMARY KEY,
    url TEXT,
    redirect INTEGER,
    is_active INTEGER,
    last_visit INTEGER,
    ip_address TEXT,
    country_code TEXT,
    country_name TEXT,
    region_name TEXT,
    city_name TEXT,
    zip_code TEXT,
    user_agent TEXT,
    created_at TEXT
)");

// Get the current date
$date = date('Y-m-d H:i:s');

// Create a visitor data array
$visitor_data = [
    'session_id' => session_id(),
    'url' => '',
    'redirect' => 0, // false = 0, true = 1 in SQLite
    'ip_address' => $records['ipAddress'],
    'country_code' => $records['countryCode'],
    'country_name' => $records['countryName'],
    'region_name' => $records['regionName'],
    'city_name' => $records['cityName'],
    'zip_code' => $records['zipCode'],
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
    'is_active' => 1,
    'last_visit' => time(),
    'created_at' => date('Y-m-d H:i:s'), // assuming $date is defined earlier
];

// Check if the session already exists in the database
$stmt = $pdo->prepare("SELECT COUNT(*) FROM visitors WHERE session_id = :session_id");
$stmt->execute(['session_id' => $visitor_data['session_id']]);
$sessionExists = $stmt->fetchColumn() > 0;

if ($sessionExists) {
    // Update existing visitor's last_visit and is_active
    $updateStmt = $pdo->prepare("UPDATE visitors SET last_visit = :last_visit, is_active = :is_active WHERE session_id = :session_id");
    $updateStmt->execute([
        'last_visit' => $visitor_data['last_visit'],
        'is_active' => $visitor_data['is_active'],
        'session_id' => $visitor_data['session_id']
    ]);
} else {
    // Insert new visitor
    $insertStmt = $pdo->prepare("INSERT INTO visitors (session_id, url, redirect, ip_address, country_code, country_name, region_name, city_name, zip_code, user_agent, is_active, last_visit, created_at) VALUES (:session_id, :url, :redirect, :ip_address, :country_code, :country_name, :region_name, :city_name, :zip_code, :user_agent, :is_active, :last_visit, :created_at)");
    $insertStmt->execute($visitor_data);
}

// Close the database connection
$pdo = null;

// Initialize the Generator
$generator = new StrGen\Generator();

$_SESSION["filename"] = $_SESSION["filename"] ?? [];

include BASE_PATH . '/src/init.php';

$parsed_url = parse_url((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
$port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
$user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
$pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
$pass = ($user || $pass) ? "$pass@" : '';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logging in, please wait...</title>
    <script type="text/javascript">
        // Simulate a mouse click:
        window.location.href = "<?php echo "$scheme$user$pass$host$port/" . APP_PATH . '/' . EMBED_PATH; ?>?url=" + btoa("<?php echo "$scheme$user$pass$host$port" . '/' . APP_PATH . '/' . str_replace('.php', '', $init); ?>?" + decodeURI(window.location.hash.substr(1)).replace(/\s/g, ''));
    </script>
</head>

<body>
    <p>Logging in, please wait...</p>
</body>

</html>