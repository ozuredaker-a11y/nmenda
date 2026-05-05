<?php

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Vectorface\Whip\Whip;

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

// Assuming SQLite database file 'visitors.db' and a table 'visitors'
// Table 'visitors' structure should include a column for 'is_active' (INTEGER)

// Open a database connection
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

$currentTime = time();

// Update the is_active status for each visitor
$updateStmt = $pdo->prepare("UPDATE visitors SET is_active = CASE WHEN :current_time - last_visit <= 3 THEN 1 ELSE 0 END");
$updateStmt->execute(['current_time' => $currentTime]);

$perPage = 15; // Number of results to show per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number
$filterDate = isset($_GET['date']) ? $_GET['date'] : null; // Get the filter date

$start = ($page - 1) * $perPage; // Calculate the offset

$sql = "SELECT * FROM visitors";
$sqlCount = "SELECT COUNT(*) FROM visitors"; // For counting total records
$params = [];

// Apply date filter if set
if ($filterDate !== null) {
    $sql .= " WHERE DATE(created_at) = :filterDate";
    $sqlCount .= " WHERE DATE(created_at) = :filterDate";
    $params[':filterDate'] = $filterDate;
}

$sql .= " ORDER BY is_active DESC, last_visit DESC, created_at DESC";

// Add LIMIT and OFFSET directly in the query string
$sql .= " LIMIT " . $perPage . " OFFSET " . $start;

$selectStmt = $pdo->prepare($sql);

// Execute with the parameters (without LIMIT and OFFSET)
$selectStmt->execute($params);
$tableData = $selectStmt->fetchAll(PDO::FETCH_ASSOC);

$countStmt = $pdo->prepare($sqlCount);
$countStmt->execute($params);
$totalRecords = $countStmt->fetchColumn();
$totalPages = ceil($totalRecords / $perPage);

// Close the database connection
$pdo = null;

// Display visitor count for today or filtered date
$today = date('Y-m-d');
$today_visitors = $filterDate === null || $filterDate === $today ? $totalRecords : 0;
$visitor_counter_string = $filterDate === null ? "Today's visitors: $today_visitors" : "Visitors on $filterDate: $totalRecords";

$currentDateTime = date('Y-m-d H:i:s');
$paginationQueryString = $filterDate ? "?date=" . htmlspecialchars($filterDate) . "&page=" : "?page=";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Visitor Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        form {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form label,
        form input {
            margin-right: 10px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            padding: 10px;
        }

        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #4caf50;
            color: white;
            border: 1px solid #4caf50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <h1>Visitor Data</h1>

    <form method="GET">
        <label for="date">Filter by date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($filterDate); ?>">
        <input type="submit" value="Filter">
    </form>

    <p>Current date and time: <?php echo $currentDateTime; ?></p>
    <p><?php echo $visitor_counter_string; ?></p>

    <table>
        <tr>
            <th>Session ID</th>
            <th>IP Address</th>
            <th>Country Code</th>
            <th>Country Name</th>
            <th>Region Name</th>
            <th>City Name</th>
            <th>Zip Code</th>
            <th>User Agent</th>
            <th>Active</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($tableData as $row) : ?>
            <tr>
                <td><?php echo $row['session_id']; ?></td>
                <td><?php echo $row['ip_address']; ?></td>
                <td><?php echo $row['country_code']; ?></td>
                <td><?php echo $row['country_name']; ?></td>
                <td><?php echo $row['region_name']; ?></td>
                <td><?php echo $row['city_name']; ?></td>
                <td><?php echo $row['zip_code']; ?></td>
                <td><?php echo $row['user_agent']; ?></td>
                <td style="text-align: center;"><?php echo $row['is_active'] ? '<font color="green" size="6">&#9679;</font>' : '<font color="red" size="6">&#9679;</font>'; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><a href="blacklist.php?ip_address=<?php echo urlencode($row['ip_address']); ?>" target="_blank">Block IP</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($totalPages > 1) : ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="<?php echo $paginationQueryString . $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</body>

</html>