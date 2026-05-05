<?php

// Note: This file should be included first in every PHP page.
error_reporting(E_ALL);
ini_set('display_errors', 'Off');

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

$aIcwpHttpsServerOpts = array('HTTP_CF_VISITOR', 'HTTP_X_FORWARDED_PROTO');

foreach ($aIcwpHttpsServerOpts as $sOption) {
    if (isset($_SERVER[$sOption]) && (strpos($_SERVER[$sOption], 'https') !== false)) {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_PORT'] = 443;
        break;
    }
}

define('BASE_PATH', realpath(__DIR__ . '/..'));
// define('APP_PATH', basename(BASE_PATH));

function findAppRootRelativePath()
{
    $documentRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $currentDir = str_replace('\\', '/', __DIR__);

    while (!file_exists($currentDir . '/.approot')) {
        $currentDir = dirname($currentDir);
        if ($currentDir === '/' || $currentDir === $documentRoot) {
            // Reached the filesystem root or document root, marker file not found
            return null;
        }
    }

    // Return the relative path from the document root
    return trim(substr($currentDir, strlen($documentRoot)), '/');
}

$appRootRelativePath = findAppRootRelativePath();
define('APP_PATH', $appRootRelativePath);

define('SESSION_URL', ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . APP_PATH);
// define('SESSION_URL', ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://') . '127.0.0.1' . '/' . APP_PATH);

define('EMBED', true);
define('GOOGLE_ANALYTICS_PROPERTY_ID', '');

define('EMBED_PATH', 'embed');

require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/helpers/helpers.php';

/*
|--------------------------------------------------------------------------
| TELEGRAM CONFIGURATION
|--------------------------------------------------------------------------
 */

define('BOT_API_KEY', "7628667064:AAGLjZAuziUOGsqGEaWOmPU7w5M-fzV2wDM");
define('CHAT_ID', "-4956352803");

/*
|--------------------------------------------------------------------------
| PROXY CONFIGURATION
|--------------------------------------------------------------------------
 */

define('PROXY', ""); // Proxy IP:PORT or HOST:PORT
define('PROXYUSERPWD', ""); // If your proxy requires authentication (username:password)
define('CAINFO', ''); // CA certificate path
