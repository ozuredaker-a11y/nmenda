<?php
// Your security key
$securityKey = "0RTfTw9Pxf";

// Check if the key is correct
if (isset($_GET['key']) && $_GET['key'] == $securityKey) {
    // Path to your configuration file
    $configPath = './config/config.php';

    // Read the contents of the file
    $configContents = file_get_contents($configPath);

    $isEmbedEnabled = strpos($configContents, "define('EMBED', true);") !== false;

    if ($isEmbedEnabled) {
        // Toggle from true to false
        $configContents = str_replace("define('EMBED', true);", "define('EMBED', false);", $configContents);
        $message = "EMBED is now deactivated.";
        $color = "red";
    } else {
        // Toggle from false to true
        $configContents = str_replace("define('EMBED', false);", "define('EMBED', true);", $configContents);
        $message = "EMBED is now activated.";
        $color = "green";
    }

    // Write the modified content back to the file
    file_put_contents($configPath, $configContents);
    ?>
    
    <font color="<?= $color ?>" size="6">●</font> <?= $message ?>

    <?php
} else {
    echo "<div style='font-family: Arial, sans-serif; color: red;'>Invalid security key.</div>";
}
?>
