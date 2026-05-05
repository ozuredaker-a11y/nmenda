<?php

require_once './config/config.php';

// Open a database connection
$pdo = new PDO('sqlite:' . BASE_PATH . '/data/db/blacklist.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create the 'blacklist' table if it doesn't exist
$pdo->exec("CREATE TABLE IF NOT EXISTS blacklist (
    ip_address TEXT PRIMARY KEY,
    blocked_at TEXT
)");

// Handle IP blocking if provided in URL
if (isset($_GET['ip_address'])) {
    $ip_to_block = $_GET['ip_address'];
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO blacklist (ip_address, blocked_at) VALUES (:ip, :time)");
    $stmt->execute(['ip' => $ip_to_block, 'time' => date('Y-m-d H:i:s')]);
    header("Location: blacklist.php");
    exit();
}

// Handle IP unblocking
if (isset($_POST['unblock'])) {
    $ip_to_unblock = $_POST['unblock'];
    $stmt = $pdo->prepare("DELETE FROM blacklist WHERE ip_address = :ip");
    $stmt->execute(['ip' => $ip_to_unblock]);
    header("Location: blacklist.php");
    exit();
}

// Handle manual IP blocking
if (isset($_POST['block_ip'])) {
    $ip_to_block = $_POST['block_ip'];
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO blacklist (ip_address, blocked_at) VALUES (:ip, :time)");
    $stmt->execute(['ip' => $ip_to_block, 'time' => date('Y-m-d H:i:s')]);
    header("Location: blacklist.php");
    exit();
}

// Pagination setup
$perPage = 15;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

// Fetch blocked IPs with pagination
$stmt = $pdo->query("SELECT COUNT(*) FROM blacklist");
$totalRecords = $stmt->fetchColumn();
$totalPages = ceil($totalRecords / $perPage);

$stmt = $pdo->prepare("SELECT * FROM blacklist ORDER BY blocked_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $start, PDO::PARAM_INT);
$stmt->execute();
$blocked_ips = $stmt->fetchAll(PDO::FETCH_ASSOC);

$currentDateTime = date('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html>

<head>
    <title>IP Blacklist Management</title>
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
    <h1>IP Blacklist Management</h1>

    <form method="POST">
        <label for="block_ip">Block IP:</label>
        <input type="text" id="block_ip" name="block_ip" placeholder="Enter IP to block" required>
        <input type="submit" value="Block IP">
    </form>

    <p>Current date and time: <?php echo $currentDateTime; ?></p>
    <p>Total blocked IPs: <?php echo $totalRecords; ?></p>

    <table>
        <tr>
            <th>IP Address</th>
            <th>Blocked At</th>
            <th>Action</th>
        </tr>
        <?php foreach ($blocked_ips as $ip): ?>
            <tr>
                <td><?php echo htmlspecialchars($ip['ip_address']); ?></td>
                <td><?php echo htmlspecialchars($ip['blocked_at']); ?></td>
                <td>
                    <form method="POST" style="margin: 0; padding: 0; border: none;">
                        <input type="hidden" name="unblock" value="<?php echo htmlspecialchars($ip['ip_address']); ?>">
                        <input type="submit" value="Unblock">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</body>

</html>