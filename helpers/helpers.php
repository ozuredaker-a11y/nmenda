<?php

/**
 * Translates Latin characters to Cyrillic characters in a given subject.
 *
 * @param string $subject The subject to be translated.
 * @param bool $whitespace Flag to indicate whether to replace whitespace characters or not. Default is false.
 * @return string The translated subject with Cyrillic characters.
 */
function getCyrillicAlphabet($subject, $whitespace = false)
{
	$search =	["A", "a", "B", "E", "e", "M", "H", "O", "o", "P", "p", "C", "c", "T", "X", "x", "I", "i"];
	$replace =	["А", "а", "В", "Е", "е", "М", "Н", "О", "о", "Р", "р", "С", "с", "Т", "Х", "х", "І", "і"];

	if ($whitespace) {
		$search[] = " ";
		$replace[] = "‏‏‎‎  ";
	}

	return nl2br(str_replace($search, $replace, $subject));
}

/**
 * Retrieves the card information based on the given BIN.
 * @param string $bin The BIN to be used for the lookup.
 * @param string|null $proxy The proxy to be used for the request.
 * @param string|null $proxyUserPwd The proxy user and password to be used for the request.
 * @return array The card information.
 */
function getCardInfo($bin, $proxy = null, $proxyUserPwd = null, $caCertPath = null)
{
	$ch = curl_init();

	$url = "https://lookup.binlist.net/$bin";

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

	// Disable SSL verification (optional; use cautiously in production)
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// Set the required header
	$headers = array();
	$headers[] = 'Accept-Version: 3';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	// If a proxy is provided, configure cURL to use it
	if ($proxy) {
		curl_setopt($ch, CURLOPT_PROXY, $proxy);

		// If the proxy requires authentication
		if ($proxyUserPwd) {
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyUserPwd);
		}
	}

	// If a CA certificate is provided, set the CAINFO option
	if ($caCertPath) {
		curl_setopt($ch, CURLOPT_CAINFO, $caCertPath);
		// Ensure SSL verification is enabled when using a CA certificate
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	}

	// Execute the request
	$output = curl_exec($ch);

	if (curl_errno($ch)) {
		echo 'Error: ' . curl_error($ch);
	}

	curl_close($ch);

	return json_decode($output, true);
}

/**
 * Retrieves the country name based on the given country code.
 * @param string $countryCode The country code to be used for the lookup.
 * @return string The country name.
 */
function country2flag(string $countryCode): string
{
	return (string) preg_replace_callback(
		'/./',
		static fn(array $letter) => mb_chr(ord($letter[0]) % 32 + 0x1F1E5),
		$countryCode
	);
}
