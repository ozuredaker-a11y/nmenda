<?php

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Vectorface\Whip\Whip;

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

// Assuming SQLite database file 'visitors.db' and a table 'visitors'
// Table 'visitors' structure should include columns like 'session_id', 'url', 'redirect', 'last_visit'

// Open a database connection
$pdo = new PDO('sqlite:' . BASE_PATH . '/data/db/visitors.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

$sessionId = $_GET['session_id'] ?? '';
if (empty($sessionId)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No session ID provided']);
    exit;
}

$response = [];
$currentTime = time();

// Retrieve visitor data and update last visit time
$stmt = $pdo->prepare("SELECT session_id, url, redirect, last_visit FROM visitors WHERE session_id = :session_id");
$stmt->execute(['session_id' => $sessionId]);

if ($visitor = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $response = [
        'url' => $visitor['url'],
        'redirect' => (bool)$visitor['redirect'],
    ];

    // Update the last visit time
    $updateStmt = $pdo->prepare("UPDATE visitors SET last_visit = :last_visit WHERE session_id = :session_id");
    $updateStmt->execute(['last_visit' => $currentTime, 'session_id' => $sessionId]);
}

// Close the database connection
$pdo = null;

header('Content-Type: application/json');
echo json_encode($response);
