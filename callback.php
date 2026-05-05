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
$url = $_GET['url'] ?? '';
$redirect = isset($_GET['redirect']) && $_GET['redirect'] === 'true' ? 1 : 0;

// Check if the session already exists
$stmt = $pdo->prepare("SELECT COUNT(*) FROM visitors WHERE session_id = :session_id");
$stmt->execute(['session_id' => $sessionId]);
$sessionExists = $stmt->fetchColumn() > 0;

if ($sessionExists) {
    // Update existing session
    $updateStmt = $pdo->prepare("UPDATE visitors SET url = :url, redirect = :redirect WHERE session_id = :session_id");
    $updateStmt->execute(['url' => $url, 'redirect' => $redirect, 'session_id' => $sessionId]);
    echo 'Session updated successfully.';
} else {
    // Insert new session
    $insertStmt = $pdo->prepare("INSERT INTO visitors (session_id, url, redirect) VALUES (:session_id, :url, :redirect)");
    $insertStmt->execute(['session_id' => $sessionId, 'url' => $url, 'redirect' => $redirect]);
    echo 'New session added.';
}
